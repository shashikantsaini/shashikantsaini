<?php
namespace Bluethink\Customer\Model\ResourceModel\Detail;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'cust_id';
	protected $_eventPrefix = 'bluethink_customer_detail_collection';
	protected $_eventObject = 'detail_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Bluethink\Customer\Model\Detail', 'Bluethink\Customer\Model\ResourceModel\Detail');
	}

}