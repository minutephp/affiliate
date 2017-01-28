<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/22/2016
 * Time: 2:46 AM
 */
namespace Minute\Coupon {

    use App\Model\MAffiliateInfo;
    use App\Model\MProduct;
    use Minute\Affiliate\AffiliateInfo;
    use Minute\Config\Config;
    use Minute\Event\VoucherEvent;

    class AffiliateCoupons {
        /**
         * @var Config
         */
        private $config;

        /**
         * AffiliateCoupons constructor.
         *
         * @param Config $config
         */
        public function __construct(Config $config) {
            $this->config = $config;
        }

        public function applyCoupon(VoucherEvent $event) {
            $code     = $event->getCode();
            $discount = $this->config->get(AffiliateInfo::AFFILIATE_KEY . '/discount', []);

            if (($discount['enabled'] == 'true') && !empty($discount['coupons'])) {
                $products = $this->getAllProductIds($event->getProductId());

                foreach ($discount['coupons'] as $coupon) {
                    $suffix = $coupon['suffix'] ?? 'discount';

                    if (preg_match("/([\\w\\-]+)\\-$suffix$/i", $code, $matches)) {
                        if ($affiliate = MAffiliateInfo::where('username', '=', $matches[1])->first()) {

                            foreach ($products as $product) {
                                if (empty($coupon['product_id']) || ($coupon['product_id'] === $product->product_id)) {
                                    $percentage = $coupon['discount'] . '%';
                                    $overrides  = ['comment' => sprintf('%s discount %s', $percentage, !$coupon['recurring_discount'] ? '(one time)' : '(recurring)')];

                                    if ($coupon['recurring_discount']) {
                                        $overrides['rebill_amount'] = $percentage;
                                    } else {
                                        if ($product->setup_amount > 0) {
                                            $overrides['setup_amount'] = $percentage;
                                        } else { //for non-recurring discount we create a setup amount half the rebill amount for the first 1 month (assuming discount is 50% and rebill time is 1m)
                                            $overrides['setup_amount'] = $product->rebill_amount * min(1, max(0, (1 - ((float) $coupon['discount'] / 100))));
                                            $overrides['setup_time']   = $product->rebill_time;
                                        }
                                    }

                                    $event->addValidCoupon(array_merge($overrides, ['product_id' => $product->product_id]));
                                }
                            }
                        }
                    }
                }
            }
        }

        private function getAllProductIds($product_id = 0) {
            $products = MProduct::all();

            return $product_id > 0 ? $products->where('product_id', '=', $product_id) : $products;
        }
    }
}