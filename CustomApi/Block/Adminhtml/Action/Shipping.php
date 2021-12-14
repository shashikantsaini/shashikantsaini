<?php

namespace Bluethink\CustomApi\Block\Adminhtml\Action;

use Magento\Framework\View\Element\Template;
use Exception;
use Psr\Log\LoggerInterface;
use Magento\Sales\Api\Data\ShipmentInterface;
use Magento\Sales\Model\Order\Shipment;

class Shipping extends Template
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,     
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Sales\Api\Data\OrderInterface $order,
        LoggerInterface $logger, 
        Shipment $ship,     
        array $data = []
    )
    {   
        $this->_coreRegistry = $coreRegistry;
        $this->logger = $logger; 
        $this->ship = $ship;
        $this->order = $order;
        parent::__construct($context, $data);
    }

    public function getOrderId()
    {
        return $this->_coreRegistry->registry('order_id');
    }

    /**
     * Get Shipment Tracks by Increment Id
     *
     * @param $incrementId
     * @return ShipmentInterface[]|null
     */
    public function getShipmentTracksByIncrementId()
    {
        // first fetch order entity id by increment id
        $incrementId = $this->getOrderId();
        if ($incrementId) 
        {
            try
            {
                $shipments = $this->ship->loadByIncrementId($incrementId);
                $shipmentTracks = $shipments->getTracks();
            }
            catch (Exception $exception)  
            {
                $this->logger->critical($exception->getMessage());
                $shipmentTracks = null;
            }
        }
        return $shipmentTracks;
    }

    public function getOrderByIncrementId()
    {
        $order = $this->order->loadByIncrementId($this->getOrderId());
        return $order;
    }
}
