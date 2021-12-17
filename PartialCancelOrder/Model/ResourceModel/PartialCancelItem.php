<?php

namespace Bluethink\PartialCancelOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PartialCancelItem extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('partial_cancel_item', 'entity_id');
    }
}