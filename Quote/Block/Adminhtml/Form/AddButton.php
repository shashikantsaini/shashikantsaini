<?php

namespace Bluethink\Quote\Block\Adminhtml\Form;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class AddButton extends Generic implements ButtonProviderInterface
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
        $message = __('Are you sure you want to Add item?');
        $id = $this->context->getRequest()->getParam('id');
        if ($id) {
            $data = [
                'label' => __('Add Item(s)'),
                'class' => 'action secondary',
                'on_click' => "confirmSetLocation('{$message}', '{$this->getAddUrl()}')",
                'sort_order' => 10,
            ];
        }
        return $data;
    }

    public function getAddUrl()
    {
        $id = $this->context->getRequest()->getParam('id');
        return $this->getUrl('*/*/add', ['entity_id' => $id]);
    }
}