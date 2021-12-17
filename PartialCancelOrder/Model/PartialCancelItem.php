<?php

namespace Bluethink\PartialCancelOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelItem as ResourceModel;

class PartialCancelItem extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}