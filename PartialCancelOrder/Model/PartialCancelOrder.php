<?php

namespace Bluethink\PartialCancelOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelOrder as ResourceModel;

class PartialCancelOrder extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}