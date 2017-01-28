<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/21/2016
 * Time: 8:14 AM
 */
namespace Minute\Affiliate {

    use App\Model\MAffiliateInfo;
    use App\Model\MAffiliatePayout;
    use App\Model\MAffiliateReferral;
    use App\Model\MWallet;
    use App\Model\User;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Builder;
    use Minute\Cache\QCache;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;
    use Minute\Model\CollectionEx;

    class AffiliatePayouts {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var QCache
         */
        private $cache;

        /**
         * AffiliatePayouts constructor.
         *
         * @param Config $config
         * @param QCache $cache
         */
        public function __construct(Config $config, QCache $cache) {
            $this->config = $config;
            $this->cache  = $cache;
        }

        public function calculate(ImportEvent $event) {
            /** @var CollectionEx $purchases */
            $now       = Carbon::now();
            $holding   = $this->config->get(AffiliateInfo::AFFILIATE_KEY . '/holding', -7);
            $tier1     = $this->config->get(AffiliateInfo::AFFILIATE_KEY . '/tier1', 50);
            $purchases = MWallet::where(function (Builder $query) use ($now, $holding) { $query->where('payment_type', '=', 'purchase')->where('created_at', '<', $now->subDay($holding)); })
                                ->orWhere('payment_type', '=', 'purchase_cancel')->get();

            $tier1       = max(0, min(100, ((float) $tier1 / 100)));
            $commissions = [];

            foreach ($purchases as $purchase) {
                if ($aff_id = $this->getOwnerId($purchase->user_id)) {
                    $commissions[$aff_id] = ($commissions[$aff_id] ?? 0) + (-$purchase->amount * $tier1);
                }
            }

            foreach ($commissions as $aff_id => $amount) {
                $paid = MAffiliatePayout::where('user_id', '=', $aff_id)->sum('amount');
                $commissions[$aff_id] -= $paid;

                if ($commissions[$aff_id] <= 0) {
                    unset($commissions[$aff_id]);
                }
            }

            $user_ids = array_keys($commissions);

            /** @var CollectionEx $users */
            /** @var CollectionEx $infos */
            $users = User::whereIn('user_id', $user_ids)->get();
            $infos = MAffiliateInfo::whereIn('user_id', $user_ids)->get();

            foreach ($commissions as $aff_id => $amount) {
                $user = $users->where('user_id', '=', $aff_id)->first();
                $aff  = $infos->where('user_id', '=', $aff_id)->first();

                $affiliates[] = array_merge($user ? $user->attributesToArray() : [], $aff ? $aff->attributesToArray() : [], ['amount' => $amount]);
            }

            $event->setContent($affiliates ?? []);
        }

        private function getOwnerId($user_id) {
            $aff_id = $this->cache->get("owner-$user_id", function () use ($user_id) {
                if ($aff = MAffiliateReferral::where('signup_user_id', '=', $user_id)->first()) {
                    return $aff->user_id;
                }

                return null;
            });

            return $aff_id ?? 0;
        }
    }
}