<?php

namespace Bluethink\Customer\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();
		if (!$installer->tableExists('bluethink_customer_grid')) {
			$table = $installer->getConnection()->newTable(
				$installer->getTable('bluethink_customer_grid')
			)
				->addColumn(
					'cust_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'Customer ID'
				)
				->addColumn(
					'name',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					['nullable => false'],
					'Customer Name'
				)
				->addColumn(
					'email',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Email'
				)->addColumn(
					'mnumber',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					1,
					['nullable' => false,'default' => 0],
					'Mobile Number'
				)
				->addColumn(
		            'password',
		            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		            128
		        )
				->setComment('Customer Table');
			$installer->getConnection()->createTable($table);

			$installer->getConnection()->addIndex(
				$installer->getTable('bluethink_customer_grid'),
				$setup->getIdxName(
					$installer->getTable('bluethink_customer_grid'),
					['name', 'email', 'password'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['name', 'email', 'password'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		}
		$installer->endSetup();
	}
}