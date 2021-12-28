<?php

namespace Bluethink\CustomPayMethod\Model\Transaction;

use Magento\Sales\Model\Order\Payment\Transaction\BuilderInterface;
use Magento\Sales\Model\Order\Payment\Transaction as TransactionOrder;

class Transaction
{
    public function __construct(
        BuilderInterface $transactionBuilder
    ) {
        $this->transactionBuilder = $transactionBuilder;
    }

    public function addTransactionToOrder($order, $paymentData = array()) 
    {
        try {
            // Prepare payment object
            $payment = $order->getPayment();
            $payment->setLastTransId($paymentData['id']);
            $payment->setTransactionId($paymentData['id']);
            $payment->setAdditionalInformation([TransactionOrder::RAW_DETAILS => (array) $paymentData]);

            // Formatted price
            $formatedPrice = $order->getBaseCurrency()->formatTxt($order->getGrandTotal());
    
            // Prepare transaction
            $transaction = $this->transactionBuilder->setPayment($payment)
            ->setOrder($order)
            ->setTransactionId($paymentData['id'])
            ->setAdditionalInformation([TransactionOrder::RAW_DETAILS => (array) $paymentData])
            ->setFailSafe(true)
            ->build(TransactionOrder::TYPE_CAPTURE);

            // Add transaction to payment
            $payment->addTransactionCommentsToOrder($transaction, __('The authorized amount is %1.', $formatedPrice));
            $payment->setParentTransactionId(null);

            // Save payment, transaction and order
            $payment->save();
            $order->save();
            $transaction->save();
            
            return  $transaction->getTransactionId();

        } catch (Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
    }
}
