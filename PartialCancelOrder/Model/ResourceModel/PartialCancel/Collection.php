<?php
namespace Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Bluethink\PartialCancelOrder\Model\PartialCancel as Model;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancel as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}