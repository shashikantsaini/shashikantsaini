<?php

namespace Bluethink\CustomApi\Api;

interface ShipmentRepositoryInterface 
{
    /**
     * GET for Post api
     * @param string $orderid
     * @param string $status
     * @param objects $trackingInfo
     * @return Bluethink\CustomApi\Api\Response\ResponseInterface containing Tree objects
     */
    public function createShipment( $orderid, $status, \Bluethink\CustomApi\Api\ShipmentInterface $trackingInfo);
}