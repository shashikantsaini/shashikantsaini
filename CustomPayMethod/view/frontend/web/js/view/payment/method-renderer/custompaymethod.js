define(
    [
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/action/redirect-on-success',
        'mage/url'
    ],
    function (Component, redirectOnSuccessAction, url) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Bluethink_CustomPayMethod/payment/custompaymethod',
                redirectAfterPlaceOrder: false
            },
            getMailingAddress: function () {
                return window.checkoutConfig.payment.checkmo.mailingAddress;
            },
            afterPlaceOrder: function (data, event) {
             // Redirect to your controller action after place order button click
             window.location.replace(url.build('custompaymethod/index/index'));
            }
        });
    }
);