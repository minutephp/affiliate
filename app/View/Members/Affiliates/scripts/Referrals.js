/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var ReferralListController = (function () {
        function ReferralListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.name = function (user) {
                return $.trim((user.attr('first_name') || '') + ' ' + (user.attr('last_name') || ''));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }
        return ReferralListController;
    }());
    App.ReferralListController = ReferralListController;
    angular.module('referralListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('referralListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ReferralListController]);
})(App || (App = {}));
