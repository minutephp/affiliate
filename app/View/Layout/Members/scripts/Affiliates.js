/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var SummaryController = (function () {
        function SummaryController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $timeout(function () { return angular.element('section.content').append(angular.element('#infoBox').remove().css('display', '')); }, 500);
        }
        return SummaryController;
    }());
    App.SummaryController = SummaryController;
    angular.module('summaryApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('summaryController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', SummaryController]);
})(App || (App = {}));
angular.element(document).ready(function () {
    angular.bootstrap(document.getElementById("summaryContainer"), ['summaryApp']);
});
