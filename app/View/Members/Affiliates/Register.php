<div class="content-wrapper ng-cloak" ng-app="affiliateEditApp" ng-controller="affiliateEditController as mainCtrl" ng-init="init()">
    <div class="members-content">
        <section class="content-header">
            <h1>
                <span translate="">Register as an affiliate</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/members"><i class="fa fa-dashboard"></i> <span translate="">Members</span></a></li>
                <li><a href="" ng-href="/members/affiliates"><i class="fa fa-affiliate"></i> <span translate="">New Affiliate Signup</span></a></li>
            </ol>
        </section>

        <section class="content">
            <div class="alert alert-warning alert-dismissible" role="alert" ng-show="!!affiliate.affiliate_info_id">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <i class="fa fa-spinner fa-spin"></i> <span translate="">You are now a registered an affiliate. To change your affiliate details, please contact</span>
                <a ng-href="/members/support"><span translate="">support</span></a>.
            </div>
            <form class="form-horizontal" name="affiliateForm" ng-submit="mainCtrl.save()" ng-show="!affiliate.affiliate_info_id">
                <div class="box box-{{affiliateForm.$valid && 'success' || 'danger'}}">
                    <div class="box-header with-border">
                        <ng-switch on="!!settings.signupBlurb">
                            <span ng-switch-when="true" ng-bind-html="{{settings.signupBlurb"></span>
                            <span translate="" ng-switch-default="">Become an affiliate of {{session.site.name}} and earn {{settings.tier1 || 50}}% of every sale your refer on a recurring
                                basis!</span>
                        </ng-switch>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="username"><span translate="">Username:</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="username" ng-model="affiliate.username" ng-required="true" minlength="3"
                                       placeholder="type your desired username here. Ex: free-trial, best-offer, etc" pattern="[a-z0-9A-Z\-]{3,}">
                                <p class="help-block"><span translate="">(only alphabets, numbers and dashes are allowed)</span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="paypal_email"><span translate="">Paypal email:</span></label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="paypal_email" placeholder="Your verified paypal email for receiving commission money" ng-model="affiliate.paypal_email"
                                       ng-required="true">
                                <p class="help-block"><span translate="">All payments will be sent to you via Paypal only.</span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="country">Country:</label>

                            <div class="col-sm-9">
                                <select class="form-control" ng-model="affiliate.country" ng-required="true" angular-country-select="" title="country"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="phone"><span translate="">Phone number:</span></label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">+{{mainCtrl.getCountryCode(affiliate.country) || '1'}}</div>
                                    <input type="tel" class="form-control" ng-model="affiliate.phone" id="phone" ng-required="true"
                                           placeholder="Your phone number (we will call for verification)" minlength="4">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-show="affiliate.username">
                        <label class="col-sm-3 control-label" for="link">Affiliate links:</label>

                        <div class="col-sm-9">
                            <p class="help-block" ng-repeat="hop in settings.hops || ['hop']">
                                <span class="fake-link" href="" clip-copy="getLink()" clip-click="copied()">
                                    {{session.site.host}}/{{hop}}/{{affiliate.username}}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="">Create your account</span>
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
