<?php

namespace Custom\ShippingMethod\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Psr\Log\LoggerInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Framework\ObjectManagerInterface;


class Custom extends AbstractCarrier implements CarrierInterface
{

    protected $_code = 'custom';

    protected $rateResultFactory;

    protected $rateMethodFactory;

    protected $_objectManager;

    public function __construct(
        ObjectManagerInterface $objectManager,
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        array $data = []
    )
    {
        $this->_objectManager = $objectManager;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function getAllowedMethods()
    {
        return ['custom' => $this->getConfigData('name')];
    }

    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        /** @var \Magento\Shipping\Model\Rate\Result $result */
        $result = $this->rateResultFactory->create();

        /** @var \Magento\Quote\Model\Quote\Address\RateResult\Method $method */
        $method = $this->rateMethodFactory->create();
        $method->setCarrier('custom');
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod('custom');
        $method->setMethodTitle($this->getConfigData('name'));


        $cart = $this->_objectManager->get('\Magento\Checkout\Model\Cart');

        $uniqueItems = $cart->getQuote()->getItemsCount();
        $totalItems = $cart->getQuote()->getItemsQty();
        $subTotal = $cart->getQuote()->getGrandTotal();

        $amount = $this->getConfigData('price');

        $countryRate = null;
        if ($request->getDestCountryId() == 'US'){
            $countryRate = 3;
        }elseif ($request->getDestCountryId() == 'UA'){
            $countryRate = 2;
        }elseif ($request->getDestCountryId() == 'CA'){
            $countryRate = 7;
        }else {
            $countryRate = 1;
        }


            $shippingPrice = ($subTotal * $uniqueItems * $amount) / $totalItems * $countryRate;


        $method->setPrice($shippingPrice);
        $method->setCost($amount);

        $result->append($method);

        return $result;
    }
}
