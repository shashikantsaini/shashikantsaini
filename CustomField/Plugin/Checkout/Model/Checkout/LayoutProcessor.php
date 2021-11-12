<?php
namespace Bluethink\CustomField\Plugin\Checkout\Model\Checkout;


class LayoutProcessor

{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {

        $customAttributeCode = 'deliverytime';

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customAttributeCode] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'id' => 'deliverytime'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $customAttributeCode,
            'label' => 'Delivery Time',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 252,
            'id' => 'deliverytime'
        ];

        $customDateCode = 'delivery_date';
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children'][$customDateCode] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/date',
                'options' => [],
                'id' => 'delivery_date'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $customDateCode,
            'label' => 'Delivery Date',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 302,
            'id' => 'delivery_date'
        ];


        $configuration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'];
        foreach ($configuration as $paymentGroup => $groupConfig) 
        {
            if (isset($groupConfig['component']) AND $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') 
            {
                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['alternate_no'] = [
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input',
                        'id' => 'alternate_no',
                    ],
                    'dataScope' => $groupConfig['dataScopePrefix'] . '.alternate_no',
                    'label' => __('Alternate Number'),
                    'provider' => 'checkoutProvider',
                    'visible' => true,
                    'validation' => [
                        'required-entry' => true,
                        'min_text_length' => 0,
                    ],
                    'sortOrder' => 300,
                    'id' => 'alternate_no'
                ];
            }
        }

        return $jsLayout;
    }

}