<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Partial;

class View extends \Magento\Backend\Block\Widget\Form\Container
{
    
    protected $_session;

    
    protected $_coreRegistry = null;

   
    protected $_backendSession;

    
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Backend\Model\Auth\Session $backendSession,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_backendSession = $backendSession;
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

   
    protected function _construct()
    {
        $this->_objectId = 'partialcancelorder_id';
        $this->_controller = 'adminhtml_order_partial';
        $this->_mode = 'view';
        parent::_construct();
        $this->buttonList->remove('save');
        $this->buttonList->remove('reset');
        $this->buttonList->remove('delete');        
    }
}
