<?php

namespace Bluethink\PartialCancelOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelReason as ResourceModel;

class PartialCancelReason extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}