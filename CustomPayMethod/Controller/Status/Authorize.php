<?php 

namespace Bluethink\CustomPayMethod\Controller\Status;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Context;
use Bluethink\CustomPayMethod\Model\Transaction\Transaction;

class Authorize extends \Magento\Framework\App\Action\Action
{
    protected $orderManagement;

    public function __construct(
        Context $context,
        Transaction $transaction,
        Session $checkoutSession, 
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->transaction = $transaction;
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
            $str_result = '0123456789';
            $ranStr = substr(str_shuffle($str_result), 0, 5);
            $id = "TXN".$ranStr;
            $paymentData = ['id'=>$id, 'bank'=>'SBI'];
            $trasactionId = $this->transaction->addTransactionToOrder($order , $paymentData);
            $result = $this->resultJsonFactory->create();
            $result->setData(['status'=>200,'message'=>'']);
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