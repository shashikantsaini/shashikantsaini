<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {

        $this->_objectId = 'id';
        $this->_blockGroup = 'Bluethink_PartialCancelOrder';
        $this->_controller = 'adminhtml_order';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Update Order'));
        $this->buttonList->remove('delete');
        $this->buttonList->update('back', 'onclick', "setLocation('" . $this->getUrl('sales/order/view',['order_id'=> $this->getOrderId()]) . "')");
    }

    public function getOrderId()
    {
        $order = $this->_coreRegistry->registry('order_data');
        return $order->getEntityId();
    }

    //Overrided getSaveUrl function for save path
    public function getSaveUrl()
    {
        return $this->getUrl('partialcancelorder/order/update',['order_id'=> $this->getOrderId()]);
    }
}
