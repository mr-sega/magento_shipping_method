define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (Component, rendererList) {
        'use strict';

        const isEnabled = window.checkoutConfig.payment.coins.enable;
        if (isEnabled){
            rendererList.push(
                {
                    type: 'coins',
                    component: 'Sega_ChristmasCoins/js/view/payment/method-renderer/coins-method'
                }
            );
        }

        return Component.extend({});
    }
);
