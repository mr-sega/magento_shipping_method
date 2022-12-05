<?php

namespace Sega\ChristmasCoins\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Sega\ChristmasCoins\Api\Data\PointsInterface;

interface PointsRepositoryInterface
{

    public function getById($id);


    public function save(PointsInterface $points);


    public function delete(PointsInterface $points);


    public function deleteById($id);


    public function getList(SearchCriteriaInterface $searchCriteria);
}
