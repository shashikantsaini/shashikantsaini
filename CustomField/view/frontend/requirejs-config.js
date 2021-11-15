var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Bluethink_CustomField/js/order/set-shipping-information-mixin': true
            }
        }
    },
    "map": {
        "*": {
    "Magento_Checkout/js/model/shipping-save-processor/default" : "Bluethink_CustomField/js/shipping-save-processor"
}
}
    };