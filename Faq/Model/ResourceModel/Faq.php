<?php

namespace Bluethink\Faq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Faq extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('bluethink_faq', 'faq_id');
    }
}