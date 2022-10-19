<?php

namespace Meetanshi\Extension\Controller\Adminhtml\Post;

use Magento\Framework\App\Action\HttpGetActionInterface;


class NewAction extends \Magento\Backend\App\Action implements HttpGetActionInterface
{


    protected $resultForwardFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
