<?php
namespace Meetanshi\Extension\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;

class Delete extends Action
{

    protected $resultRedirectFactory;

    protected $extensionRepository;

    public function __construct(
         Context $context,
         ExtensionRepositoryInterface $extensionRepository,
         ResultRedirectFactory $resultRedirectFactory
    ) {
        $this->extensionRepository = $extensionRepository;
        $this->resultRedirectFactory = $resultRedirectFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->extensionRepository->deleteById($id);

                $this->messageManager->addSuccessMessage(__('You deleted the post successful.'));

                return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
    }
        return $resultRedirect->setPath('*/*/');
    }
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Meetanshi_Extension::delete');
    }
}
