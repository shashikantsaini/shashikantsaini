<?php
namespace Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelItem;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Bluethink\PartialCancelOrder\Model\PartialCancelItem as Model;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelItem as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}