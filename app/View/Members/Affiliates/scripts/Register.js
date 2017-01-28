/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var AffiliateEditController = (function () {
        function AffiliateEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog, $country) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.$country = $country;
            this.getCountryCode = function (name) {
                var country = _this.$country.getCountry('name', name);
                return country ? country.code : '1';
            };
            this.save = function () {
                _this.$scope.affiliate.save(_this.gettext('Affiliate registration successful'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.affiliate = $scope.affiliates[0] || $scope.affiliates.create().attr('country', 'United States');
            $scope.config = $scope.configs[0];
            $scope.settings = $scope.config.attr('data_json') || {};
            $scope.$watch('affiliate.affiliate_info_id', function (id) {
                if (id > 0) {
                    top.location.href = '/members/affiliates/resources';
                }
            });
        }
        return AffiliateEditController;
    }());
    App.AffiliateEditController = AffiliateEditController;
    angular.module('affiliateEditApp', ['MinuteFramework', 'MembersApp', 'gettext', 'AngularCountrySelect'])
        .controller('affiliateEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', '$country', AffiliateEditController]);
})(App || (App = {}));
