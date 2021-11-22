<?php

namespace Bluethink\CustomPayMethod\Model;

class CustomPayMethod extends \Magento\Payment\Model\Method\AbstractMethod
{    
    protected $_code = 'custompaymethod';
/**
     * Payment Method feature
     *
     * @var bool
     */
    protected $_canAuthorize = true;

}