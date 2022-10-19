<?php

namespace Meetanshi\Extension\Controller\Index;

use Meetanshi\Extension\Api\Data\ExtensionInterface;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Meetanshi\Extension\Helper\Config as ConfigHelper;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Model\Session as CatalogSession;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;

class Edit implements HttpGetActionInterface
{

    protected $resultFactory;
    protected $configHelper;
    protected $extensionRepository;
    protected $request;
    protected $catalogSession;
    protected $messageManager;


    public function __construct(
        ResultFactory                $resultFactory,
        ConfigHelper                 $configHelper,
        CatalogSession               $catalogSession,
        ExtensionRepositoryInterface $extensionRepository,
        RequestInterface             $request,
        MessageManagerInterface      $messageManager
    )
    {
        $this->resultFactory = $resultFactory;
        $this->configHelper = $configHelper;
        $this->extensionRepository = $extensionRepository;
        $this->request = $request;
        $this->catalogSession = $catalogSession;
        $this->messageManager = $messageManager;
    }


    public function execute()
    {
        if (!$this->configHelper->isModuleEnable()) {
            return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('defaultNoRoute');
        }
        {
            $id = $this->request->getParam(ExtensionInterface::ID);
            try {
                $this->catalogSession->get('id', $id);
                $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
                $resultPage->getConfig()
                    ->getTitle()
                    ->prepend((__('Edit Post')));
                return $resultPage;
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This post not exists.'));
            }
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
        }
    }
}
