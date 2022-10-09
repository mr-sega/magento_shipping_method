<?php

namespace Meetanshi\Extension\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Meetanshi\Extension\Api\Data\ExtensionInterface;

interface ExtensionRepositoryInterface
{
    /**
     * @param int $id
     * @return \Meetanshi\Extension\Api\Data\ExtensionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityExceptionк
     */
    public function getById($id);

    /**
     * @param \Meetanshi\Extension\Api\Data\ExtensionInterface $Extension
     * @return \Meetanshi\Extension\Api\Data\ExtensionInterface
     */
    public function save(ExtensionInterface $Extension);

    /**
     * @param \Meetanshi\Extension\Api\Data\ExtensionInterface $Extension
     * @return void
     */
    public function delete(ExtensionInterface $Extension);


    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Meetanshi\Extension\Api\Data\ExtensionSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
