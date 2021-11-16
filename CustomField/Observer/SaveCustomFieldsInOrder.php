<?php
namespace Bluethink\CustomField\Observer;

class SaveCustomFieldsInOrder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $quote = $observer->getEvent()->getQuote();

        $order->setData('deliverytime', $quote->getDeliverytime());
        $order->setData('delivery_date', $quote->getDeliveryDate());
        if ($quote->getBillingAddress()) {
            $order->getBillingAddress()->setAlternateNo($quote->getBillingAddress()->getExtensionAttributes()->getAlternateNo());
        }
        if (!$quote->isVirtual()) {            
            $order->getShippingAddress()->setAlternateNo($quote->getShippingAddress()->getAlternateNo());
        }
        return $this;
    }
}
