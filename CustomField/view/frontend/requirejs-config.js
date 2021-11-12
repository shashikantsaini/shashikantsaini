var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Bluethink_CustomField/js/order/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/set-billing-address': {
                'Bluethink_CustomField/js/order/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Bluethink_CustomField/js/order/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Bluethink_CustomField/js/order/set-billing-address-mixin': true
            }
        }
    },
    "map": {
        "*": {
    "Magento_Checkout/js/model/shipping-save-processor/default" : "Bluethink_CustomField/js/shipping-save-processor"
}
}
    };