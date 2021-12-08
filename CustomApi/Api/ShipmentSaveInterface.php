<?php

namespace Bluethink\CustomApi\Api;

interface ShipmentSaveInterface 
{
    /**
     * GET Shipping Label
     * @return string
     */
    public function getShippingLabel();

    /**
     * SET Shipping Label
     * @param int $shippingLabel
     * @return string
     */
    public function setShippingLabel($shippingLabel);

    /**
     * GET Tracking Url
     * @return string
     */
    public function getTrackingUrl();

    /**
     * SET Tracking Url
     * @param int $trackingUrl
     * @return string
     */
    public function setTrackingUrl($trackingUrl);
}