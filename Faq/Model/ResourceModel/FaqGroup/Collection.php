<?php
namespace Bluethink\Faq\Model\ResourceModel\FaqGroup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Bluethink\Faq\Model\FaqGroup as Model;
use Bluethink\Faq\Model\ResourceModel\FaqGroup as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return parent::_toOptionArray('faqgroup_id', 'groupname');
    }
}