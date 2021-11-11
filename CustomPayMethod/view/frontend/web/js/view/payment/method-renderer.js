define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'custompaymethod',
                component: 'Bluethink_CustomPayMethod/js/view/payment/method-renderer/custompaymethod'
            }
        );
        return Component.extend({});
    }
);