<?php

namespace Meetanshi\Extension\Block\Adminhtml\Block\Edit;

use Magento\Backend\Block\Widget\Context;


/**
 * Class GenericButton
 */
class GenericButton
{

    protected $context;


    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function getBlockId()
    {
        return $this->context->getRequest()->getParam('id');
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
