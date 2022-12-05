<?php

namespace Sega\ChristmasCoins\Model;

use Sega\ChristmasCoins\Api\Data\PointsInterface;
use Sega\ChristmasCoins\Model\ResourceModel\Points as ResourceModel;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class Points extends AbstractModel implements PointsInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    public function setCustomerId($id)
    {
        return $this->setData(self::CUSTOMER_ID, $id);
    }

    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    public function setOrderId($id)
    {
        return $this->setData(self::ORDER_ID, $id);
    }


    public function getAddedByAdmin()
    {
        return $this->getData(self::ADDED_BY_ADMIN);
    }

    public function setAddedByAdmin($flag)
    {
        return $this->setData(self::ADDED_BY_ADMIN, $flag);
    }

    public function getCoinsReceived()
    {
        return $this->getData(self::COINS_RECEIVED);
    }


    public function setCoinsReceived($coinsReceived)
    {
        return $this->setData(self::COINS_RECEIVED, $coinsReceived);
    }

    public function getCoinsSpend()
    {
        return $this->getData(self::COINS_SPEND);
    }

    public function setCoinsSpend($coinsSpend)
    {
        return $this->setData(self::COINS_SPEND, $coinsSpend);
    }

    public function getDateOfPurchase(): string
    {
        return $this->getData(self::DATE_OF_PURCHASE);
    }

    public function setDateOfPurchase($dateOfPurchase)
    {
        return $this->setData(self::DATE_OF_PURCHASE, $dateOfPurchase);
    }


    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }


    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function getAmountOfPurchase()
    {
        return $this->getData(self::AMOUNT_OF_PURCHASE);
    }

    public function setAmountOfPurchase($amountOfPurchase)
    {
        return $this->setData(self::AMOUNT_OF_PURCHASE, $amountOfPurchase);
    }

    public function validateBeforeSave()
    {
        if ($this->getCoinsReceived() < 0) {
            throw new LocalizedException(__('The Coins Received Value can not be less than 0.'));
        }
    }
}
