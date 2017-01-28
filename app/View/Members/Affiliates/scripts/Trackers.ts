/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module App {
    export class TrackerListController {
        constructor(public $scope: any, public $minute: any, public $ui: any, public $timeout: ng.ITimeoutService,
                    public gettext: angular.gettext.gettextFunction, public gettextCatalog: angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
        }

        test = () => {
            this.$timeout(() => console.log(111111111));
        };

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('Edit..'), 'icon': 'fa-edit', 'hint': gettext('Edit tracker'), 'href': '/members/affiliates/trackers/edit/' + item.affiliate_tracker_id},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this tracker'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.tracker_type, this.$scope, {item: item, ctrl: this});
        };
    }

    angular.module('trackerListApp', ['MinuteFramework', 'MembersApp', 'gettext'])
        .controller('trackerListController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', TrackerListController]);
}
