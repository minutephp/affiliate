<div class="content-wrapper ng-cloak" ng-app="payoutListApp" ng-controller="payoutListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of payouts</span> <small><span translate="">(affiliate commissions)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-payout"></i> <span translate="">Payout list</span></li>
            </ol>
        </section>

        <section class="content">
            <minute-event name="import.affiliate.payouts" as="data.payouts"></minute-event>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">Pay affiliates</span>
                    </h3>
                </div>

                <div class="box-body">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-warning"></i> <span translate="">For your own safety, payouts of $50 and more should be sent to phone verified affiliates only.</span>
                    </div>
                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{payout.phone_verified && 'success' || 'danger'}}"
                             ng-repeat="payout in data.payouts" ng-click-container="mainCtrl.actions(payout)" ng-show="payout.amount > 0">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">
                                    {{payout.first_name | ucfirst}} ({{payout.paypal_email}})
                                </h4>
                                <p class="list-group-item-text hidden-xs">
                                    <i class="fa fa-phone-square" tooltip="Phone verified affiliate" ng-show="payout.phone_verified"></i>
                                    <span translate="">Pending commission:</span> {{payout.amount | currency}}.
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <button class="btn btn-default btn-flat btn-sm" ng-click="mainCtrl.pay(payout)">
                                    <i class="fa fa-paypal"></i> <span translate="">Send commission..</span>
                                </button>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/ng-template" id="/commission-popup.html">
        <div class="box">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Send commission</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <form class="form-horizontal" ng-submit="ctrl.save(commission, payout)" name="commissionForm">
                <div class="box-body">
                    <p class="help-block">
                        <span translate="">Please send {{payout.amount | currency}} to {{payout.paypal_email}} via Paypal. Then enter the amount and Transaction Id in the box below to confirm.</span>
                    </p>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="txn_id"><span translate="">Txn Id:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="txn_id" placeholder="Enter Transaction Id" ng-model="commission.txn_id" ng-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="amount"><span translate="">Amount:</span></label>
                        <div class="col-sm-9">
                            <input type="number" step="0.01" class="form-control" id="amount" placeholder="Enter Amount" ng-model="commission.amount" ng-required="true">
                        </div>
                    </div>
                </div>

                <div class="box-footer with-border">
                    <button type="submit" class="btn btn-flat btn-primary pull-right" ng-disabled="!commissionForm.$valid">
                        <span translate>Mark as sent!</span> <i class="fa fa-fw fa-angle-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </script>

</div>
