<?php

/** @var Binding $binding */
use Minute\Affiliate\AffiliateInfo;
use Minute\Affiliate\AffiliatePayouts;
use Minute\Affiliate\AffiliateSignup;
use Minute\Coupon\AffiliateCoupons;
use Minute\Event\AdminEvent;
use Minute\Event\AffiliateEvent;
use Minute\Event\Binding;
use Minute\Event\MemberEvent;
use Minute\Event\ResponseEvent;
use Minute\Event\RouterEvent;
use Minute\Event\TodoEvent;
use Minute\Event\UserSignupEvent;
use Minute\Event\WalletPurchaseEvent;
use Minute\Menu\AffiliateMenu;
use Minute\Router\AffiliateRouter;
use Minute\Todo\AffiliateTodo;
use Minute\Tracker\AffiliateTracker;

$binding->addMultiple([
    //admin
    ['event' => AdminEvent::IMPORT_ADMIN_MENU_LINKS, 'handler' => [AffiliateMenu::class, 'adminLinks']],

    //members
    ['event' => MemberEvent::IMPORT_MEMBERS_SIDEBAR_LINKS, 'handler' => [AffiliateMenu::class, 'memberLinks']],

    //other
    ['event' => AffiliateEvent::IMPORT_AFFILIATE_DATA, 'handler' => [AffiliateInfo::class, 'printAffiliateData']],

    //signup and redirection
    ['event' => UserSignupEvent::USER_SIGNUP_COMPLETE, 'handler' => [AffiliateSignup::class, 'setReferrer']],
    ['event' => RouterEvent::ROUTER_GET_FALLBACK_RESOURCE, 'handler' => [AffiliateRouter::class, 'handle'], 'priority' => -100],

    //mark referral as paid
    ['event' => WalletPurchaseEvent::USER_WALLET_PURCHASE_PASS, 'handler' => [AffiliateSignup::class, 'markAsPaid']],

    //calculate pending affiliate commissions
    ['event' => AffiliateEvent::IMPORT_AFFILIATE_PAYOUTS, 'handler' => [AffiliatePayouts::class, 'calculate']],

    //tracking
    ['event' => ResponseEvent::RESPONSE_RENDER, 'handler' => [AffiliateTracker::class, 'insertTracker'], 'priority' => 1],

    //voucher
    ['event' => "voucher.verify", 'handler' => [AffiliateCoupons::class, 'applyCoupon']],

    //tasks
    ['event' => TodoEvent::IMPORT_TODO_ADMIN, 'handler' => [AffiliateTodo::class, 'getTodoList']],
]);