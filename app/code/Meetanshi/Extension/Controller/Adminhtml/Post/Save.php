<?php

namespace Meetanshi\Extension\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\Context;
use Meetanshi\Extension\Api\Data\ExtensionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Meetanshi\Extension\Model\ExtensionFactory;

class Save extends Action implements HttpPostActionInterface
{
    protected $resultPageFactory;

    protected $resultRedirectFactory;

    protected $extensionFactory;

    protected $dataPersistor;

    protected $extensionRepository;


    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ResultRedirectFactory $resultRedirectFactory,
        ExtensionFactory $extensionFactory,
        ExtensionRepositoryInterface $extensionRepository
    ) {
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
        if (!$input) {
            return $resultRedirect->setPath('*/*/');
        }

        $extension = $this->extensionFactory->create();
        $id = $this->getRequest()->getParam(ExtensionInterface::ID);
        try {
            if ($id) {
                $extension = $this->extensionRepository->getById($id);
            }

            $extension->setData($input);

            $this->extensionRepository->save($extension);

            $this->messageManager->addSuccessMessage(__('You saved the post successful!'));

            $this->dataPersistor->clear('post');

            return $resultRedirect->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t find a post'));
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t save a post, please try again later... '));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->dataPersistor->set('post', $input);
        return $resultRedirect->setPath('*/*/edit', [ExtensionInterface::ID => $id]);
    }
}
