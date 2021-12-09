<?php

namespace Bluethink\CustomApi\Model;

use Magento\Sales\Model\OrderFactory ;
use Magento\Shipping\Model\ShipmentNotifier;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Sales\Api\OrderRepositoryInterface ;
use Bluethink\CustomApi\Api\ShipmentRepositoryInterface ;
use Bluethink\CustomApi\Api\ShipmentInterface ;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    public function __construct(
        \Magento\Sales\Model\Convert\Order $convertOrder,
        OrderFactory $orderFactory,
        JsonFactory $jsonResultFactory,
        OrderRepositoryInterface $orderRepository,
        ShipmentInterface $shipmentInterface,
        ShipmentNotifier $notifier
    )
    {
        $this->orderFactory = $orderFactory;
        $this->convertOrder = $convertOrder;
        $this->jsonResultFactory = $jsonResultFactory;
        $this->orderRepository = $orderRepository;
        $this->shipmentInterface = $shipmentInterface;
        $this->notifier = $notifier;
    }

    /**
     * {@inheritdoc}
     */
    public function createShipment($orderId,$status, \Bluethink\CustomApi\Api\ShipmentInterface $trackingInfo)
    {
        echo $trackingInfo->getShippingLabel();
        echo $trackingInfo->getTrackingUrl();
        echo $orderId;
        echo $status;
        die();
        $response = ['error' => false];
        try{
            // Load the order increment ID
            $order = $this->orderFactory->create()->loadByIncrementID($orderId);
                      
            // Check if order can be shipped or has already shipped
            if (! $order->canShip()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                                __('You can\'t create an shipment.')
                            );
            }
            
            // Initialize the order shipment object
            $shipment = $this->convertOrder->toShipment($order);

            // Loop through order items
            foreach ($order->getAllItems() AS $orderItem) {
                // Check if order item has qty to ship or is virtual
                if (! $orderItem->getQtyToShip() || $orderItem->getIsVirtual()) {
                    continue;
                }

                $qtyShipped = $orderItem->getQtyToShip();

                // Create shipment item with qty
                $shipmentItem = $this->convertOrder->itemToShipmentItem($orderItem)->setQty($qtyShipped);

                // Add shipment item to shipment
                $shipment->addItem($shipmentItem);
            }

            // Register shipment
            $shipment->register();

            $shipment->getOrder()->setIsInProcess(true);

            try {
                // Save created shipment and order
                $shipment->save();
                $shipment->getOrder()->save();

                // // Send email
                // $this->_objectManager->create('Magento\Shipping\Model\ShipmentNotifier')
                //     ->notify($shipment);

                $shipment->save();
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(
                                __($e->getMessage())
                            );
            }
            $shipmentCollection = $order->getShipmentsCollection();
            foreach($shipmentCollection as $ship)
            {
                $shipmentId = $ship->getIncrementId();
            }

            $msg = "Shipment created with ID : ".$shipmentId;
            
            $response = ['message' => $msg, "error" => false];
            
        }catch(\Exception $e) {
            $response = ['message' => $e->getMessage(), 'error' => true];
        }
        return json_encode($response);
    }
}