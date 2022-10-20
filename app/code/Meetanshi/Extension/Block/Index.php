<?php

namespace Meetanshi\Extension\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Pricing\Helper\Data;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use \Meetanshi\Extension\Model\Extension;
use \Meetanshi\Extension\Model\ExtensionFactory;
use Meetanshi\Extension\Model\ResourceModel\Extension\CollectionFactory;


class Index extends Template
{
    protected $extensionFactory;
    protected $extensionRepository;
    protected $extensionCollectionFactory;
    protected $priceHelper;

    public function __construct(
        ExtensionRepositoryInterface $extensionRepository,
        CollectionFactory $extensionCollectionFactory,
        Context $context,
        ExtensionFactory $extensionFactory,
        Data $priceHelper,
        array $data = [])
    {
        $this->extensionFactory = $extensionFactory;
        $this->extensionCollectionFactory = $extensionCollectionFactory;
        $this->extensionRepository = $extensionRepository;
        $this->priceHelper = $priceHelper;
        parent::__construct($context, $data);
    }

    public function getCollection()
    {
        $collection = $this->extensionCollectionFactory->create();

        return $collection->getItems();
    }
}
