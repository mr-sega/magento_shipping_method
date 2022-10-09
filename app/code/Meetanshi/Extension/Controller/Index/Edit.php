<?php

namespace Meetanshi\Extension\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry as CoreRegistry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;

class Edit extends Action
{
    /**
     * @var ResultPageFactory
     */
    protected $resultPageFactory;

    /**
     * @var CoreRegistry
     */
    protected $coreRegistry;

    /**
     * @param Context $context
     * @param ResultPageFactory $resultPageFactory
     * @param CoreRegistry $coreRegistry
     */
    public function __construct(
        Context $context,
        ResultPageFactory $resultPageFactory,
        CoreRegistry $coreRegistry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }


    public function execute()
    {
        $id = $this->_request->getParam('id');
        $this->coreRegistry->register('editRecordId', $id);

        return $this->resultPageFactory->create();
    }
}
