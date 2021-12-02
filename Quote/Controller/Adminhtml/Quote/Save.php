<?php

namespace Bluethink\Quote\Controller\Adminhtml\Quote;

use Magento\Quote\Model\Quote\Item ;
use Magento\Quote\Model\QuoteFactory ;

class Save extends \Magento\Backend\App\Action
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Item $quoteItem,
        QuoteFactory $quoteFactory
    ) {
        parent::__construct($context);
        $this->quoteItem=$quoteItem;
        $this->quoteFactory=$quoteFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $itemId = $this->getRequest()->getParam('sku');
        $quoteId = $this->getRequest()->getParam('entity_id');
        $quote = $this->quoteFactory->create()->load($quoteId);
        // echo "<pre>";
        // print_r($itemId);
        // print_r(get_class_methods($quote));
        // die();

        if (!$data) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            foreach($itemId as $item)
            {
                $quoteItem=$this->quoteItem->load($item);
                $quoteItem->delete();
                $quoteItem->save();
                $quote->collectTotals()->save();
            }   
            $this->messageManager->addSuccess(__('Items has been successfully deleted.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('*/*/update');
    }
}