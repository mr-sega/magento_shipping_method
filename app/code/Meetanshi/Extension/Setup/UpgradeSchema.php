<?php

namespace Meetanshi\Extension\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('extension'),
                'Notebook',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'size'     => 255,
                    'comment' => 'test',
                    'after' => 'telephone'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $installer->getConnection()->addColumn(
                $installer->getTable('extension'),
                'Description',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'size'     => 255,
                    'comment' => 'test',
                    'after' => 'Notebook'
                ]
            );
        }
    }
}
