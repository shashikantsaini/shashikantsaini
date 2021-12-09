<?php

namespace Bluethink\CustomApi\Api;

interface ShipmentRepositoryInterface 
{
    /**
     * GET for Post api
     * @param string $storeid
     * @param string $name
     * @param string $city
     * @return string
     */
    public function createShipment( $orderid, $status, \Bluethink\CustomApi\Api\ShipmentInterface $trackingInfo);
}