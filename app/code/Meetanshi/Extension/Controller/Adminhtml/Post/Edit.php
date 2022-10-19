<?php

namespace Meetanshi\Extension\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Catalog\Model\Session as CatalogSession;
use Meetanshi\Extension\Api\Data\ExtensionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory as ResultPageFactory;
use Meetanshi\Extension\Model\ExtensionFactory;
use Exception;
use Magento\Framework\Exception\NoSuchEntityException;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;

class Edit extends Action
{
    protected $resultPageFactory;

    protected $extensionFactory;

    protected $extensionRepository;

    protected $coreRegistry;

    public function __construct(
        Context $context,
        ResultPageFactory $resultPageFactory,
        ExtensionFactory $extensionFactory,
        CatalogSession  $catalogSession,
        ExtensionRepositoryInterface $extensionRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->extensionFactory = $extensionFactory;
        $this->catalogSession = $catalogSession;
        $this->extensionRepository = $extensionRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');


        $extension = $this->extensionFactory->create();
        try {
            if ($id) {
                $extension = $this->extensionRepository->getById($id);
                if (!$extension->getId()) {
                    $this->messageManager->addErrorMessage(__('This post not exists.'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $this->catalogSession->get('post', $extension);

            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend($extension->getId() ? $extension->getName() . ' ' . 'Model: ' . $extension->getNotebook() : __('New Order'));
            return $resultPage;
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('This Post not exists.'));
        }
        return $resultRedirect->setPath('*/*/');
    }


    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Meetanshi_Extension::post');
    }

}
