<?php 
namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Button; 

use Magento\Backend\Block\Widget\Context;
use Bluethink\PartialCancelOrder\Model\PartialCancelOrderFactory;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends Generic implements ButtonProviderInterface 
{
    protected $context;

    public function __construct(
        Context $context,
        PartialCancelOrderFactory $partialCancelOrderFactory,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->context = $context;
        $this->_coreRegistry = $coreRegistry; 
        $this->partialCancelOrderFactory = $partialCancelOrderFactory;
    }   

    public function getButtonData() 
    { 
        return [ 
        'label' => __('Back'), 
        'on_click' => sprintf("location.href= '%s';", $this->getBackUrl()), 
        'class' => 'back', 
        'sort_order' => 10 ];
    } 

    public function getOrderId()
    {
        return $this->_coreRegistry->registry('partialcancelorder_data')->getParentId();
    }

    public function getBackUrl() 
    {
        $id = $this->context->getRequest()->getParam('partialcancelorder_id');
        $orderId = $this->partialCancelOrderFactory->create()->load($id)->getOrderId();
        return $this->getUrl('sales/order/view',['order_id'=>$orderId]);  
    }
} 

