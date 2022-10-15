<?php

namespace Sega\ProductHeight\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class Height extends Template
{

    protected $_registry;

    public function __construct(
        Template\Context $context,
        Registry $registry
    ){
        $this->_registry = $registry;
        parent::__construct($context);
    }

    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
}
