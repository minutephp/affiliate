<div class="content-wrapper ng-cloak" ng-app="resourceListApp" ng-controller="resourceListController as mainCtrl" ng-init="init()">
    <div class="members-content">
        <section class="content-header">
            <h1><span translate="">List of resources</span> <small><span translate="">info</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li class="active"><i class="fa fa-resource"></i> <span translate="">Resource list</span></li>
            </ol>
        </section>

        <section class="content">
            <minute-event name="import.affiliate.data" as="data" on-change="mainCtrl.loaded(data)"></minute-event>

            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <span translate="">Affiliate center</span>
                    </h3>
                </div>

                <div class="box-body">
                    <div class="bs-docs-example" ng-init="selectedTab={type:'faq'}">
                        <ul id="myTab" class="nav nav-tabs">
                            <li ng-class="{active:selectedTab.type===tab.type}" ng-repeat="tab in resources.dump() | unique: 'type'">
                                <a href="" ng-click="selectedTab.type=tab.type">{{tab.type | ucfirst}}</a>
                            </li>
                        </ul>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane" ng-class="{'fade in active':selectedTab.type===group}" ng-repeat="(group, tabs) in resources | groupBy: 'type'">

                                <nav>
                                    <ul class="pagination">
                                        <li ng-repeat="(type, tab) in tabs | groupBy: 'group'"><a href="#{{type}}">{{type}}</a></li>
                                    </ul>
                                </nav>

                                <div class="panel-group" id="accordion{{$index}}" role="tablist" aria-multiselectable="true" ng-repeat="(type, tab) in tabs | groupBy: 'group'">
                                    <a name="{{type}}"></a>

                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse" data-parent="#accordion{{$index}}" href="#collapse{{$index}}" aria-expanded="true"
                                                   aria-controls="collapseOne">
                                                    {{type | ucfirst}}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$index}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <div ng-repeat="item in tab">
                                                    <h4 ng-bind-html="(($index + 1) + '\\. ' + item.title) | markdown"></h4>

                                                    <blockquote class="text-normal" ng-bind-html="item.value | markdown" ng-if="item.value_type === 'text'"></blockquote>

                                                    <div ng-if="item.value_type === 'banner'">
                                                        <p>
                                                            <a href="" ng-click="download(item)"><img src="" ng-src="{{item.value}}" style="max-width: 90%"></a>
                                                        </p>
                                                        <p>
                                                            <a href="" class="btn btn-default btn-xs" ng-click="download(item)"><i class="fa fa-download"></i> Download</a>
                                                            <a href="" class="btn btn-default btn-xs"><i class="fa fa-code"></i> HTML Code</a>
                                                        </p>
                                                    </div>

                                                    <div ng-if="item.value_type === 'code'">
                                                        <p><textarea ng-focus="sel()" class="form-control" readonly rows="3">{{item.value}}</textarea></p>
                                                        <p><a href="" class="btn btn-default btn-xs"><i class="fa fa-copy"></i> Copy to clipboard</a></p>
                                                    </div>

                                                    <hr ng-show="!$last">
                                                </div>
                                            </div>
                                        </div>
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
                            <minute-search-bar on="resources" columns="title, group, value" label="{{'Search resources..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
