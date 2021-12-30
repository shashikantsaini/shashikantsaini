<?php

namespace Bluethink\Faq\Model;

use Magento\Framework\Model\AbstractModel;
use Bluethink\Faq\Model\ResourceModel\Faq as ResourceModel;

class Faq extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}