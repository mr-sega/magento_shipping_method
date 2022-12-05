<?php

namespace Sega\ChristmasCoins\Controller\Index;

use Sega\ChristmasCoins\Helper\Data;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;

class Index implements HttpGetActionInterface
{
    private  $resultFactory;
    private  $currentCustomer;
    private  $helper;

    public function __construct(
        ResultFactory $resultFactory,
        CurrentCustomer $currentCustomer,
        Data $helper
    ) {
        $this->helper = $helper;
        $this->currentCustomer = $currentCustomer;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        if (! $this->currentCustomer->getCustomerId() || ! $this->helper->isModuleEnabled()) {
            throw new NotFoundException(__('Page Not Found.'));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
