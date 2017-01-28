/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var TrackerListController = (function () {
        function TrackerListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.test = function () {
                _this.$timeout(function () { return console.log(111111111); });
            };
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit tracker'), 'href': '/members/affiliates/trackers/edit/' + item.affiliate_tracker_id },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this tracker'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.tracker_type, _this.$scope, { item: item, ctrl: _this });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return TrackerListController;
    }());
    App.TrackerListController = TrackerListController;
    angular.module('trackerListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('trackerListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TrackerListController]);
})(App || (App = {}));
