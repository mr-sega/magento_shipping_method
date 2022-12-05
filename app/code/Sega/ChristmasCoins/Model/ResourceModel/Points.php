<?php
namespace Sega\ChristmasCoins\Model\ResourceModel;


class Points extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('coins_transaction', 'id');
    }

}
