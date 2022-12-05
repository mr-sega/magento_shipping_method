<?php

namespace Sega\ChristmasCoins\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface PointsInterface extends ExtensibleDataInterface
{
    public const ID = 'id';
    public const CUSTOMER_ID = 'customer_id';
    public const ORDER_ID = 'order_id';
    public const AMOUNT_OF_PURCHASE = 'amount_of_purchase';
    public const ADDED_BY_ADMIN = 'added_by_admin';
    public const COINS_RECEIVED = 'coins_received';
    public const COINS_SPEND = 'coins_spend';
    public const DATE_OF_PURCHASE = 'date_of_purchase';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';


    public function getId();

    public function getCustomerId();

    public function getOrderId();

    public function getAmountOfPurchase();

    public function getAddedByAdmin();

    public function getCoinsReceived();

    public function getCoinsSpend();

    public function getDateOfPurchase();

    public function getCreatedAt();

    public function getUpdatedAt();

    public function setCustomerId($id);

    public function setOrderId($id);

    public function setAmountOfPurchase($amountOfPurchase);

    public function setAddedByAdmin($flag);

    public function setCoinsReceived($coinsReceived);

    public function setCoinsSpend($coinsSpend);

    public function setDateOfPurchase($dateOfPurchase);

    public function setCreatedAt($createdAt);

    public function setUpdatedAt($updatedAt);

}
