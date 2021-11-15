<?php
namespace Bluethink\CustomFieldBill\Plugin\Checkout;

class LayoutProcessor
{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    ) {
        // Loop all payment methods (because billing address is appended to the payments)
        $configuration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'];
        foreach ($configuration as $paymentGroup => $groupConfig) {
            if (isset($groupConfig['component']) AND $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {

                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['alternate_no'] = [
                    'component' => 'Magento_Ui/js/form/element/abstract',
                    'config' => [
                        'customScope' => 'billingAddress.custom_attributes',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/input',
                        'id' => 'alternate_no',
                    ],
                    'dataScope' => $groupConfig['dataScopePrefix'] . '.custom_attributes.alternate_no',
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
