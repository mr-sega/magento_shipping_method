<?php

namespace Meetanshi\Extension\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;
use Magento\Framework\Registry as CoreRegistry;
use Meetanshi\Extension\Model\ExtensionFactory;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Backend\Model\View\Result\Page;

class Edit extends Action
{
    protected $resultPageFactory;

    protected $extensionFactory;

    protected $extensionRepository;

    protected $coreRegistry;

    public function __construct(
        Context $context,
        CoreRegistry $coreRegistry,
        ResultPageFactory $resultPageFactory,
        ExtensionFactory $extensionFactory,
        ExtensionRepositoryInterface $extensionRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->extensionFactory = $extensionFactory;
        $this->coreRegistry = $coreRegistry;
        $this->extensionRepository = $extensionRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');


        $extension = $this->extensionFactory->create();

        if ($id) {
            $extension = $this->extensionRepository->getById($id);
            if (!$extension->getId()) {
                $this->messageManager->addErrorMessage(__('This post not exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('post', $extension);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($extension->getId() ? $extension->getName() . ' ' . 'Model: ' . $extension->getNotebook() : __('New Order'));
        return $resultPage;
    }


    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Meetanshi_Extension::post');
    }

}
