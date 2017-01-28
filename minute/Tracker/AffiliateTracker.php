<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/4/2016
 * Time: 10:01 PM
 */
namespace Minute\Tracker {

    use App\Model\MAffiliateTracker;
    use Minute\Affiliate\AffiliateInfo;
    use Minute\Cache\QCache;
    use Minute\Dom\TagUtils;
    use Minute\Event\ResponseEvent;
    use Minute\Utils\TrackerUtils;

    class AffiliateTracker {
        /**
         * @var QCache
         */
        private $cache;
        /**
         * @var TrackerUtils
         */
        private $trackerUtils;
        /**
         * @var TagUtils
         */
        private $tagUtils;

        /**
         * AffiliateTracker constructor.
         *
         * @param QCache $cache
         * @param TrackerUtils $trackerUtils
         * @param TagUtils $tagUtils
         */
        public function __construct(QCache $cache, TrackerUtils $trackerUtils, TagUtils $tagUtils) {
            $this->cache        = $cache;
            $this->trackerUtils = $trackerUtils;
            $this->tagUtils     = $tagUtils;
        }

        public function insertTracker(ResponseEvent $event) {
            if ($event->isSimpleHtmlResponse()) {
                if ($aff_id = (int) (@$_COOKIE[AffiliateInfo::AFFILIATE_COOKIE] ?: 0)) {
                    $code = $this->cache->get("affiliate-tracker-$aff_id", function () use ($aff_id) {
                        $result   = '';
                        $trackers = MAffiliateTracker::where('user_id', '=', $aff_id)->where('enabled', '=', 'true')->get();

                        foreach ($trackers as $tracker) {
                            $result .= $this->trackerUtils->getTrackerCode($tracker->tracker_type, $tracker->tracker_code) . "\n\n";
                        }

                        return trim($result);
                    });

                    if (!empty(trim($code))) {
                        $response = $event->getResponse();
                        $content  = $this->tagUtils->insertBeforeTag('</body>', sprintf('<s' . 'cript>%s</script>', $code), $response->getContent());
                        $response->setContent($content);
                    }
                }
            }
        }
    }
}