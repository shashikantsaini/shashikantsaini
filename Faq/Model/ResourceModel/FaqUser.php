<?php

namespace Bluethink\Faq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class FaqUser extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('bluethink_faq_user', 'user_faq_id');
    }
}