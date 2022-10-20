<?php

namespace Meetanshi\Extension\Block;

use Magento\Catalog\Model\Session as CatalogSession;
use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\Extension\Api\ExtensionRepositoryInterface;
use Magento\Framework\App\RequestInterface;

class Edit extends Template
{
    protected $extensionFactory;
    protected $extensionRepository;
    protected $request;

    public function __construct(
        Context                                     $context,
        \Meetanshi\Extension\Model\ExtensionFactory $extensionFactory,
        ExtensionRepositoryInterface                $extensionRepository,
        CatalogSession                              $catalogSession,
        RequestInterface                            $request,
        array                                       $data = [])
    {
        $this->extensionFactory = $extensionFactory;
        $this->extensionRepository = $extensionRepository;
        $this->request = $request;
        $this->catalogSession = $catalogSession;

        parent::__construct($context, $data);
    }

    public function getPost()
    {
        $id = $this->catalogSession->get('editRecordId');
        $post = $this->extensionRepository->getById($this->request->getParam('id'));
        return $post;

    }

    Public function getFrontPost()
    {
        return $this->extensionRepository->getById($this->request->getParam('id'));
    }
}
