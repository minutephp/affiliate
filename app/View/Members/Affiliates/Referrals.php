<div class="content-wrapper ng-cloak" ng-app="referralListApp" ng-controller="referralListController as mainCtrl" ng-init="init()">
    <div class="members-content">
        <section class="content-header">
            <h1><span translate="">List of referrals</span> <small><span translate="">(with purchases)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li class="active"><i class="fa fa-referral"></i> <span translate="">Referral list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border" ng-init="paid = session.params.paid">
                    <h3 class="box-title">
                        <a class="btn btn-sm btn-flat btn-{{paid === null && 'primary' || 'default'}}" ng-href="/members/affiliates/referrals"><span translate="">All referrals</span></a>
                        <a class="btn btn-sm btn-flat btn-{{paid == 'true' && 'primary' || 'default'}}" ng-href="/members/affiliates/referrals/true"><span translate="">Paid referrals</span></a>
                        <a class="btn btn-sm btn-flat btn-{{paid == 'false' && 'primary' || 'default'}}" ng-href="/members/affiliates/referrals/false"><span translate="">Free referrals</span></a>
                    </h3>

                    <div class="box-tools">
                        <a type="button" class="btn btn-flat btn-sm btn-default" ng-href="/members/affiliates/download/referrals">
                            <i class="fa fa-file-excel-o"></i> <span translate="">Download as Excel file</span></a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-default"
                             ng-repeat="referral in referrals" ng-click-container="mainCtrl.actions(referral)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">{{mainCtrl.name(referral.user) || referral.user.email}} ({{referral.user.created_at | timeAgo}})</h4>
                                <p class="list-group-item-text hidden-xs" ng-repeat="purchase in referral.purchases">
                                    {{purchase.created_at | timeAgo | ucfirst}}:
                                    <span translate="" ng-show="purchase.amount <= 0">Purchase of</span>
                                    <span translate="" ng-show="purchase.amount > 0">Refund of</span>
                                    {{-purchase.amount | currency}} (via {{purchase.log.transaction_id}}).
                                </p>

                                <p ng-show="referral.purchases.hasMorePages()">.. {{referral.purchases.getTotalItems() - referral.purchases.getItemsPerPage()}} more purchases.</p>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="referrals" no-results="{{'No referrals found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="referrals" columns="purchases.amount, purchases.log.transaction_id" label="{{'Search referrals..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
