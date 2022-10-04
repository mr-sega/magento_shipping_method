<?php

namespace Meetanshi\Extension\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface PostInterface extends ExtensibleDataInterface
{
    const ID = 'id' ;
    const NAME = 'name' ;
    const EMAIL = 'email' ;
    const TELEPHONE = 'telephone' ;
    const NOTEBOOK = 'notebook' ;
    const DESCRIPTION = 'description' ;
    const CREATED = 'created_at' ;
    const UPDATED = 'update_time' ;


    public function getId();

    public function getName();

    public function getEmail();

    public function getTelephone();

    public function getNotebook();

    public function getDescription();

    public function getCreatedAt();

    public function getUpdateAt();

    public function setId($id);

    public function setName($name);

    public function setEmail();

    public function setTelephone();

    public function setNotebook();

    public function setDescription();

    public function setCreatedAt();

    public function setUpdateAt();


}