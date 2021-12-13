<?php

namespace Bluethink\CustomApi\Model;

use Magento\Sales\Model\OrderFactory ;
use Bluethink\CustomApi\Api\ShipmentRepositoryInterface ;
use Bluethink\CustomApi\Api\ShipmentInterface ;

class ShipmentRepository implements ShipmentRepositoryInterface
{
    public function __construct(
        OrderFactory $orderFactory,
        \Bluethink\CustomApi\Api\Response\ResponseInterfaceFactory $responseFactory,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->orderFactory = $orderFactory;
        $this->responseFactory = $responseFactory;
        $this->_logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function createShipment($orderId,$status, ShipmentInterface $trackingInfo)
    {
        try{
            // Load the order increment ID
            $order = $this->orderFactory->create()->loadByIncrementID($orderId);

            //Save trackingInfo in Order table
            $order->setData('shipping_label',$trackingInfo->getShippingLabel());
            $order->setData('tracking_url',$trackingInfo->getTrackingUrl());
            $order->save();

            $response = $this->responseFactory->create();
            $response->setMessage('Order Changes Saved');
            $response->setError(false);
            // $msg = "Order has been Saved.";
            // $response = ['message' => $msg, "error" => false];           
            
        }catch(\Exception $e) {
            $response = $this->responseFactory->create();
            $response->getMessage($e->getMessage());
            $response->getError(true);
            // $response = ['message' => $e->getMessage(), 'error' => true];
            $this->logger->debug($e->getMessage());
        }
        return $response;
    }
}