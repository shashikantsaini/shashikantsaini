<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Item;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Pricing\Helper\Data;

class ItemList extends Template
{
    protected $_productCollectionFactory;

    protected $priceHelper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,  
        \Magento\Framework\Data\Form\FormKey $formKey,      
        \Magento\Framework\Registry $coreRegistry,       
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        Data $priceHelper,        
        array $data = []
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_coreRegistry = $coreRegistry; 
        $this->formKey = $formKey;
        $this->priceHelper = $priceHelper;   
        parent::__construct($context, $data);
    }
    
    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        return $collection;
    }

    public function getOrder()
    {
        return $this->_coreRegistry->registry('order_data');
    }

    public function getOrderId()
    {
        return $this->getOrder()->getEntityId();
    }

    public function getItemsCollection()
    {
        return $this->getOrder()->getItemsCollection();
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

    public function getFormattedPrice($price)
    {
        return $this->priceHelper->currency($price, true, false);
    }
}
