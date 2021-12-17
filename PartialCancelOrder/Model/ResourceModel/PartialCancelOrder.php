<?php

namespace Bluethink\PartialCancelOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PartialCancelOrder extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('partial_cancel_order', 'entity_id');
    }
}