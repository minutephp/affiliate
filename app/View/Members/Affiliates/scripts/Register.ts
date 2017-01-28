/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class AffiliateEditController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService, public gettext: angular.gettext.gettextFunction,
                    public gettextCatalog: angular.gettext.gettextCatalog, public $country: any) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.affiliate = $scope.affiliates[0] || $scope.affiliates.create().attr('country', 'United States');
            $scope.config = $scope.configs[0];
            $scope.settings = $scope.config.attr('data_json') || {};

            $scope.$watch('affiliate.affiliate_info_id', (id) => {
                if (id > 0) {
                    top.location.href = '/members/affiliates/resources'
                }
            });
        }

        getCountryCode = (name) => {
            var country = this.$country.getCountry('name', name);
            return country ? country.code : '1';
        };

        save = () => {
            this.$scope.affiliate.save(this.gettext('Affiliate registration successful'));
        };
    }

    angular.module('affiliateEditApp', ['MinuteFramework', 'MembersApp', 'gettext', 'AngularCountrySelect'])
        .controller('affiliateEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', '$country', AffiliateEditController]);
}
