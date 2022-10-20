<?php

namespace Meetanshi\Extension\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Meetanshi\Extension\Api\Data\ExtensionInterface;
use Meetanshi\Extension\Model\ExtensionFactory;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Form extends Template
{
    protected $filterBuilder;
    private $extensionFactory;
    protected $extensionRepository;
    protected $searchCriteriaBuilder;

    public function __construct(
        ExtensionRepositoryInterface $extensionRepository,
        ExtensionFactory $extensionFactory,
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->extensionFactory = $extensionFactory;
        $this->extensionRepository = $extensionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    public function getFormAction()
    {
        return $this->getUrl('extension/index/submit', ['_secure' => true]);
    }
}
