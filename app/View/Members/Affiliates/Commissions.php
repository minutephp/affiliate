<div class="content-wrapper ng-cloak" ng-app="payoutListApp" ng-controller="payoutListController as mainCtrl" ng-init="init()">
    <div class="members-content">
        <section class="content-header">
            <h1><span translate="">Affiliate earnings</span> <small><span translate="">(paid to you)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li class="active"><i class="fa fa-payout"></i> <span translate="">Commissions</span></li>
            </ol>
        </section>

        <section class="content">
            <minute-event name="IMPORT_AFFILIATE_DATA" as="data.affiliate"></minute-event>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">Your affiliate commissions</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-flat btn-xs btn-default" ng-href="/members/affiliates/download/payouts">
                            <i class="fa fa-file-excel-o"></i> <span translate="">Download as Excel file</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{payout.amount > 0 && 'success' || 'danger'}}"
                             ng-repeat="payout in payouts" ng-click-container="mainCtrl.actions(payout)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">{{payout.amount | currency}} on {{payout.created_at | timeAgo}}</h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Transaction id:</span> {{payout.txn_id}}
                                </p>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="payouts" no-results="{{'No payouts found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="payouts" columns="amount,txn_id" label="{{'Search payouts..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
