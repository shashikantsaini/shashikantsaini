<?php

namespace Bluethink\CustomApi\Model;

use Bluethink\CustomApi\Api\ShipmentSaveInterface;

class ShipmentSave implements ShipmentSaveInterface
{
    /*
    * @var string
    */
    protected $shippingLabel;

    /*
    * @var string
    */
    protected $trackingUrl;

    public function __construct()
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingLabel()
    {
        return $this->shippingLabel;
    }

    /**
     * {@inheritdoc}
     */
    public function setShippingLabel($shippingLabel)
    {
        $this->shippingLabel = $shippingLabel;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTrackingUrl()
    {
        return $this->trackingUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function setTrackingUrl($trackingUrl)
    {
        $this->trackingUrl = $trackingUrl;
        return $this;
    }
}