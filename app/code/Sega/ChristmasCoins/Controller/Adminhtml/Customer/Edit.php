<?php

namespace Sega\ChristmasCoins\Controller\Adminhtml\Customer;

use Sega\ChristmasCoins\Helper\Data;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NotFoundException;

class Edit extends Action
{
    protected $helper;

    public const ADMIN_RESOURCE = 'Magento_Backend::system';

    public function __construct(
        Context $context,
        Data $helper)
    {
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        $transaction = $this->helper->getCoinsTransaction();
        if ($transaction === null || ! $this->helper->isModuleEnabled()) {
            throw new NotFoundException(__('Page Not Found.'));
        }

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
