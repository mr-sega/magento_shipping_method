<?php

namespace Sega\ProductHeight\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Setup\CategorySetup;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

class AddProductHeightAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public function apply()
    {
        /** @var CategorySetup $categorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $this->moduleDataSetup]);

        /**
         * Product Height
         */
        $attributeCode = 'product_height';
        $attributeLabel = 'Product Height';

        $categorySetup->addAttribute(
            Product::ENTITY,
            $attributeCode,
            [
                'type' => 'int',
                'frontend' => '',
                'label' => $attributeLabel,
                'input' => 'text',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'visible_on_front' => true,
                'unique' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'sort_order' => 50
            ]
        );

        $attributeSetId = $categorySetup->getDefaultAttributeSetId(Product::ENTITY);

        $categorySetup->addAttributeToGroup(
            Product::ENTITY,
            $attributeSetId,
            'Default',
            $attributeCode,
            100
        );

        $attributeCode = 'product_height_enable';
        $attributeLabel = 'Product Height Enable';

        $categorySetup->addAttribute(
            Product::ENTITY,
            $attributeCode,
            [
                'type' => 'int',
                'group' => 'Product Details',
                'frontend' => '',
                'label' => $attributeLabel,
                'input' => 'boolean',
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'required' => false,
                'user_defined' => true,
                'default' => '',
                'visible_on_front' => false,
                'visible_in_advanced_search' => true,
                'used_in_product_listing' => true,
                'apply_to' => '',
                'unique' => false,
                'is_used_in_grid' => true,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => true,
                'sort_order' => 50
            ]
        );

        $attributeSetId = $categorySetup->getDefaultAttributeSetId(Product::ENTITY);

        $categorySetup->addAttributeToGroup(
            Product::ENTITY,
            $attributeSetId,
            'Default',
            $attributeCode,
            100
        );
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }


}
