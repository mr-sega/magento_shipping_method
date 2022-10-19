<?php
namespace Meetanshi\Extension\Model\ResourceModel\Extension;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Meetanshi\Extension\Model\Extension', 'Meetanshi\Extension\Model\ResourceModel\Extension');
    }
}
