<?php

namespace Bluethink\Quote\Controller\Adminhtml\Quote;

use Magento\Quote\Model\Quote\Item ;
use Magento\Quote\Model\QuoteFactory ;

class Save extends \Magento\Backend\App\Action
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Item $quoteItem,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,
        QuoteFactory $quoteFactory
    ) {
        parent::__construct($context);
        $this->quoteItem=$quoteItem;
        $this->quoteFactory=$quoteFactory;
        $this->jsonResultFactory = $jsonResultFactory;
    }

    public function execute()
    {     
        $data = $this->getRequest()->getPostValue();
        $itemId = $this->getRequest()->getParam('quote_item_id');
        $quoteId = $this->getRequest()->getParam('quote_id');
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
            $quote->collectTotals()->save();   
            $this->messageManager->addSuccess(__('Items has been successfully deleted.'));
            $result = $this->jsonResultFactory->create();
            $result->setData(['status'=>200,'message'=>'Items has been successfully deleted.']);
            return $result;
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('*/*/update',['quote_id' => $quoteId]);
    }
}