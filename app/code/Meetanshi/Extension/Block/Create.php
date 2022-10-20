<?php

namespace Meetanshi\Extension\Block;

use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\Extension\Model\ExtensionFactory;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;

class Create extends Template
{
    protected $extensionFactory;
    protected $extensionRepository;

    public function __construct(
        Context $context,
        ExtensionFactory $extensionFactory,
        ExtensionRepositoryInterface $extensionRepository,
        array $data = [])
    {
        $this->extensionFactory = $extensionFactory;
        $this->extensionRepository = $extensionRepository;
        parent::__construct($context, $data);
    }
}
