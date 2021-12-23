<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Partial\View;

// class Form extends \Magento\Backend\Block\Widget\Form\Generic
// {
//     protected function _prepareForm()
//     {
//         die("Shashi");
//         $form = $this->_formFactory->create(
//             ['data' => [
//                             'id' => 'view_form',
//                             'enctype' => 'multipart/form-data',
//                             'action' => $this->getData('action'),
//                             'method' => 'post'
//                         ]
//             ]
//         );
//         $form->setUseContainer(true);
//         $this->setForm($form);
//         return parent::_prepareForm();
//     }
// }


class Form extends \Magento\Sales\Block\Adminhtml\Order\AbstractOrder
{
    /**
     * Retrieve invoice order
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->getPartialCancelOrder()->getOrder();
    }

    /**
     * Retrieve source
     *
     * @return \Magento\Sales\Model\Order\Creditmemo
     */
    public function getSource()
    {
        return $this->getPartialCancelOrder();
    }

    /**
     * Retrieve order totals block settings
     *
     * @return array
     */
    public function getOrderTotalData()
    {
        return ['grand_total_title' => __('Total Refund')];
    }

    /**
     * Retrieve creditmemo model instance
     *
     * @return \Magento\Sales\Model\Order\Creditmemo
     */
    public function getPartialCancelOrder()
    {
        return $this->_coreRegistry->registry('partialcancelorder_data');
    }

    /**
     * Get order url
     *
     * @return string
     */
    public function getOrderUrl()
    {
        return $this->getUrl('sales/order/view', ['order_id' => $this->getPartialCancelOrder()->getOrderId()]);
    }
}