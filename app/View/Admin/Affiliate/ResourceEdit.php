<div class="content-wrapper ng-cloak" ng-app="resourceEditApp" ng-controller="resourceEditController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1>
                <span translate="" ng-show="!resource.affiliate_resource_id">Create new</span>
                <span translate="" ng-show="!!resource.affiliate_resource_id">Edit</span>
                <span translate="">resource</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/affiliate/resources/{{resource.type}}"><i class="fa fa-resource"></i> <span translate="">Affiliate Resources</span></a></li>
                <li class="active"><i class="fa fa-edit"></i> <span translate="">Edit resource</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-horizontal" name="resourceForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{resourceForm.$valid && 'success' || 'danger'}}">
                    <div class="box-header with-border">
                        <span translate="" ng-show="!resource.affiliate_resource_id">New resource</span>
                        <span ng-show="!!resource.affiliate_resource_id"><span translate="">Edit</span> {{resource.title}}</span>
                        <span> ({{resource.type}})</span>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="title"><span translate="">Resource title:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" placeholder="Enter Resource title" ng-model="resource.title" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="group"><span translate="">Group:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="group" placeholder="Enter Group" ng-model="resource.group" ng-required="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"><span translate="">Value type:</span></label>
                            <div class="col-sm-9">
                                <label class="radio-inline">
                                    <input type="radio" ng-model="resource.value_type" ng-value="'text'"> Text
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="resource.value_type" ng-value="'banner'"> Banner image
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" ng-model="resource.value_type" ng-value="'code'"> Code
                                </label>
                            </div>
                        </div>

                        <ng-switch on="resource.value_type === 'banner'">
                            <div class="form-group" ng-switch-when="true">
                                <label class="col-sm-3 control-label" for="value"><span translate="">Image Url:</span></label>
                                <div class="col-sm-9">
                                    <input type="url" class="form-control" id="value" placeholder="Enter Image Url" ng-model="resource.value" ng-required="true">
                                </div>
                            </div>

                            <div class="form-group" ng-switch-default="">
                                <label class="col-sm-3 control-label" for="value"><span translate="">Value</span></label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" placeholder="Enter Value" ng-model="resource.value" ng-required="true"></textarea>
                                </div>
                            </div>
                        </ng-switch>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" ng-model="resource.enabled"> <span translate="">Enabled</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="" ng-show="!resource.affiliate_resource_id">Create</span>
                                    <span translate="" ng-show="!!resource.affiliate_resource_id">Update</span>
                                    <span translate="">resource</span>
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
