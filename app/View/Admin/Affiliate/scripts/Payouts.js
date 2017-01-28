/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var PayoutListController = (function () {
        function PayoutListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.pay = function (payout) {
                var commission = _this.$scope.payouts.create().attr('amount', payout.amount);
                _this.$ui.popupUrl('/commission-popup.html', false, null, { ctrl: _this, payout: payout, commission: commission });
            };
            this.save = function (commission, payout) {
                commission.save(_this.gettext('Commission updated')).then(function () { return payout.amount -= commission.amount; });
                _this.$ui.closePopup();
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return PayoutListController;
    }());
    App.PayoutListController = PayoutListController;
    angular.module('payoutListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('payoutListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PayoutListController]);
})(App || (App = {}));
