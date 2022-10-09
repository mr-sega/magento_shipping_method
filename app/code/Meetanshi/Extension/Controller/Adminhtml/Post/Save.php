<?php

namespace Meetanshi\Extension\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry as CoreRegistry;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;
use Meetanshi\Extension\Model\ExtensionFactory;

class Save extends Action implements HttpPostActionInterface
{
    protected $resultPageFactory;

    protected $resultRedirectFactory;

    protected $coreRegistry;

    protected $extensionFactory;

    protected $dataPersistor;

    protected $extensionRepository;


    public function __construct(
        Context $context,
        CoreRegistry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ResultRedirectFactory $resultRedirectFactory,
        ExtensionFactory $extensionFactory,
        ExtensionRepositoryInterface $extensionRepository
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->dataPersistor = $dataPersistor;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->extensionFactory = $extensionFactory;
        $this->extensionRepository = $extensionRepository;
        parent::__construct($context);
        $this->messageManager->getMessages(true);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $input = $this->getRequest()->getPostValue();

        if ($input) {
            $input['id'] = empty($input['id']) ? null  : $input['id'];
            $id = $input['id'];

            $extension = $this->extensionFactory->create();

            if ($id) {
                try {
                    $extension = $this->extensionRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $extension->setData($input);

            try {
                $this->extensionRepository->save($extension);
                $this->messageManager->addSuccessMessage(__('You post saved successfully! .'));
                $this->dataPersistor->clear('post');
                return $this->redirect($resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something wrong whith saving post.'));
            }

            $this->dataPersistor->set('post', $input);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function redirect($resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
