<?php
namespace Meetanshi\Extension\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use Meetanshi\Extension\Api\Data\ExtensionInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;

class Delete extends Action implements HttpGetActionInterface
{

    protected $resultRedirectFactory;
    protected $_request;
    protected $messageManager;
    protected $resultFactory;
    protected $extensionRepository;

    public function __construct(
        Context $context,
         ExtensionRepositoryInterface $extensionRepository,
         RequestInterface $_request,
         ResultFactory $resultFactory,
         MessageManagerInterface $messageManager,
         ResultRedirectFactory $resultRedirectFactory
    ) {
        $this->extensionRepository = $extensionRepository;
        $this->_request = $_request;
        $this->resultFactory = $resultFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $id = $this->_request->getParam('id');
            $this->extensionRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('You deleted the post successful.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t delete record, Please try again."));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/', [ExtensionInterface::ID => $id]);
    }
}
