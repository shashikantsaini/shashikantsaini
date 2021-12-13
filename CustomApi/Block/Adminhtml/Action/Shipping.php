<?php

namespace Bluethink\CustomApi\Block\Adminhtml\Action;

use Magento\Framework\View\Element\Template;

class Shipping extends Template
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,  
        \Magento\Framework\Data\Form\FormKey $formKey,      
        \Magento\Framework\Registry $coreRegistry,      
        array $data = []
    )
    {   
        $this->_coreRegistry = $coreRegistry; 
        $this->formKey = $formKey;   
        parent::__construct($context, $data);
    }

    public function getOrderId()
    {
        return $this->_coreRegistry->registry('order_id');
    }
}
