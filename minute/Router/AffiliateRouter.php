<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 8/23/2016
 * Time: 2:30 AM
 */
namespace Minute\Router {

    use App\Model\MAffiliateInfo;
    use Minute\Affiliate\AffiliateInfo;
    use Minute\Cache\QCache;
    use Minute\Config\Config;
    use Minute\Event\RouterEvent;
    use Minute\Http\HttpResponseEx;
    use Minute\Routing\Router;
    use Minute\View\Redirection;

    class AffiliateRouter {
        /**
         * @var QCache
         */
        private $cache;
        /**
         * @var Router
         */
        private $router;
        /**
         * @var Config
         */
        private $config;
        /**
         * @var HttpResponseEx
         */
        private $response;

        /**
         * CmsRouter constructor.
         *
         * @param QCache $cache
         * @param Router $router
         * @param Config $config
         * @param HttpResponseEx $response
         */
        public function __construct(QCache $cache, Router $router, Config $config, HttpResponseEx $response) {
            $this->cache    = $cache;
            $this->router   = $router;
            $this->config   = $config;
            $this->response = $response;
        }

        public function handle(RouterEvent $event) {
            $method = $event->getMethod();
            $path   = '/' . (ltrim($event->getPath(), '/') ?: 'index');

            if (($method === 'GET') && (!$event->getRoute())) {
                $pattern = $this->cache->get("hop-pattern", function () { return join('|', array_map('preg_quote', $this->config->get(AffiliateInfo::AFFILIATE_KEY . '/hops', ['hop']))); }, 600);

                if (preg_match("~/($pattern)/([\\w\\-]+)(/?.*)$~", $path, $matches)) {
                    $username     = $matches[2];
                    $redirectUrl  = $matches[3] ?: '/';
                    $affiliate_id = $this->cache->get("affiliate-$username", function () use ($username) {
                        if ($affiliate = MAffiliateInfo::where('username', '=', $username)->first()) {
                            return $affiliate->user_id;
                        }

                        return null;
                    });

                    if (!empty($affiliate_id)) {
                        if (empty($_COOKIE[AffiliateInfo::AFFILIATE_COOKIE])) {
                            $this->response->setCookie(AffiliateInfo::AFFILIATE_COOKIE, $affiliate_id, '+1 year');
                        }

                        $redir = new Redirection($redirectUrl, $_GET ?? []);
                        $redir->redirect();
                    }
                }
            }
        }
    }
}