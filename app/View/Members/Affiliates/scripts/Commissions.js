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
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit payout'), 'href': '/members/payouts/edit/' + item.payout_id },
                    { 'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone payout'), 'click': 'ctrl.clone(item)' },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this payout'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, _this.$scope, { item: item, ctrl: _this });
            };
            this.clone = function (payout) {
                var gettext = _this.gettext;
                _this.$ui.prompt(gettext('Enter new attr'), gettext('new-attr')).then(function (attr) {
                    payout.clone().attr('attr', attr).save(gettext('Payout duplicated'));
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return PayoutListController;
    }());
    App.PayoutListController = PayoutListController;
    angular.module('payoutListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('payoutListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PayoutListController]);
})(App || (App = {}));
