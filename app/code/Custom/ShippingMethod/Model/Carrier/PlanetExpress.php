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


class PlanetExpress extends AbstractCarrier implements CarrierInterface
{

    protected $_code = 'planetexpress';

    protected $rateResultFactory;

    protected $rateMethodFactory;

    protected $checkoutHelper;

    public function __construct(
        \Magento\Checkout\Helper\Data $checkoutHelper,
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        array $data = []
    )
    {
        $this->checkoutHelper = $checkoutHelper;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function getAllowedMethods()
    {
        return ['planetexpress' => $this->getConfigData('name')];
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
        $method->setCarrier($this->_code);
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->_code);
        $method->setMethodTitle($this->getConfigData('name'));


        $checkoutHelper = $this->checkoutHelper->getQuote();

        $uniqueItems = $checkoutHelper->getItemsCount();
        $totalItems = $checkoutHelper->getItemsQty();
        $subTotal = $checkoutHelper->getSubtotal();

        $amount = $this->getConfigData('price');

        $countryRate = 1;
        if ($request->getDestCountryId() == 'US'){
            $countryRate = 3;
        }elseif ($request->getDestCountryId() == 'UA'){
            $countryRate = 2;
        }elseif ($request->getDestCountryId() == 'CA'){
            $countryRate = 7;
        }

            $shippingPrice = ($subTotal * $uniqueItems * $amount) / $totalItems * $countryRate;

        $method->setPrice($shippingPrice);
        $method->setCost($amount);

        $result->append($method);

        return $result;
    }
}
