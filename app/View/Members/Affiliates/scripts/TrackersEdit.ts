/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class TrackerEditController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.tracker = $scope.trackers[0] || $scope.trackers.create().attr('tracker_type', 'google').attr('enabled', 'true');
            $scope.data = {};

            $scope.$watch('tracker.tracker_type + data.types', () => {
                let type = $scope.tracker.tracker_type;

                if (type && $scope.data.types) {
                    $scope.data.selected = null;

                    for (let t of $scope.data.types) {
                        if (t.value === type) {
                            $scope.data.selected = t;
                            break;
                        }
                    }
                }
            });
        }

        save = () => {
            this.$scope.tracker.save(this.gettext('Tracker saved successfully'), false).catch((result) => {
                if (result && result.error && /duplicate/i.test(result.error.data)) {
                    this.$ui.toast(this.gettext('You already have a ' + this.$scope.tracker.tracker_type + ' tracker added in your account.'), 'error');
                }
            });
        };
    }

    angular.module('trackerEditApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('trackerEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TrackerEditController]);
}
