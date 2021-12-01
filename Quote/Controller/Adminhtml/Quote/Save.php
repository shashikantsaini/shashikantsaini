<?php


namespace Bluethink\Quote\Controller\Adminhtml\Quote;

use Magento\Quote\Model\Quote\Item ;

class Save extends \Magento\Backend\App\Action
{

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        Item $quoteItem
    ) {
        parent::__construct($context);
        $this->quoteItem=$quoteItem;;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $itemId = $this->getRequest()->getParam('sku');
        // echo "<pre>";
        // print_r($itemId);
        // print_r($data);
        // die();
        if (!$data) {
            $this->_redirect('quote/quote/index');
            return;
        }

        try {
            foreach($itemId as $item)
            {
                $quoteItem=$this->quoteItem->load($item);
                $quoteItem->delete();
                $quoteItem->save();
            }   
            $this->messageManager->addSuccess(__('Items has been successfully deleted.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('quote/quote/update');
    }
}