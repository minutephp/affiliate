/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var ResourceEditController = (function () {
        function ResourceEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.save = function () {
                _this.$scope.resource.save(_this.gettext('Resource saved successfully'));
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            var type = $scope.session.request.type || 'faq';
            $scope.resource = $scope.resources[0] || $scope.resources.create().attr('type', type).attr('value_type', type === 'banners' ? 'banner' : 'text').attr('enabled', true);
        }
        return ResourceEditController;
    }());
    App.ResourceEditController = ResourceEditController;
    angular.module('resourceEditApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resourceEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceEditController]);
})(App || (App = {}));
