<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Edit\Tab;

use Bluethink\PartialCancelOrder\Model\PartialCancelReason;

class Main extends \Magento\Backend\Block\Widget\Form\Generic
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        PartialCancelReason $partialCancelreason,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->partialCancelreason = $partialCancelreason;
    }

    protected function _prepareForm()
    {
        $result = $this->partialCancelreason->getCollection();
        foreach($result as $option)
        {
            $options[] = ['value' => $option->getReasonCode(), 'label' => $option->getReasonLabel()];     
        }

        $model = $this->_coreRegistry->registry('order_data');

        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('partialcancelorder_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Edit Order'), 'class' => 'fieldset-wide']
        );

        $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);

        $fieldset->addField(
            'reason_code',
            'select',
            [
                'name' => 'reason_code',
                'label' => __('Reason for Cancellation'),
                'id' => 'reason_code',
                'title' => __('Reason for Cancellation'),
                'class' => 'required-entry',
                'required' => true,
                'values' => $options,
            ]
        );
        
        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}