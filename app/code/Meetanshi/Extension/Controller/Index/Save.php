<?php

namespace Meetanshi\Extension\Controller\Index;

use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Meetanshi\Extension\Model\ExtensionFactory;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Backend\Model\View\Result\RedirectFactory as ResultRedirectFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;


class Save extends Action
{

    protected $resultRedirectFactory;

    protected $extensionFactory;

    protected $extensionRepository;

    public function __construct(
        Context $context,
        ResultRedirectFactory $resultRedirectFactory,
        ExtensionFactory $extensionFactory,
        ExtensionRepositoryInterface $extensionRepository
    )
    {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->extensionFactory = $extensionFactory;
        $this->extensionRepository = $extensionRepository;
        return parent::__construct($context);
    }


    public function execute()
    {

        $resultRedirect = $this->resultRedirectFactory->create();

        if ($this->getRequest()->isPost()) {
            $input = $this->getRequest()->getPostValue();
            if ($input) {
                $input['id'] = empty($input['id']) ? null  : $input['id'];
                $id = $input['id'];

                $phone = $this->extensionFactory->create();

                if ($id) {
                    $phone = $this->extensionRepository->getById($id);
                }

                $phone->setData($input);

                $this->extensionRepository->save($phone);
            }
            return $resultRedirect->setPath('extension/index/');
        }
    }
}
