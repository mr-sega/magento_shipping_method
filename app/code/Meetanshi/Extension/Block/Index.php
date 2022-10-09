<?php

namespace Meetanshi\Extension\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Pricing\Helper\Data;
use \Meetanshi\Extension\Model\Extension;
use \Meetanshi\Extension\Model\ExtensionFactory;


class Index extends Template
{
    protected $extensionFactory;
    protected $priceHelper;

    public function __construct(
        Context $context,
        ExtensionFactory $extensionFactory,
        Data $priceHelper,
        array $data = [])
    {
        $this->extensionFactory = $extensionFactory;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    public function getCollection()
    {
        $collection = $this->extensionFactory->create();
        return $collection->getCollection();
    }

}
