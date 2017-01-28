<div class="content-wrapper ng-cloak" ng-app="affiliateConfigApp" ng-controller="affiliateConfigController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1>
                <span translate="">Affiliate settings</span>
            </h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-cog"></i> <span translate="">Affiliate settings</span></li>
            </ol>
        </section>

        <section class="content">
            <form class="form-horizontal" name="affiliateForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{affiliateForm.$valid && 'success' || 'danger'}}">
                    <div class="box-body">
                        <fieldset>
                            <h3 class="form-title text-bold"><span translate="">Main settings</span></h3>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="hop"><span translate="">Hop links:</span></label>
                                <div class="col-sm-9 {{!!$index && 'col-sm-offset-3' || ''}}" ng-repeat="hop in settings.hops">
                                    <div class="input-group">
                                        <div class="input-group-addon">{{session.site.host}}/</div>
                                        <input type="text" class="form-control" placeholder="Enter hop link prefix (alphanumeric only)" ng-model="hop" pattern="^[a-zA-Z0-9\-]+$">
                                        <div class="input-group-addon"><i>/affiliate_id</i></div>
                                        <div class="input-group-addon no-border"><a href=""><i class="fa fa-trash"></i></a></div>
                                    </div>
                                    <p class="help-block" ng-show="!!hop"><span translate="">Affiliate's Link:</span> <span class="fake-link">{{session.site.host}}/{{hop}}<i>/affiliate_id</i></span>
                                    </p>
                                </div>

                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="button" class="btn btn-flat btn-default btn-sm" ng-click="settings.hops.push('')">
                                        <i class="fa fa-plus-circle"></i> <span translate="">Add another hop link prefix</span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="tier1"><span translate="">Affiliate commission:</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" step="1" class="form-control" id="tier1" placeholder="Enter First tier payout" ng-model="settings.tier1" ng-required="true" min="0"
                                               max="100">
                                        <div class="input-group-addon">% of each referred sale</div>
                                    </div>
                                    <p class="help-block"><span translate="">(the commission earned directly by the affiliate on each sale)</span></p>
                                </div>
                            </div>

                            <div class="form-group" ng-show="false">
                                <label class="col-sm-3 control-label" for="tier2"><span translate="">Second tier payout:</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="number" step="1" class="form-control" id="tier2" placeholder="Enter First tier payout" ng-model="settings.tier2" ng-required="true" min="0"
                                               max="100">
                                        <div class="input-group-addon">% of each referred sale</div>
                                    </div>
                                    <p class="help-block"><span translate="">(second tier is secondary commission on each sale given to the person who referred the affiliate)</span></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="holding"><span translate="">Holding period:</span></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="holding" placeholder="Enter Holding period" ng-model="settings.holding" ng-required="true">
                                    <p class="help-block text-sm">(<span translate="">Number of days after purchase for which the commission is put on hold (to handle refunds, charge backs, etc)</span>)</p>
                                </div>
                            </div>

                            <h3 class="form-title text-bold"><span translate="">New affiliate registrations</span></h3>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span translate="">Who can signup?</span></label>
                                <div class="col-sm-9">
                                    <div class="radio" ng-repeat="type in data.types">
                                        <label><input type="radio" ng-model="settings.signup" ng-value="type.value"> {{type.label}}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span translate="">Phone verification:</span></label>
                                <div class="col-sm-9">
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="settings.phone_verify" ng-value="true"> Yes, mandatory for all new affiliates
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" ng-model="settings.phone_verify" ng-value="false"> Not required
                                    </label>
                                    <p class="help-block text-sm" ng-show="settings.phone_verify">
                                        <span translate="">(phone verification requires Twilio API access)</span> - <a href="" google-search="twilio api key">learn more</a>
                                    </p>
                                </div>
                            </div>

                            <h3 class="form-title text-bold"><span translate="">Affiliate discounts</span></h3>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"><span translate="">Discount coupons:</span></label>
                                <div class="col-sm-9">
                                    <div class="radio">
                                        <label><input type="radio" ng-model="settings.discount.enabled" ng-value="true"> Yes, all affiliates get special discount coupons to give-away (for
                                            promotion)</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" ng-model="settings.discount.enabled" ng-value="false"> No discount coupons</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" ng-show="!!settings.discount.enabled">
                                <label class="col-sm-3 control-label"><span translate="">Coupons:</span></label>
                                <div class="col-sm-9">
                                    <div class="list-group-item list-group-item-bar" ng-repeat="coupon in settings.discount.coupons">
                                        <div class="pull-left">
                                            <h4 class="list-group-item-heading text-sm">[username]-{{coupon.suffix}}</h4>
                                            <p class="list-group-item-text hidden-xs text-sm">
                                                {{coupon.discount}}% {{coupon.recurring_discount && 'recurring' || ''}} <span translate="">discount on</span>
                                                {{coupon.product_id && 'selected product' || 'all products'}}
                                            </p>
                                        </div>
                                        <div class="pull-right">
                                            <a class="btn btn-default btn-flat btn-xs" ng-click="mainCtrl.editCoupon(coupon)"><span translate="">Edit</span></a>
                                            <a class="btn btn-default btn-flat btn-xs" ng-click="settings.discount.coupons.splice($index, 1)"><span translate="">Remove</span></a>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>

                                    <p class="help-block">
                                        <button type="button" class="btn btn-flat btn-sm btn-default" ng-click="mainCtrl.editCoupon()">
                                            <i class="fa fa-plus-circle"></i> <span translate="">Add coupon..</span>
                                        </button>
                                    </p>
                                </div>
                            </div>

                        </fieldset>
                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-flat btn-primary">
                                    <span translate="">Save all settings</span>
                                    <i class="fa fa-fw fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>

    <script type="text/ng-template" id="/coupon-popup.html">
        <div class="box">
            <div class="box-header with-border">
                <b class="pull-left"><span translate="">Coupon details</span></b>
                <a class="pull-right close-button" href=""><i class="fa fa-times"></i></a>
                <div class="clearfix"></div>
            </div>

            <div class="box-body">
                <form class="form-horizontal" ng-click="ctrl.saveCoupon()" name="couponForm">
                    <p class="help-block text-sm"><span translate="">Discount coupon code help affiliate sell your product without links. Any time a sale is made with a coupon code
                            issued to an affiliate, they are automatically credited for the sale.</span></p>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="suffix"><span translate="">Suffix:</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="suffix" placeholder="Enter coupon suffix" ng-model="coupon.suffix" ng-required="true" minlength="2">
                            <p class="help-block text-sm"><span translate="">The discount coupon code is "[username]-{{coupon.suffix || 'suffix'}}" (without quotes) for each affiliate.</p>
                            <p class="help-block text-sm"><span translate="">Example: If the affiliate username is "johndoe", his discount coupon will be "johndoe-{{coupon.suffix ||
                                    'suffix'}}".</span></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="product"><span translate="">Valid on:</span></label>
                        <div class="col-sm-9">
                            <select id="product" ng-model="coupon.product_id" class="form-control">
                                <option value="">All products</option>
                                <option ng-repeat="product in products" value="{{product.product_id}}">{{product.name}}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="discount"><span translate="">% Discount:</span></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="discount" placeholder="How much is the discount for buyer using the coupon? (% of net sale)"
                                   ng-model="coupon.discount" ng-required="true" min="0" max="100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"><span translate="">Repeat:</span></label>
                        <div class="col-sm-9">
                            <div class="radio">
                                <label><input type="radio" ng-model="coupon.recurring_discount" ng-value="false"> One time discount (first payment only)</label>
                            </div>
                            <div class="radio">
                                <label><input type="radio" ng-model="coupon.recurring_discount" ng-value="true"> Recurring discount (on every payment)</label>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="box-footer with-border">
                <p class="help-block text-sm">
                    <b><span translate="">Note:</span></b>
                    <span translate="">Make sure to update your affiliate FAQs to tell your affiliates about this coupon code!</span>
                    <a ng-href="/admin/affiliate/resources" target="_blank"><span translate="">Edit FAQ</span> <i class="fa fa-external-link"></i></a>
                </p>

                <button type="button" class="btn btn-flat btn-primary pull-right close-button" ng-disabled="!couponForm.$valid">
                    <span translate>Save coupon</span> <i class="fa fa-fw fa-angle-right"></i>
                </button>
            </div>
        </div>
    </script>

</div>
