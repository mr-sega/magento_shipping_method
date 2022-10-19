<?php

namespace Meetanshi\Extension\Block;

use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\Extension\Model\ExtensionFactory;

class Create extends Template
{
    protected $extensionFactory;

    public function __construct(
        Context $context,
        ExtensionFactory $extensionFactory,
        array $data = [])
    {
        $this->extensionFactory = $extensionFactory;
        parent::__construct($context, $data);
    }
}
