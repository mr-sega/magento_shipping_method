<?php
namespace Sega\ChristmasCoins\Model\ResourceModel\Points;

use Sega\ChristmasCoins\Model\Points as Model;
use Sega\ChristmasCoins\Model\ResourceModel\Points as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
