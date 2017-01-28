<div class="content-wrapper ng-cloak" ng-app="trackerListApp" ng-controller="trackerListController as mainCtrl" ng-init="init()">
    <div class="members-content">
        <section class="content-header">
            <h1><span translate="">List of trackers</span> <small><span translate="">info</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li class="active"><i class="fa fa-tracker"></i> <span translate="">Tracker list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">All trackers</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary btn-flat" ng-href="/members/affiliates/trackers/edit">
                            <i class="fa fa-plus-circle"></i> <span translate="">Add new tracker</span>
                        </a>

                        <button type="button" class="btn btn-flat btn-default" ng-click="mainCtrl.test()"><i class="fa fa-check"></i> <span translate="">test</span></button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <i class="fa fa-info-circle"></i> <span translate="">You can use any third party traffic monitoring services like Google analytics, Facebook tracking pixels, and Statcounter to
                            keep track of the hits and signups and measure your advertising ROI.</span>
                    </div>

                    <div class="list-group">
                        <p class="help-block" ng-show="!trackers.length">
                            <i class="fa fa-info-circle"></i> <span translate="">You do not have any trackers installed yet. Please click the "Add new tracker" button to get started.</span>
                        </p>

                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{tracker.enabled && 'success' || 'danger'}}"
                             ng-repeat="tracker in trackers" ng-click-container="mainCtrl.actions(tracker)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">{{tracker.tracker_type | ucfirst}}</h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Created:</span> {{tracker.created_at | timeAgo}}.
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-href="/members/affiliates/trackers/edit/{{tracker.affiliate_tracker_id}}">
                                    <i class="fa fa-pencil-square-o"></i> <span translate="">Edit..</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="trackers" no-results="{{'No trackers found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="trackers" columns="name" label="{{'Search trackers..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
