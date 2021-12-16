<?php

namespace Bluethink\PartialCancelOrder\Block\Adminhtml\Order\Edit\Tab;

use Bluethink\PartialCancelOrder\Model\PartialCancel;

class Main extends \Magento\Backend\Block\Widget\Form\Generic
{
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        PartialCancel $partialCancel,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->partialCancel = $partialCancel;
    }

    protected function _prepareForm()
    {
        $result = $this->partialCancel->getCollection();
        foreach($result as $option)
        {
            $options[] = $option->getReason();      
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
            'reason',
            'select',
            [
                'name' => 'reason',
                'label' => __('Reason for Cancellation'),
                'id' => 'reason',
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