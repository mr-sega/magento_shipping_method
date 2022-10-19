<?php

namespace Meetanshi\Extension\Controller\Index;


use Meetanshi\Extension\Api\Data\ExtensionInterface;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Meetanshi\Extension\Model\ExtensionFactory;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;


class Save implements HttpPostActionInterface
{
    protected $messageManager;

    protected $resultFactory;

    protected $request;

    protected $extensionFactory;

    protected $extensionRepository;

    public function __construct(
        ExtensionFactory             $extensionFactory,
        ResultFactory                $resultFactory,
        RequestInterface             $request,
        ExtensionRepositoryInterface $extensionRepository,
        MessageManagerInterface      $messageManager
    )
    {
        $this->extensionFactory = $extensionFactory;
        $this->resultFactory = $resultFactory;
        $this->extensionRepository = $extensionRepository;
        $this->request = $request;
        $this->messageManager = $messageManager;
    }


    public function execute()
    {
        $input = $this->request->getParams();

        if (!$input) {
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
        }
        $extension = $this->extensionFactory->create();
        $id = $this->request->getParam(ExtensionInterface::ID);
        try {
                if ($input) {
                    $input['id'] = empty($input['id']) ? null  : $input['id'];
                    $id = $input['id'];
                }
            $extension->setData($input);
            $this->extensionRepository->save($extension);
            $this->messageManager->addSuccessMessage(__('You saved the post successful!'));
            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t find a post'));
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('We can\'t save a post'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/edit', [ExtensionInterface::ID => $id]);
    }
}
