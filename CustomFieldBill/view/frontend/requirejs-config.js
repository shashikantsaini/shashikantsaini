var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-billing-address': {
                'Bluethink_CustomFieldBill/js/order/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Bluethink_CustomFieldBill/js/order/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Bluethink_CustomFieldBill/js/order/set-billing-address-mixin': true
            }
        }
    }
};