<?php

namespace Meetanshi\Extension\Controller\Index;


use Magento\Framework\App\Action\Context;
use Meetanshi\Extension\Helper\Config as ConfigHelper;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;

class Index implements HttpGetActionInterface
{

    protected $resultPageFactory;
    protected $resultFactory;
    protected $configHelper;


    public function __construct(
        ResultPageFactory $resultPageFactory,
        ConfigHelper $configHelper,
        ResultFactory $resultFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->configHelper = $configHelper;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        if (!$this->configHelper->isModuleEnable()) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
