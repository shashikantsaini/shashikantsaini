<?php
namespace Bluethink\Customer\Model;
class Detail extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'bluethink_customer_detail';

	protected $_cacheTag = 'bluethink_customer_detail';

	protected $_eventPrefix = 'bluethink_customer_detail';

	protected function _construct()
	{
		$this->_init('Bluethink\Customer\Model\ResourceModel\Detail');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}