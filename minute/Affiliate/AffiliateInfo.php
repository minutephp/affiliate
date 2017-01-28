<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/14/2016
 * Time: 11:52 AM
 */
namespace Minute\Affiliate {

    use App\Model\MAffiliateInfo;
    use App\Model\MAffiliatePayout;
    use App\Model\MAffiliateReferral;
    use Minute\Cache\QCache;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;
    use Minute\Model\CollectionEx;
    use Minute\Session\Session;

    class AffiliateInfo {
        const AFFILIATE_KEY    = "affiliate";
        const AFFILIATE_COOKIE = "affiliate_id";
        /**
         * @var QCache
         */
        private $cache;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Config
         */
        private $config;

        /**
         * AffiliateInfo constructor.
         *
         * @param QCache $cache
         * @param Session $session
         * @param Config $config
         */
        public function __construct(QCache $cache, Session $session, Config $config) {
            $this->cache   = $cache;
            $this->session = $session;
            $this->config  = $config;
        }

        public function printAffiliateData(ImportEvent $event) {
            if ($data = $this->getAffiliateInfo($this->session->getLoggedInUserId())) {
                $event->setContent($data);
            }
        }

        public function getAffiliateInfo(int $affiliate_user_id) {
            return $this->cache->get("affiliate-info-$affiliate_user_id", function () use ($affiliate_user_id) {
                /** @var MAffiliateInfo $affiliate */
                if ($affiliate = MAffiliateInfo::where('user_id', '=', $affiliate_user_id)->first()) {
                    foreach ($this->getAffiliateLinks($affiliate->username) as $index => $link) {
                        $links['affiliate_link' . ($index > 0 ? $index : '')] = $link;
                    }

                    $attributes = array_merge($affiliate->attributesToArray(), $links ?? []);
                    $referrals  = MAffiliateReferral::where('user_id', '=', $affiliate_user_id)->count();
                    $payout     = MAffiliatePayout::where('user_id', '=', $affiliate_user_id)->sum('amount');

                    return ['affiliate' => $attributes, 'referrals' => $referrals, 'payout' => $payout];
                }

                return null;
            }, 300);
        }

        public function getReferredUsers() {
            $user_id = $this->session->getLoggedInUserId();

            return $this->cache->get("referrals-of-$user_id", function () use ($user_id) {
                /** @var CollectionEx $users */
                $users = MAffiliateReferral::where('user_id', '=', $user_id)->get();

                return $users->pluck('signup_user_id')->toArray();
            }, 300);
        }

        public function getReferralInfo(int $user_id) {
            return $this->cache->get("self-info-$user_id", function () use ($user_id) {
                /** @var MAffiliateReferral $self */
                if ($self = MAffiliateReferral::where('signup_user_id', '=', $user_id)->first()) {
                    return $self->attributesToArray();
                }

                return null;
            }, 86400 * 365);
        }

        public function getAffiliateLinks($username) {
            $hops = $this->config->get(AffiliateInfo::AFFILIATE_KEY . '/hops', ['hop']);

            return array_map(function ($hop) use ($username) { return sprintf('%s/%s/%s', $this->config->getPublicVars('host'), $hop, $username); }, $hops);
        }
    }
}