/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ResourceEditController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');

            let type = $scope.session.request.type || 'faq';
            $scope.resource = $scope.resources[0] || $scope.resources.create().attr('type', type).attr('value_type', type === 'banners' ? 'banner' : 'text').attr('enabled', true);
        }

        save = () => {
            this.$scope.resource.save(this.gettext('Resource saved successfully'));
        };
    }

    angular.module('resourceEditApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resourceEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceEditController]);
}
