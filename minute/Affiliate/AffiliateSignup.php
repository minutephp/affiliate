<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/16/2016
 * Time: 3:16 AM
 */
namespace Minute\Affiliate {

    use App\Model\MAffiliateReferral;
    use Carbon\Carbon;
    use Minute\Event\UserSignupEvent;
    use Minute\Event\WalletOrderEvent;
    use Minute\Event\WalletPurchaseEvent;

    class AffiliateSignup {
        public function setReferrer(UserSignupEvent $event) {
            if ($aff_id = $_COOKIE[AffiliateInfo::AFFILIATE_COOKIE] ?? null) {
                if ($user_id = $event->getUserId()) {
                    MAffiliateReferral::unguard(true);
                    MAffiliateReferral::create(['created_at' => Carbon::now(), 'user_id' => $aff_id, 'signup_user_id' => $user_id]);
                }
            }
        }

        public function markAsPaid(WalletPurchaseEvent $event) {
            if ($signup_user_id = $event->getUserId()) {
                /** @var MAffiliateReferral $referral */
                if ($referral = MAffiliateReferral::where('signup_user_id', '=', $signup_user_id)->first()) {
                    $referral->paid = 'true';
                    $referral->save();
                }
            }
        }
    }
}