<div class="content-wrapper ng-cloak" ng-app="trackerEditApp" ng-controller="trackerEditController as mainCtrl" ng-init="init()">
    <div class="members-content">
        <section class="content-header">
            <h1>
                <span translate="" ng-show="!tracker.affiliate_tracker_id">Create new</span>
                <span translate="" ng-show="!!tracker.affiliate_tracker_id">Edit</span>
                <span translate="">tracker</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li><a href="" ng-href="/members/affiliates/trackers"><i class="fa fa-tracker"></i> <span translate="">Trackers</span></a></li>
                <li class="active"><i class="fa fa-edit"></i> <span translate="">Edit tracker</span></li>
            </ol>
        </section>

        <section class="content">
            <minute-event name="IMPORT_TRACKER_LIST" as="data.types"></minute-event>

            <form class="form-horizontal" name="trackerForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{trackerForm.$valid && 'success' || 'danger'}}">
                    <div class="box-header with-border">
                        <span translate="" ng-show="!tracker.affiliate_tracker_id">New tracker</span>
                        <span ng-show="!!tracker.affiliate_tracker_id"><span translate="">Edit</span> {{tracker.name}}</span>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span translate="">Tracker type:</span></label>
                            <div class="col-sm-9">
                                <select id="type" ng-model="tracker.tracker_type" ng-required="true" class="form-control">
                                    <option ng-repeat="type in data.types" value="{{type.value}}">{{type.label}}</option>
                                </select>
                            </div>
                        </div>

                        <div ng-show="!!data.selected.field">
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tracking_code"><span translate="">{{data.selected.field}}:</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="tracking_code" placeholder="Enter {{data.selected.field}}" ng-model="tracker.tracker_code" ng-required="true" minlength="5">
                                    <p class="help-block"><span translate="">{{data.selected.hint}}</span></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span translate="">Tracker enabled:</span></label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="tracker.enabled" ng-value="true"> <span translate="">Yes</span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="tracker.enabled" ng-value="false"> <span translate="">No</span>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="" ng-show="!tracker.affiliate_tracker_id">Create</span>
                                    <span translate="" ng-show="!!tracker.affiliate_tracker_id">Update</span>
                                    <span translate="">tracker</span>
                                    <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
