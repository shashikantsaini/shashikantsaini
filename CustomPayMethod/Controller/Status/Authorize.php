<?php 

namespace Bluethink\CustomPayMethod\Controller\Status;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Model\OrderFactory;
use Bluethink\CustomPayMethod\Model\Transaction\Transaction;

class Authorize extends \Magento\Framework\App\Action\Action
{
    protected $orderManagement;

    public function __construct(
        Context $context,
        Transaction $transaction,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Session $checkoutSession, 
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        OrderFactory $orderFactory,
        \Magento\Sales\Api\OrderManagementInterface $orderManagement,
        \Magento\Framework\Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->transaction = $transaction;
        $this->orderFactory = $orderFactory;
        $this->orderManagement = $orderManagement;
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->checkoutSession = $checkoutSession; //Used for getting the order: $order = $this->checkoutSession->getLastRealOrder(); And other order data like ID & amount
        $this->resultJsonFactory = $resultJsonFactory; //Used for returning JSON data to the afterPlaceOrder function ($result = $this->resultJsonFactory->create(); return $result->setData($post_data);)
    }

    public function execute()
    {
        $paymentData = array();
        try
        {
            $order = $this->checkoutSession->getLastRealOrder();
            $orderId = $order->getEntityId();
            $paymentData[] = ['id'=>'TXN111111', 'bank'=>'SBI'];
            $trasactionId = $this->transaction->addTransactionToOrder($order , $paymentData);
            $msg= sprintf('Order has been reversed with Order Id: %s.', $incrementId);
            $this->messageManager->addSuccess(__($msg));
            $result = $this->resultJsonFactory->create();
            $result->setData(['status'=>200,'message'=>$msg]);
            return $result;
            
        }
        catch (\Exception $e)
        {
            $result = $this->resultJsonFactory->create();
            $this->messageManager->addError(__($e->getMessage()));
            $result->setData(['status'=>201,'message'=>'']);
            return $result;
        }
    }
}