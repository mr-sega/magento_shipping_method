<?php
namespace Meetanshi\Extension\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Meetanshi\Extension\Api\Data\PostInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Extension extends AbstractModel implements PostInterface, IdentityInterface
{

    const CACHE_TAG = 'extension' ;

    protected function _construct()
    {
        $this->_init(ResourceModel\Extension::class);
        $this->setIdFieldName('id');

    }

    public function getId()
    {
        return $this->_getData(self::ID);
    }

    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    public function getNotebook()
    {
        return $this->getData(self::NOTEBOOK);
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED);
    }

    public function getUpdateAt()
    {
        return $this->getData(self::UPDATED);
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
    }

    public function setUpdateAt()
    {
        $this->setData(self::UPDATED);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    public function setEmail()
    {
        $this->setData(self::EMAIL);
    }

    public function setTelephone()
    {
        $this->setData(self::TELEPHONE);
    }

    public function setNotebook()
    {
        $this->setData(self::NOTEBOOK);
    }

    public function setDescription()
    {
        $this->setData(self::DESCRIPTION);
    }

    public function setCreatedAt()
    {
        $this->setData(self::UPDATED);
    }

    public function beforeSave(): PostInterface
    {
        if ($this->hasDataChanges()) {
            $this->setUpdatedAt(date("Y-m-d H:i:s"));
        }
        return parent::beforeSave();
    }
}
