<?php

namespace Sega\ProductHeight\Block;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;

class Height extends Template
{

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Product
     */
    protected $product;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        array $data)
    {
        $this->registry = $registry;

        parent::__construct($context, $data);
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        if (is_null($this->product)) {
            $this->product = $this->registry->registry('product');

            if (!$this->product->getId()) {
                throw new LocalizedException(__('Failed to initialize product'));
            }
        }

        return $this->product;
    }

    public function getProductEnableHeight()
    {
        return $this->getProduct()->getData('product_height_enable');
    }

    public function getProductHeight()
    {
        return $this->getProduct()->getData('product_height');
    }
}
