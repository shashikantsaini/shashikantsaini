<?php

namespace Bluethink\Faq\Ui\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Enable')], ['value' => 0, 'label' => __('Disable')]];
    }
}