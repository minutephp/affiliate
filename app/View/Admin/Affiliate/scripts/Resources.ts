/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class ResourceListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {
                type: $scope.session.params.type || 'faq',
                types: [
                    {label: 'FAQ', value: 'faq'}, {label: 'Banners', value: 'banners'}, {label: 'Emails', value: 'emails'}, {label: 'Bonuses', value: 'bonuses'},
                    {label: 'PPC Ads', value: 'ppc'}, {label: 'Tweets', value: 'tweets'}, {label: 'Signatures', value: 'signatures'}, {label: 'Links', value: 'links'},
                    {label: 'Resources', value: 'resources'}]
            };
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit resource'), 'href': '/admin/affiliate/resource/edit/' + item.affiliate_resource_id},
                {'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone resource'), 'click': 'ctrl.clone(item)'},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this resource'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.title, this.$scope, {item: item, ctrl: this});
        };

        clone = (resource) => {
            let gettext = this.gettext;
            this.$ui.prompt(gettext('Enter new title'), gettext('new-title')).then(function (title) {
                resource.clone().attr('title', title).save(gettext('Resource duplicated'));
            });
        }
    }

    angular.module('resourceListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('resourceListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', ResourceListController]);
}
