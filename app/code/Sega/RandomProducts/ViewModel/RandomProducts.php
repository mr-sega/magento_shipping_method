<?php

namespace Sega\RandomProducts\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class RandomProducts implements ArgumentInterface
{
    private $productCollection;

    public function __construct(Collection $productCollection)
    {
        $this->productCollection = $productCollection;
    }

    public function getRandomProducts()
    {
        $collection = $this->productCollection->getSelect()
            ->orderRand('e.entity_id')
            ->limit(3);

        $collection = $this->productCollection->addAttributeToSelect('*');
        return $collection;
    }
}


