<?php

namespace Meetanshi\Extension\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const PATH_GENERAL = 'meetanshi/';

    protected $coreRegistry;

    public function isModuleEnable(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::PATH_GENERAL . 'general/enable',
            ScopeInterface::SCOPE_STORE,
            null);
    }

}
