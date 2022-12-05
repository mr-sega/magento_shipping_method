<?php

namespace Sega\ChristmasCoins\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PointsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return \Sega\ChristmasCoins\Api\Data\PointsInterface[]
     */
    public function getItems();

    /**
     * @param \Sega\ChristmasCoins\Api\Data\PointsInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
