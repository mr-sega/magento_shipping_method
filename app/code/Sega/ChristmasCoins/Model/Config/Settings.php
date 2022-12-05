<?php

namespace Sega\ChristmasCoins\Model\Config;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

class Settings implements ConfigProviderInterface
{
    const CODE = 'coins';

    const CHECKOUT_CONFIG_CODE = 'coins';
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var SessionFactory
     */
    private $sessionFactory;

    /**
     * Settings constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param SessionFactory $sessionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        SessionFactory $sessionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->sessionFactory = $sessionFactory;
    }

    /**
     * @param $paymentMethodCode
     * @return bool
     */
    public function getEnabledForStores()
    {
        $xmlConfigPath = "payment/" . self::CODE . "/active";
        try {
            $storeCode = $this->storeManager->getStore()->getCode();
        } catch (NoSuchEntityException $e) {
            return false;
        }
        return (bool)$this->scopeConfig->getValue($xmlConfigPath, ScopeInterface::SCOPE_STORE, $storeCode);
    }

    /**
     * @return string
     * @throws NoSuchEntityException
     */
    public function getCurrentStoreCode()
    {
        return $this->storeManager->getStore()->getCode();
    }

    /**
     * @param $xmlPath
     * @return mixed
     */
    protected function getValue($xmlPath)
    {
        return $this->scopeConfig->getValue($xmlPath, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return '';
    }

    /**
     * @inheritDoc
     * @return array
     */
    public function getConfig()
    {
        /**
         * @var Session $customer
         */
        $customer = $this->sessionFactory->create();
        return [
            'payment' => [
                self::CHECKOUT_CONFIG_CODE => [
                    'enable' => $this->getEnabledForStores() && $customer->getCustomerId(),
                    'logo' => $this->getLogo()
                ]
            ]
        ];
    }
}
