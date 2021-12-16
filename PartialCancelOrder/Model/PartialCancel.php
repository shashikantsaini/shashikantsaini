<?php

namespace Bluethink\PartialCancelOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancel as ResourceModel;

class PartialCancel extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}