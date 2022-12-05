<?php

namespace Sega\ChristmasCoins\Observer;

use Sega\ChristmasCoins\Helper\Data;
use Sega\ChristmasCoins\Model\CoinsPaymentMethod;
use Sega\ChristmasCoins\Model\Config\Settings;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;

class ChristmasCoinsPlaceOrderObserver implements ObserverInterface
{
    private  $helper;
    private  $currentCustomer;

    public function __construct(
        CurrentCustomer $currentCustomer,
        Data $helper
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->helper = $helper;
    }


    public function execute(Observer $observer)
    {
        if (! $this->currentCustomer->getCustomerId() || ! $this->helper->isModuleEnabled()) {
            return;
        }

        $paymentMethod = $observer->getOrder()->getPayment()->getMethod();
        if ($paymentMethod === Settings::CODE) {
            $customerCoinsAmount = $this->helper->getCurrentCustomerTotalCoins();

            $grandTotal = $observer->getOrder()->getGrandTotal();

            if ($customerCoinsAmount < $grandTotal) {
                throw new LocalizedException(__('You do not have enough christmas coins to buy'));
            }
        }
    }

}
