/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class SummaryController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $timeout(() => angular.element('section.content').append(angular.element('#infoBox').remove().css('display', '')), 500);
        }
    }

    angular.module('summaryApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('summaryController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', SummaryController]);
}

angular.element(document).ready(() => {
    angular.bootstrap(document.getElementById("summaryContainer"), ['summaryApp']);
});