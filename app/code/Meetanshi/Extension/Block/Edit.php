<?php

namespace Meetanshi\Extension\Block;

use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use \Magento\Framework\Registry;

class Edit extends Template
{
    protected $extensionFactory;
    protected $coreRegistry;

    public function __construct(
        Context                                     $context,
        \Meetanshi\Extension\Model\ExtensionFactory $extensionFactory,
        Registry                                    $registry,
        array                                       $data = [])
    {
        $this->extensionFactory = $extensionFactory;
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    public function getPost()
    {
        $id = $this->coreRegistry->registry('editRecordId');
        $post = $this->extensionFactory->create();
        $result = $post->load($id);
        return $result;
    }
}
