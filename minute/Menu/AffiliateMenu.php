<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use App\Model\MAffiliateInfo;
    use Minute\Affiliate\AffiliateInfo;
    use Minute\Cache\QCache;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;
    use Minute\Session\Session;

    class AffiliateMenu {
        /**
         * @var Config
         */
        private $config;
        /**
         * @var QCache
         */
        private $cache;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var AffiliateInfo
         */
        private $affiliateInfo;

        /**
         * AffiliateMenu constructor.
         *
         * @param Config $config
         * @param QCache $cache
         * @param Session $session
         * @param AffiliateInfo $affiliateInfo
         */
        public function __construct(Config $config, QCache $cache, Session $session, AffiliateInfo $affiliateInfo) {
            $this->config        = $config;
            $this->cache         = $cache;
            $this->session       = $session;
            $this->affiliateInfo = $affiliateInfo;
        }

        public function adminLinks(ImportEvent $event) {
            $links = [
                'affiliates' => ['title' => 'Affiliates', 'icon' => 'fa-money', 'priority' => 90],
                'affiliate-settings' => ['title' => 'Settings', 'icon' => 'fa-cog', 'priority' => 1, 'href' => '/admin/affiliate/settings', 'parent' => 'affiliates'],
                'affiliate-payouts' => ['title' => 'Payouts', 'icon' => 'fa-dollar', 'priority' => 2, 'href' => '/admin/affiliate/payouts', 'parent' => 'affiliates'],
                'affiliate-resources' => ['title' => 'Resources', 'icon' => 'fa-list-ol', 'priority' => 3, 'href' => '/admin/affiliate/resources', 'parent' => 'affiliates'],
            ];

            $event->addContent($links);
        }

        public function memberLinks(ImportEvent $event) {
            $user_id = $this->session->getLoggedInUserId();
            $links   = $this->cache->get("affiliate-menu-$user_id", function () use ($user_id) {
                $affiliate  = $this->affiliateInfo->getAffiliateInfo($user_id);
                $visibility = $affiliate ? 'all' : $this->config->get('affiliate/signup', 'none');

                if ($visibility === 'members') {
                    if (!($referral = $this->affiliateInfo->getReferralInfo($user_id))) { //if this person is referred
                        $visibility = 'all';
                    }
                }

                if ($visibility === 'all') {
                    $links = ['affiliates' => ['title' => 'Affiliates', 'icon' => 'fa-money', 'priority' => 90]];

                    if ($affiliate) {
                        $links['affiliate-resources'] = ['title' => 'Resource kit', 'icon' => 'fa-briefcase', 'priority' => 1, 'href' => '/members/affiliates/resources', 'parent' => 'affiliates'];
                        //$links['affiliate-wizard']    = ['title' => 'Affiliate Wizard', 'icon' => 'fa-magic', 'priority' => 2, 'href' => '/members/affiliates/wizard', 'parent' => 'affiliates'];
                        $links['affiliate-referral'] = ['title' => 'Referral summary', 'icon' => 'fa-bolt', 'priority' => 3, 'href' => '/members/affiliates/referrals', 'parent' => 'affiliates'];
                        $links['affiliate-payments'] = ['title' => 'Commission summary', 'icon' => 'fa-money', 'priority' => 4, 'href' => '/members/affiliates/commissions', 'parent' => 'affiliates'];
                        $links['affiliate-tracking'] = ['title' => 'Traffic tracker', 'icon' => 'fa-code', 'priority' => 6, 'href' => '/members/affiliates/trackers', 'parent' => 'affiliates'];
                    } else {
                        $links['affiliate-register'] = ['title' => 'Become an affiliate', 'icon' => 'fa-dollar', 'priority' => 1, 'href' => '/members/affiliates/register', 'parent' => 'affiliates'];
                    }
                }

                return $links ?? [];
            }, 3600);

            $event->addContent($links);
        }
    }
}