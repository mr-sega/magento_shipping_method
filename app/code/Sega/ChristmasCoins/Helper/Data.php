<?php

namespace Sega\ChristmasCoins\Helper;

use Sega\ChristmasCoins\Api\PointsRepositoryInterface;
use Sega\ChristmasCoins\Api\Data\PointsInterface;
use Sega\ChristmasCoins\Model\ResourceModel\Points\CollectionFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class Data extends AbstractHelper
{
    private const XML_PATH_MODULE_ENABLE = 'loyalty/general/enable';
    private const XML_PATH_ENABLE_PDP_MESSAGE = 'loyalty/general/enable_pdp_message';
    private const XML_PATH_COINSBACK_PERCENT = 'loyalty/general/coins_back_percent';

    private ?PointsInterface $loadedTransaction = null;
    private  $customerRepository;
    private  $pointsRepository;
    private  $currentCustomer;
    private  $collectionFactory;
    private  $priceHelper;

    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        PointsRepositoryInterface $pointsRepository,
        CurrentCustomer $currentCustomer,
        CollectionFactory $collectionFactory,
        \Magento\Framework\Pricing\Helper\Data $priceHelper
    ) {
        $this->priceHelper = $priceHelper;
        $this->customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
        $this->currentCustomer = $currentCustomer;
        $this->pointsRepository = $pointsRepository;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    public function getCustomerName()
    {
        $customerName = $this->customerSession->getCustomer()->getName();

        return $customerName;
    }

    public function DisplayChristmasCoinsMessage(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLE_PDP_MESSAGE)
            && $this->scopeConfig->isSetFlag(self::XML_PATH_MODULE_ENABLE);
    }

    public function calculateChristmasCoinsAmount(float $amount): float
    {
        $coinsBackValue = $this->scopeConfig->getValue(self::XML_PATH_COINSBACK_PERCENT) / 100;

        return $amount * $coinsBackValue;
    }

    public function getCoinsTransaction(): ?PointsInterface
    {
        if (! $this->loadedTransaction instanceof PointsInterface) {
            try {
                $this->loadedTransaction = $this->pointsRepository->getById(
                    (int) $this->_request->getParam('id')
                );
            } catch (NoSuchEntityException $e) {
                return null;
            }
        }

        return $this->loadedTransaction;
    }

    public function isModuleEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_MODULE_ENABLE);
    }

    /**
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\InputException
     */
    public function updateCoinsReceivedValue(
        PointsInterface $transaction,
        CustomerInterface $customer,
        array $data
    ) {
        $transaction->setCoinsReceived((float) $data['coins_received']);
        if ($transaction->dataHasChangedFor(PointsInterface::COINS_RECEIVED)) {
            $transaction->setAddedByAdmin(true);

            $currentCustomerCoins = $customer->getCustomAttribute('coins')->getValue() ?? 0;
            $oldCoinsReceivedValue = $transaction->getOrigData(PointsInterface::COINS_RECEIVED);
            $newCoinsReceivedValue = $data['coins_received'];
            $diff = $newCoinsReceivedValue - $oldCoinsReceivedValue;

            $customer->setCustomAttribute('coins', $currentCustomerCoins + $diff);

            $this->pointsRepository->save($transaction);
            $this->customerRepository->save($customer);
        }
    }

    public function getList(): array
    {
        $customerId = $this->currentCustomer->getCustomerId();
        if ($customerId === null) {
            return [];
        }
        /** @var \Sega\ChristmasCoins\Model\ResourceModel\Points\Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(PointsInterface::CUSTOMER_ID, $customerId);
        $items = $collection->getItems();

        $result = [];
        /** @var PointsInterface $item */
        foreach ($items as $item) {
            $result[] = [
                'occasion'         => $item->getAddedByAdmin() ? __('Added by admin') : $item->getOrderId(),
                'amountOfPurchase' => $this->priceHelper->currency($item->getAmountOfPurchase()),
                'coinsReceived'    => $item->getCoinsReceived(),
                'coinsSpend'       => $item->getCoinsSpend(),
                'dateOfPurchase'   => date('M d, Y h:i:s A', strtotime($item->getDateOfPurchase()))
            ];
        }

        return $result;
    }

    public function getCurrentCustomerTotalCoins(): float
    {
        $result = (float) $this->currentCustomer->getCustomer()->getCustomAttribute('coins')->getValue();

        return $result ?? 0.0;
    }
}
