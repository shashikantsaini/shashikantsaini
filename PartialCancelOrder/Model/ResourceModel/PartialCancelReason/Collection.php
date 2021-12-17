<?php
namespace Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelReason;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Bluethink\PartialCancelOrder\Model\PartialCancelReason as Model;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelReason as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}