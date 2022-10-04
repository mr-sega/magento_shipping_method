<?php

namespace Meetanshi\Extension\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PostSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Meetanshi\Extension\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \Meetanshi\Extension\Api\Data\PostInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
