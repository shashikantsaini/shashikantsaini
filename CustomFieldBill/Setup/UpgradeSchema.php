<?php

namespace Bluethink\CustomFieldBill\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
            
        $setup->getConnection()
        ->addColumn(
            $setup->getTable('sales_order_address'),
            'alternate_no',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT,
                'nullable' => false,
                'comment' => 'Alternate Number'
            ]
            );    
        $setup->getConnection()
        ->addColumn(
            $setup->getTable('quote_address'),
            'alternate_no',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_BIGINT,
                'nullable' => false,
                'comment' => 'Alternate Number'
            ]
            );    
        $setup->endSetup();
    }
}