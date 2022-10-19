<?php

namespace Meetanshi\Extension\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\View\Element\Template;
use Meetanshi\Extension\Model\ExtensionFactory;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;

class Form extends Template
{
    private $extensionFactory;
    protected $extensionRepository;

    public function __construct(
        ExtensionRepositoryInterface $extensionRepository,
        ExtensionFactory $extensionFactory,
        Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->extensionFactory = $extensionFactory;
        $this->extensionRepository = $extensionRepository;
    }

    public function getFormAction()
    {
        return $this->getUrl('extension/index/submit', ['_secure' => true]);
    }

    public function getAllData()
    {
        $id = $this->getRequest()->getParam("id");
        $model = $this->extensionFactory->create();
        return $model->load($id);
    }
}
