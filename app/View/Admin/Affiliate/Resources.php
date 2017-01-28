<div class="content-wrapper ng-cloak" ng-app="resourceListApp" ng-controller="resourceListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of resources for affiliates</span> <small><span translate="">(for affiliate center)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-resource"></i> <span translate="">Resource list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">All resources</span>
                    </h3>

                    <div class="box-tools">
                        <a class="btn btn-sm btn-primary btn-flat" ng-href="/admin/affiliate/resource/edit?type={{data.type}}">
                            <i class="fa fa-plus-circle"></i> <span translate="">Create new resource</span>
                        </a>
                    </div>
                </div>

                <div class="box-body">
                    <div class="tabs-panel">
                        <ul class="nav nav-tabs">
                            <li ng-class="{active: type.value === data.type}" ng-repeat="type in data.types">
                                <a href="" ng-href="/admin/affiliate/resources/{{type.value}}">{{type.label | ucfirst}}</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active">
                                <div minute-list-sorter="resources" sort-index="priority">
                                    <div class="list-group-item list-group-item-bar list-group-item-bar-sortable" ng-repeat="resource in resources | orderBy:'priority'"
                                         ng-click-container="mainCtrl.actions(resource)">
                                        <div class="pull-left">
                                            <h4 class="list-group-item-heading">{{resource.priority + 1}}. {{resource.title | ucfirst}} <small>({{resource.group}})</small></h4>
                                            <p class="list-group-item-text hidden-xs">{{resource.value | truncate:100:'..'}}</p>
                                        </div>
                                        <div class="md-actions pull-right">
                                            <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/affiliate/resource/edit/{{resource.affiliate_resource_id}}">
                                                <i class="fa fa-pencil-square-o"></i> <span translate="">Edit..</span>
                                            </a>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="resources" no-results="{{'No resources found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="resources" columns="type, title, value" label="{{'Search resources..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
