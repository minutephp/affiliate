/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var TrackerEditController = (function () {
        function TrackerEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.tracker.save(_this.gettext('Tracker saved successfully'), false).catch(function (result) {
                    if (result && result.error && /duplicate/i.test(result.error.data)) {
                        _this.$ui.toast(_this.gettext('You already have a ' + _this.$scope.tracker.tracker_type + ' tracker added in your account.'), 'error');
                    }
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.tracker = $scope.trackers[0] || $scope.trackers.create().attr('tracker_type', 'google').attr('enabled', 'true');
            $scope.data = {};
            $scope.$watch('tracker.tracker_type + data.types', function () {
                var type = $scope.tracker.tracker_type;
                if (type && $scope.data.types) {
                    $scope.data.selected = null;
                    for (var _i = 0, _a = $scope.data.types; _i < _a.length; _i++) {
                        var t = _a[_i];
                        if (t.value === type) {
                            $scope.data.selected = t;
                            break;
                        }
                    }
                }
            });
        }
        return TrackerEditController;
    }());
    App.TrackerEditController = TrackerEditController;
    angular.module('trackerEditApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('trackerEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TrackerEditController]);
})(App || (App = {}));
