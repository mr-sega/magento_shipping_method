define(['ko', 'jquery', 'uiComponent', 'mage/url'],
    function (ko, $, Component, urlBuilder) {
        'use strict';

        return Component.extend({
            defaults: {
                "template": "Sega_ChristmasCoins/customer/coins-transaction-table"
            },

            transactions: ko.observableArray([]),

            totalCoins: ko.observable(0),

            userName: ko.observable(),

            initialize: function () {
                this._super();

                this.loadTransactions();

                this.totalCoinsMsg = ko.pureComputed(() => {
                    return 'Welcome ' + this.userName() + ' you have ' + this.totalCoins() + ' Christmas Coins buy more goods to get more Christmas Coins';
                }).bind(this)

                return this;
            },

            loadTransactions: function () {
                $.ajax({
                    url: urlBuilder.build("/coins/index/getList"),
                    showLoader: true,
                    success: response => {
                        if (response.success) {
                            this.transactions(response.data);
                            this.totalCoins(response.totalCoins)
                            this.userName(response.userName)
                        }
                    }
                });
            }
        });
    });
