/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class PayoutListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        pay = (payout) => {
            let commission = this.$scope.payouts.create().attr('amount', payout.amount);
            this.$ui.popupUrl('/commission-popup.html', false, null, {ctrl: this, payout: payout, commission: commission});
        };

        save = (commission, payout) => {
            commission.save(this.gettext('Commission updated')).then(() => payout.amount -= commission.amount);
            this.$ui.closePopup();
        }
    }

    angular.module('payoutListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('payoutListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', PayoutListController]);
}
