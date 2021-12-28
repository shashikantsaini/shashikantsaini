<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Partial;

use Magento\Framework\Pricing\Helper\Data;
use Bluethink\PartialCancelOrder\Model\ResourceModel\PartialCancelItem\CollectionFactory;

class Items extends \Magento\Backend\Block\Template
{
    /**
 	* Block template.
 	*
 	* @var string
 	*/
    protected $_template = 'order_cancel_item.phtml';

    protected $priceHelper;

	public function __construct(
        \Magento\Backend\Block\Template\Context $context,  
        \Magento\Framework\Data\Form\FormKey $formKey,      
        \Magento\Framework\Registry $coreRegistry,
        CollectionFactory $collectionFactory,
        Data $priceHelper,        
        array $data = []
    )
    { 
        $this->_coreRegistry = $coreRegistry; 
        $this->formKey = $formKey;
        $this->priceHelper = $priceHelper;
        $this->collectionFactory = $collectionFactory;   
        parent::__construct($context, $data);
    }

    public function getPartialCancelOrderId()
    {
        return $this->_coreRegistry->registry('partialcancelorder_data')->getEntityId();
    }

    public function getCancelItemsCollection()
    {
        $collection = $this->collectionFactory->create()->getItemsByColumnValue('parent_id',$this->getPartialCancelOrderId());
        return $collection;
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
