<?php

namespace Meetanshi\Extension\Controller\Index;

use Magento\Framework\App\Action\Context;
use Meetanshi\Extension\Api\Data\ExtensionInterface;
use Magento\Framework\View\Result\PageFactory;
use Meetanshi\Extension\Model\ExtensionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;

class Delete  implements HttpGetActionInterface
{
    protected $resultPageFactory;
    protected $extensionFactory;
    protected $resultFactory;
    protected $extensionRepository;
    protected $messageManager;
    protected $_request;

    public function __construct(
        ResultFactory $resultFactory,
        PageFactory $resultPageFactory,
        ExtensionFactory $extensionFactory,
        RequestInterface $_request,
        ExtensionRepositoryInterface $extensionRepository,
        MessageManagerInterface $messageManager
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->extensionFactory = $extensionFactory;
        $this->resultFactory = $resultFactory;
        $this->extensionRepository = $extensionRepository;
        $this->_request = $_request;
        $this->messageManager = $messageManager;
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
