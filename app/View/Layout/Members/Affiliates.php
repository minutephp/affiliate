<div ng-controller="summaryController" id="summaryContainer" style="display: none" ng-if="!!data.affiliate">
    <minute-event name="IMPORT_AFFILIATE_DATA" as="data.affiliate"></minute-event>

    <div class="box box-info" id="infoBox">
        <div class="box-header with-border">
            <div class="row">
                <div class="col-xs-3">
                    <p><b><span translate="">Earning:</span></b><br>
                        {{data.affiliate.payout | currency}}</p>
                </div>
                <div class="col-xs-3">
                    <p><b><span translate="">Referrals:</span></b><br>
                        {{data.affiliate.referrals | number}} <span translate="">total</span></p>
                </div>
                <div class="col-xs-6">
                    <p><b><span translate="">Your Link:</span></b><br>
                        <input class="form-control input-sm no-border affiliate-input" value="{{data.affiliate.affiliate.affiliate_link}}" onfocus="this.select()" title="Press Ctrl+C to copy">
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<minute-include-content></minute-include-content>
