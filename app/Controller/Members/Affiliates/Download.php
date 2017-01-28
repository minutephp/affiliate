<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members\Affiliates {

    use App\Model\MAffiliatePayout;
    use App\Model\MAffiliateReferral;
    use App\Model\MWallet;
    use App\Model\User;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Builder;
    use Minute\Affiliate\AffiliateInfo;
    use Minute\Config\Config;
    use Minute\Http\HttpResponseEx;
    use Minute\Model\CollectionEx;
    use Minute\Session\Session;

    class Download {
        /**
         * @var AffiliateInfo
         */
        private $affiliateInfo;
        /**
         * @var Config
         */
        private $config;
        /**
         * @var HttpResponseEx
         */
        private $response;
        /**
         * @var Session
         */
        private $session;

        /**
         * Download constructor.
         *
         * @param AffiliateInfo $affiliateInfo
         * @param Config $config
         * @param HttpResponseEx $response
         * @param Session $session
         */
        public function __construct(AffiliateInfo $affiliateInfo, Config $config, HttpResponseEx $response, Session $session) {
            $this->config        = $config;
            $this->affiliateInfo = $affiliateInfo;
            $this->response      = $response;
            $this->session       = $session;
        }

        public function referrals() {
            $this->response->asFile('affiliate_referrals.csv', 'text/csv');

            $now = Carbon::now();
            $csv = fopen('php://output', 'w');
            fputcsv($csv, ['Date', 'User', 'Email', 'From', 'Campaign', 'Type', 'Amount', 'Commission', 'Payment status']);

            $user_ids = $this->affiliateInfo->getReferredUsers();
            $holding  = $this->config->get(AffiliateInfo::AFFILIATE_KEY . '/holding', 7);
            $tier1    = $this->config->get(AffiliateInfo::AFFILIATE_KEY . '/tier1', 50);
            $tier1    = max(0, min(100, ((float) $tier1 / 100)));

            if (!empty($user_ids)) {
                /** @var CollectionEx $users */
                $users = User::whereIn('user_id', $user_ids)->orderBy('user_id', 'DESC')->get();
                /** @var CollectionEx $purchases */
                $purchases = MWallet::whereIn('user_id', $user_ids)->where(function (Builder $builder) {
                    $builder->where('payment_type', '=', 'purchase')->orWhere('payment_type', '=', 'purchase_cancel');
                })->get();

                foreach ($users as $user) {
                    $records = $purchases->where('user_id', '=', $user->user_id);

                    if (count($records)) {
                        foreach ($records as $record) {
                            $date       = Carbon::parse($record->created_at);
                            $commission = -$record->amount * $tier1;
                            $onHold     = $commission <= 0 ? 'n/a' : ($date->addDay($holding) > $now ? 'On hold' : 'Confirmed');

                            fputcsv($csv, [$date->format('d-M-Y'), trim($user->first_name . ' ' . $user->last_name), $user->email, $user->http_referrer ?? 'Unknown', $user->http_campaign ?? '',
                                           $record->payment_type, (float) -$record->amount, (float) $commission, $onHold]);
                        }
                    } else {
                        $date = Carbon::parse($user->created_at);
                        fputcsv($csv, [$date->format('d-M-Y'), trim($user->first_name . ' ' . $user->last_name), $user->email, $user->http_referrer ?? 'Unknown', $user->http_campaign ?? '',
                                       'Free signup', 0, 0, 'n/a']);
                    }
                }
            }

            fclose($csv);
        }

        public function payouts() {
            $this->response->asFile('affiliate_payouts.csv', 'text/csv');

            $now = Carbon::now();
            $csv = fopen('php://output', 'w');
            fputcsv($csv, ['Date', 'Amount', 'Transaction Id']);
            $payouts = MAffiliatePayout::where('user_id', '=', $this->session->getLoggedInUserId())->orderBy('created_at', 'DESC')->get();

            foreach ($payouts as $payout) {
                $date = Carbon::parse($payout->created_at);
                fputcsv($csv, [$date->format('d-M-Y'), (float) $payout->amount, $payout->txn_id]);
            }

            fclose($csv);
        }
    }
}