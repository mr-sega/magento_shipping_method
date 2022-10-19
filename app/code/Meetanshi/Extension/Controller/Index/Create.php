<?php

namespace Meetanshi\Extension\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Meetanshi\Extension\Helper\Config as ConfigHelper;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;

class Create implements HttpGetActionInterface
{
    /**
     * @var ResultPageFactory
     */
    protected $resultPageFactory;

    protected $resultFactory;

    /**
     * @param Context $context
     * @param ResultPageFactory $resultPageFactory
     */
    public function __construct(
        ConfigHelper $configHelper,
        ResultPageFactory $resultPageFactory,
        ResultFactory $resultFactory

    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
    }


    public function execute()
    {
        if (!$this->configHelper->isModuleEnable()) {

            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
