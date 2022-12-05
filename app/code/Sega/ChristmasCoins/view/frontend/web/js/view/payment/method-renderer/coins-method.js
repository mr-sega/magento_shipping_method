define(
    [
        'ko',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Customer/js/model/customer',
        'mage/translate'
    ],
    function (
        ko,
        Component,
        customer,
    ) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Sega_ChristmasCoins/payment/coins'
            },

            currentCoins: ko.observable(0),

            initialize: function () {
                this._super();

                if (customer.isLoggedIn() && customer.customerData.custom_attributes) {
                    this.currentCoins(Math.round(customer.customerData.custom_attributes.coins.value * 100) / 100);
                }
            }
        });
    }
);
