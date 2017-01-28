/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class PayoutListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit payout'), 'href': '/members/payouts/edit/' + item.payout_id},
                {'text': gettext('Clone'), 'icon': 'fa-copy', 'hint': gettext('Clone payout'), 'click': 'ctrl.clone(item)'},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this payout'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.name, this.$scope, {item: item, ctrl: this});
        };

        clone = (payout) => {
            let gettext = this.gettext;
            this.$ui.prompt(gettext('Enter new attr'), gettext('new-attr')).then(function (attr) {
                payout.clone().attr('attr', attr).save(gettext('Payout duplicated'));
            });
        }
    }

    angular.module('payoutListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('payoutListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PayoutListController]);
}
