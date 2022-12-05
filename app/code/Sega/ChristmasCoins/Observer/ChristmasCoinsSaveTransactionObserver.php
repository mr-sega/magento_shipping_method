<?php


namespace Sega\ChristmasCoins\Observer;

use Sega\ChristmasCoins\Api\PointsRepositoryInterface;
use Sega\ChristmasCoins\Helper\Data;
use Sega\ChristmasCoins\Model\CoinsPaymentMethod;
use Sega\ChristmasCoins\Model\Config\Settings;
use Sega\ChristmasCoins\Model\PointsFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

class ChristmasCoinsSaveTransactionObserver implements \Magento\Framework\Event\ObserverInterface
{
    private  $connection;
    private  $helper;
    private  $customerRepository;
    private  $message;
    private  $pointsFactory;
    private  $pointsRepository;

    public function __construct(
        ResourceConnection $connection,
        Data $helper,
        CustomerRepositoryInterface $customerRepository,
        ManagerInterface $message,
        PointsFactory $pointsFactory,
        PointsRepositoryInterface $pointsRepository
    ) {
        $this->pointsRepository = $pointsRepository;
        $this->pointsFactory = $pointsFactory;
        $this->message = $message;
        $this->customerRepository = $customerRepository;
        $this->helper = $helper;
        $this->connection = $connection;
    }

    public function execute(Observer $observer)
    {
        if (! $this->helper->isModuleEnabled()) {
            return;
        }

        /** @var \Magento\Sales\Model\Order\Invoice $invoice */
        $invoice = $observer->getInvoice();
        $customerId = $invoice->getCustomerId();

        try {
            $customer = $this->customerRepository->getById($customerId);
        } catch (NoSuchEntityException|LocalizedException|\Exception $e) {
            return;
        }

        $paymentMethod = $observer->getPayment()->getMethod();
        $grandTotal = $invoice->getGrandTotal();
        $coinsTransaction = $this->pointsFactory->create()
            ->setOrderId((int) $invoice->getOrderId())
            ->setCustomerId((int) $customerId)
            ->setAmountOfPurchase((float) $invoice->getGrandTotal())
            ->setDateOfPurchase($invoice->getOrder()->getCreatedAt());

        if ($paymentMethod === Settings::CODE) {
            $valueFromTransaction = -$grandTotal;
            $coinsTransaction->setCoinsSpend((float) $grandTotal);
        } else {
            $valueFromTransaction = $this->helper->calculateChristmasCoinsAmount((float) $grandTotal);
            $coinsTransaction->setCoinsReceived($valueFromTransaction);
        }

        $currentCustomerCoins = $customer->getCustomAttribute('coins')->getValue() ?? 0;
        $currentCustomerCoins += $valueFromTransaction;
        $customer->setCustomAttribute('coins', $currentCustomerCoins);

        $connection = $this->connection->getConnection();
        $connection->beginTransaction();
        try {
            $this->pointsRepository->save($coinsTransaction);
            $this->customerRepository->save($customer);

            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();

            $this->message->addErrorMessage(__('The bonus coins have not been obtained.'));
        }
    }
}
