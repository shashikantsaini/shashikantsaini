<?php
namespace Bluethink\CustomFieldBill\Observer;

class SaveCustomFieldsInOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();
        if ($quote->getBillingAddress()) {
            $order->getBillingAddress()->setAlternateNo($quote->getBillingAddress()->getExtensionAttributes()->getAlternateNo());
        }
        if (!$quote->isVirtual()) {            
            $order->getShippingAddress()->setAlternateNo($quote->getShippingAddress()->getAlternateNo());
        }
        return $this;
    }
}
