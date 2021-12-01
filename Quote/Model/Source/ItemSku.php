<?php

namespace Bluethink\Quote\Model\Source;

use Bluethink\Quote\Controller\Adminhtml\Quote\Update;
use Magento\Quote\Model\ResourceModel\Quote\Item\CollectionFactory;

class ItemSku implements \Magento\Framework\Option\ArrayInterface
{
    public function __construct(
        Update $update,
        CollectionFactory $collectionFactory
    ) {
        $this->update = $update;
        $this->collectionFactory = $collectionFactory;
    }
    
    public function toOptionArray()
    {
        $data = array();
        $quoteId = $this->update->getQuoteId();
        $items = $this->collectionFactory->create()->addFieldToFilter('quote_id',$quoteId);
        foreach($items as $x)
        {
            if($x->getParentItemId() == null)
            {
                $data[] = ['value' => $x->getItemId(), 'label' => $x->getSku()];
            }
        }
        return $data;
    }
}