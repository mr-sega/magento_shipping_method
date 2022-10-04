<?php

namespace Meetanshi\Extension\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Meetanshi\Extension\Api\Data\PostInterface;

interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \Meetanshi\Extension\Api\Data\PostInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Meetanshi\Extension\Api\Data\PostInterface $post
     * @return \Meetanshi\Extension\Api\Data\PostInterface
     */
    public function save(PostInterface $post);

    /**
     * @param \Meetanshi\Extension\Api\Data\PostInterface $post
     * @return void
     */
    public function delete(PostInterface $post);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Meetanshi\Extension\Api\Data\PostSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
