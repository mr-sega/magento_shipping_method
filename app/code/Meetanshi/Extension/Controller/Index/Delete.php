<?php

namespace Meetanshi\Extension\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Meetanshi\Extension\Model\ExtensionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;

class Delete extends Action
{
    protected $resultPageFactory;
    protected $extensionFactory;
    protected $extensionRepository;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ExtensionFactory $extensionFactory,
        ExtensionRepositoryInterface $extensionRepository
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->extensionFactory = $extensionFactory;
        $this->extensionRepository = $extensionRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $id = $this->_request->getParam('id');
            $this->extensionRepository->deleteById($id);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t delete record, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;

    }
}
