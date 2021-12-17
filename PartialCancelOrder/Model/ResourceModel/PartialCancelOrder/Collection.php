<?php
namespace Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Bluethink\PartialCancelOrder\Model\PartialCancelOrder as Model;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelOrder as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}