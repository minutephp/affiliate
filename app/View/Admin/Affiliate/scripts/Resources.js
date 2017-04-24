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
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit resource'), 'href': '/admin/affiliate/resource/edit/' + item.affiliate_resource_id },
                    { 'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone resource'), 'click': 'ctrl.clone(item)' },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this resource'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.title, _this.$scope, { item: item, ctrl: _this });
            };
            this.clone = function (resource) {
                var gettext = _this.gettext;
                _this.$ui.prompt(gettext('Enter new title'), gettext('new-title')).then(function (title) {
                    resource.clone().attr('title', title).save(gettext('Resource duplicated'));
                });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {
                type: $scope.session.params.type || 'faq',
                types: [
                    { label: 'FAQ', value: 'faq' }, { label: 'Banners', value: 'banners' }, { label: 'Emails', value: 'emails' }, { label: 'Bonuses', value: 'bonuses' },
                    { label: 'PPC Ads', value: 'ppc' }, { label: 'Tweets', value: 'tweets' }, { label: 'Signatures', value: 'signatures' }, { label: 'Links', value: 'links' },
                    { label: 'Resources', value: 'resources' }
                ]
            };
        }
        return ResourceListController;
    }());
    App.ResourceListController = ResourceListController;
    angular.module('resourceListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resourceListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceListController]);
})(App || (App = {}));
