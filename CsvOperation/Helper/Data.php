<?php

namespace Bluethink\CsvOperation\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{

    public function __construct(
        \Magento\Framework\Data\Form\FormKey $formKey
    )
    {
        $this->formKey = $formKey; 
    }

    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

}