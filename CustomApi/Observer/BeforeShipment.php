<?php

namespace Bluethink\CustomApi\Observer;

use Magento\Framework\Event\ObserverInterface;   

class BeforeShipment implements ObserverInterface
{    
    protected $_logger;
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $shipment = $observer->getEvent()->getShipment();        
        $order = $shipment->getOrder();
        foreach ($shipment->getTracks() as $track) {  
            $track->setShippingLabel($order->getShippingLabel());
            $track->setTrackingUrl($order->getTrackingUrl());
        }
        return $this;
    }
}