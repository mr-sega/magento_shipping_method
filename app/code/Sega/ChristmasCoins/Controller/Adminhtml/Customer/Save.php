<?php

namespace Sega\ChristmasCoins\Controller\Adminhtml\Customer;

use Sega\ChristmasCoins\Api\PointsRepositoryInterface;
use Sega\ChristmasCoins\Helper\Data;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\Message\ManagerInterface;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'Magento_Backend::system';

    protected $pointsRepository;
    protected $message;
    protected $customerRepository;
    protected $helper;

    public function __construct(
        Context $context,
        PointsRepositoryInterface $pointsRepository,
        ManagerInterface $message,
        CustomerRepositoryInterface $customerRepository,
        Data $helper
    ) {
        $this->pointsRepository = $pointsRepository;
        $this->customerRepository = $customerRepository;
        $this->message = $message;
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        $transactionId = (int) $this->_request->getParam('general')['id'];
        $customerId = (int) $this->_request->getParam('general')['customer_id'];
        try {
            $transaction = $this->pointsRepository->getById($transactionId);
            $customer = $this->customerRepository->getById($customerId);
        } catch (NoSuchEntityException|LocalizedException $e) {
            throw new NotFoundException(__('Page Not Found.'));
        }

        try {
            $this->helper->updateCoinsReceivedValue($transaction, $customer, $this->_request->getParam('general'));
            $this->message->addSuccessMessage(__('Value has been successfully updated.'));
        } catch (CouldNotSaveException|LocalizedException $e) {
            $this->message->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->message->addErrorMessage(__('Something went wrong.'));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('*/*/edit', ['id' => $transactionId]);
    }
}
