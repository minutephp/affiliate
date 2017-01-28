/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ReferralListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        name = (user) => {
            return $.trim((user.attr('first_name') || '') + ' ' + (user.attr('last_name') || ''));
        };
    }

    angular.module('referralListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('referralListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ReferralListController]);
}
