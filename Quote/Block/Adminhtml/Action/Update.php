<?php
namespace Bluethink\Quote\Block\Adminhtml\Action;

use Magento\Framework\View\Element\Template;
use Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory;

class Update extends Template
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,  
        \Magento\Framework\Data\Form\FormKey $formKey,      
        \Magento\Framework\Registry $coreRegistry, 
        \Magento\Quote\Model\QuoteFactory $quoteFactory, 
        CollectionFactory $collectionFactory,   
        array $data = []
    )
    {  
        $this->collectionFactory = $collectionFactory; 
        $this->_coreRegistry = $coreRegistry; 
        $this->quoteFactory = $quoteFactory;
        $this->formKey = $formKey;   
        parent::__construct($context, $data);
    }

    public function getQuoteId()
    {
        return $this->_coreRegistry->registry('quote_id');
    }
    
    public function getItems()
    {
        $items = $this->collectionFactory->create()->addFieldToFilter('quote_id',$this->getQuoteId());        
        return $items;
    }

    public function getQuote()
    {
        $quoteData = $this->quoteFactory->create()->load($this->getQuoteId());      
        return $quoteData;
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}

