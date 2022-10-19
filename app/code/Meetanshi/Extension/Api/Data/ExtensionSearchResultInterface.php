<?php

namespace Meetanshi\Extension\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ExtensionSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Meetanshi\Extension\Api\Data\ExtensionInterface[]
     */
    public function getItems();

    /**
     * @param \Meetanshi\Extension\Api\Data\ExtensionInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
