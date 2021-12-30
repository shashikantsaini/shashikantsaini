<?php

namespace Bluethink\Faq\Model;

use Magento\Framework\Model\AbstractModel;
use Bluethink\Faq\Model\ResourceModel\FaqGroup as ResourceModel;

class FaqGroup extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}