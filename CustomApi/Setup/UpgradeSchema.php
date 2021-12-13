<?php

namespace Bluethink\CustomApi\Setup;

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

        //Table name initialization
        $orderTable = 'sales_order';
        $orderShipmentTrack = 'sales_shipment_track';

        //Order table and Order grid table
        $setup->getConnection()
            ->addColumn(
                $setup->getTable($orderTable),
                'shipping_label',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Shipping Label'

                ]
                );
        $setup->getConnection()->addColumn(
                $setup->getTable($orderShipmentTrack),
                'shipping_label',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Shipping Label'
                ]
                );

        //Order table and Order grid table Tracking Url
        $setup->getConnection()
        ->addColumn(
            $setup->getTable($orderTable),
            'tracking_url',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'Tracking Url'

            ]
            );
        $setup->getConnection()->addColumn(
            $setup->getTable($orderShipmentTrack),
            'tracking_url',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'comment' =>'Tracking Url'
            ]
            );
        $setup->endSetup();
    }
}