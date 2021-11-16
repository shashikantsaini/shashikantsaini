<?php

namespace Bluethink\CustomField\Setup;

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

        $quoteAddressTable = 'quote';
        $orderTable = 'sales_order';
        $orderGridTable = 'sales_order_grid';

        //Quote table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteAddressTable),
                'deliverytime',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Delivery Time'
                ]
            );
        //Order table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'deliverytime',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Delivery Time'

                ]
            );
            //Order grid table
        $setup->getConnection()
        ->addColumn(
            $setup->getTable($orderGridTable),
            'deliverytime',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'Delivery Time'
            ]
            );

        //Quote table delivery date
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($quoteAddressTable),
                'delivery_date',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                    'nullable' => false,
                    'comment' => 'Delivery Date'
                ]
            );
        //Order table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'delivery_date',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                    'nullable' => false,
                    'comment' => 'Delivery Date'

                ]
            );
        //Order grid table
        $setup->getConnection()
        ->addColumn(
            $setup->getTable($orderGridTable),
            'delivery_date',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DATE,
                'nullable' => false,
                'comment' => 'Delivery Date'
            ]
            ); 
            
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