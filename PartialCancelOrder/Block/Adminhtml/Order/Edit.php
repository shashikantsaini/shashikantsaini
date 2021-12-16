<?php
namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected function _construct()
    {
        $this->_objectId = 'order_id';
        $this->_blockGroup = 'Bluethink_PartialCancelOrder';
        $this->_controller = 'adminhtml_order';
        parent::_construct();
        $this->buttonList->remove('delete');
    }
}
