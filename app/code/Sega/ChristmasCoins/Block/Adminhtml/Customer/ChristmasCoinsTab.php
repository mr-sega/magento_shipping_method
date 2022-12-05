<?php

namespace Sega\ChristmasCoins\Block\Adminhtml\Customer;

use Sega\ChristmasCoins\Helper\Data;
use Magento\Ui\Component\Layout\Tabs\TabWrapper;
use Magento\Framework\View\Element\Context;

class ChristmasCoinsTab extends TabWrapper
{

    protected $helper;

    public function __construct(
        Context $context,
        Data $helper,
        array $data = [])
    {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    public function canShowTab(): bool
    {
        return $this->helper->isModuleEnabled();
    }

    public function getTabTitle(): \Magento\Framework\Phrase
    {
        return __('Customer Coins');
    }

    public function isAjaxLoaded(): bool
    {
        return true;
    }

    public function getTabUrl(): string
    {
        return $this->getUrl('coins/customer/grid', ['_current' => true]);
    }
}
