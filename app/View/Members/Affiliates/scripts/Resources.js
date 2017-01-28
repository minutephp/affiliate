/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var App;
(function (App) {
    var ResourceListController = (function () {
        function ResourceListController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.loaded = function (data) {
                var site = _this.$scope.session.site;
                var hash = angular.extend({}, site, data.affiliate);
                angular.forEach(_this.$scope.resources, function (item) {
                    angular.forEach(['title', 'value'], function (key) {
                        item[key] = item[key].replace(/\{(\w+)\}/g, function (all, match) {
                            return hash[match] || all;
                        });
                    });
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { affiliate: {} };
        }
        return ResourceListController;
    }());
    App.ResourceListController = ResourceListController;
    angular.module('resourceListApp', ['MinuteFramework', 'MembersApp', 'gettext', 'AngularMarkdown'])
        .controller('resourceListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceListController]);
})(App || (App = {}));
