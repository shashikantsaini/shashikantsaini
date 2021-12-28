<?php 

namespace Bluethink\CustomPayMethod\Controller\Status;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Quote\Model\QuoteFactory;

class Reverse extends \Magento\Framework\App\Action\Action
{
    public function __construct(
        Context $context,
        QuoteFactory $quoteFactory,
        Session $checkoutSession, 
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Sales\Api\OrderManagementInterface $orderManagement,
        \Magento\Framework\Controller\Result\Redirect $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->orderManagement = $orderManagement;
        $this->quoteFactory = $quoteFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->checkoutSession = $checkoutSession; //Used for getting the order: $order = $this->checkoutSession->getLastRealOrder(); And other order data like ID & amount
        $this->resultJsonFactory = $resultJsonFactory; //Used for returning JSON data to the afterPlaceOrder function ($result = $this->resultJsonFactory->create(); return $result->setData($post_data);)
    }

    public function execute()
    {
        try
        {
            $order = $this->checkoutSession->getLastRealOrder();
            $quote = $this->quoteFactory->create()->loadByIdWithoutStore($order->getQuoteId());
            if ($quote->getId()) {
                $quote->setIsActive(1)->setReservedOrderId(null)->save();
                $this->checkoutSession->replaceQuote($quote);
                // $resultRedirect = $this->resultRedirectFactory->create();
                // $resultRedirect->setPath('checkout/cart');
                $this->messageManager->addWarningMessage('Payment Failed.');
                // return $resultRedirect;
            }
            $orderId = $order->getEntityId();
            $incrementId = $order->getIncrementId();
            $this->orderManagement->cancel($orderId);
            $this->checkoutSession->unsAuthCode();
            $msg= sprintf('Payment Failed for Order Id: %s.', $incrementId);
            $this->messageManager->addSuccess(__($msg));
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('checkout/cart');  
            return $resultRedirect;          
        }
        catch (\Exception $e)
        {
            $this->messageManager->addError(__($e->getMessage()));
        }
    }
}