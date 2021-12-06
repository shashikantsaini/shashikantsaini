<?php

namespace Bluethink\Quote\Controller\Adminhtml\Quote;

use Magento\Quote\Model\Quote\Item ;
use Magento\Quote\Model\QuoteFactory ;
use Magento\Quote\Model\QuoteManagement ;
use Magento\Framework\App\ResponseInterface ;
use Magento\Framework\View\Result\PageFactory ;
use Magento\Quote\Api\CartRepositoryInterface ;
use Magento\Catalog\Api\ProductRepositoryInterface ;

class AddItem extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        PageFactory $pageFactory,
        QuoteFactory $quote,
        CartRepositoryInterface $cartRap,
        ProductRepositoryInterface $productRepositoryInterface
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->pageFactory = $pageFactory;
        $this->quote = $quote;
        $this->cartRep = $cartRap;
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    public function execute()
    {
        $quoteId= $_POST['quote_id'];
        $qtyarray = array_filter($_POST['product_qty']);
        try {
            // then load it
            foreach($qtyarray as $productId=>$productQty)
            {  
                $product = $this->productRepositoryInterface->getById($productId);
                $cart = $this->quote->create()->loadActive($quoteId);    
                $cart->addProduct($product, $productQty);   
                $cart->save(); 
                $cart->collectTotals()->save();   
            }
            $this->messageManager->addSuccess(__('Items has been successfully Added.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $this->_redirect('*/*/update',['id' => $quoteId]);
    }
}