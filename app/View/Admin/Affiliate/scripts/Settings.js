/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var AffiliateConfigController = (function () {
        function AffiliateConfigController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.editCoupon = function (coupon) {
                if (coupon === void 0) { coupon = null; }
                if (!coupon) {
                    coupon = { suffix: 'discount', discount: 50, recurring_discount: false };
                    _this.$scope.settings.discount.coupons.push(coupon);
                }
                _this.$ui.popupUrl('/coupon-popup.html', false, null, { ctrl: _this, coupon: coupon, products: _this.$scope.products });
            };
            this.save = function () {
                _this.$scope.config.save(_this.gettext('Affiliate saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {
                types: [
                    { label: gettext('All website members (including members referred by existing affiliates)'), value: 'all' },
                    { label: gettext('Non-referred website members only (i.e. direct signups)'), value: 'members' },
                    { label: gettext('By invitation only (using special signup link)'), value: 'nobody' },
                ]
            };
            $scope.config = $scope.configs[0] || $scope.configs.create().attr('type', 'affiliate').attr('data_json', {});
            $scope.settings = $scope.config.attr('data_json');
            $scope.settings.hops = angular.isArray($scope.settings.tiers) ? $scope.settings.hops : ['hop', 'special-offer'];
            $scope.settings.tier1 = angular.isNumber($scope.settings.tier1) ? $scope.settings.tier1 : 50;
            $scope.settings.tier2 = angular.isNumber($scope.settings.tier2) ? $scope.settings.tier2 : 0;
            $scope.settings.holding = $scope.settings.holding > 0 ? $scope.settings.holding : 15;
            $scope.settings.signup = $scope.settings.signup || 'all';
            $scope.settings.discount = angular.isObject($scope.settings.discount) ? $scope.settings.discount : { enabled: true, coupons: [] };
        }
        return AffiliateConfigController;
    }());
    Admin.AffiliateConfigController = AffiliateConfigController;
    angular.module('affiliateConfigApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('affiliateConfigController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', AffiliateConfigController]);
})(Admin || (Admin = {}));
