<?php

namespace Bluethink\CustomPayMethod\Block\Frontend\Authorize;

use Magento\Framework\View\Element\Template;
use Magento\Checkout\Model\Session as checkoutSession;
use Magento\Customer\Model\Session;

class Check extends Template
{
    protected $checkoutSession;
    protected $customerSession;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,  
        \Magento\Framework\Data\Form\FormKey $formKey,      
        \Magento\Framework\Registry $coreRegistry,
        Session $customerSession,
        checkoutSession $checkoutSession,      
        array $data = []
    )
    {   
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession; 
        $this->_coreRegistry = $coreRegistry; 
        $this->formKey = $formKey;   
        parent::__construct($context, $data);
    }

    public function getOrder()
    {
        return $this->_coreRegistry->registry('order');
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getOrderId()
    {
        return $this->getOrder()->getEntityId();
    }

    public function getCheckoutSession()
    {
        return $this->checkoutSession;
    }

    public function getCustomerSession()
    {
        return $this->customerSession;
    }
}

