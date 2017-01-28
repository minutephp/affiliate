/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ResourceListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService, public gettext: angular.gettext.gettextFunction,
                    public gettextCatalog: angular.gettext.gettextCatalog) {
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {affiliate: {}};
        }

        loaded = (data) => {
            let site = this.$scope.session.site;
            let hash = angular.extend({}, site, data.affiliate);

            angular.forEach(this.$scope.resources, (item) => {
                angular.forEach(['title', 'value'], (key) => {
                    item[key] = item[key].replace(/\{(\w+)\}/g, (all, match) => {
                        return hash[match] || all;
                    });
                });
            });

        };
    }

    angular.module('resourceListApp', ['MinuteFramework', 'MembersApp', 'gettext', 'AngularMarkdown'])
        .controller('resourceListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceListController]);
}
