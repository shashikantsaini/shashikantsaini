<?php

namespace Bluethink\Quote\Block\Adminhtml\Form;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class OrderButton extends Generic implements ButtonProviderInterface
{
    protected $context;

    public function __construct(
        Context $context
    ) {
        $this->context = $context;
    }

    public function getButtonData()
    {
        $data = [];
        $message = __('Are you sure you want to Order this?');
        $id = $this->context->getRequest()->getParam('id');
        if ($id) {
            $data = [
                'label' => __('Place Order'),
                'class' => 'action primary',
                'on_click' => "confirmSetLocation('{$message}', '{$this->getOrderUrl()}')",
                'sort_order' => 30,
            ];
        }
        return $data;
    }

    public function getOrderUrl()
    {
        $id = $this->context->getRequest()->getParam('id');
        return $this->getUrl('*/*/order', ['id' => $id]);
    }
}