<?php

/** @var Router $router */
use Illuminate\Database\Eloquent\Builder;
use Minute\Model\Permission;
use Minute\Routing\Router;

$router->get('/admin/affiliate/settings', null, 'admin', 'm_configs[type] as configs', 'm_products[99] as products')
       ->setReadPermission('configs', 'admin')->setDefault('type', 'affiliate')
       ->setReadPermission('products', 'admin')->setDefault('products', '*');
$router->post('/admin/affiliate/settings', null, 'admin', 'm_configs as configs')
       ->setAllPermissions('configs', 'admin');

$router->get('/admin/affiliate/resources/{type}', null, 'admin', 'm_affiliate_resources[type][7] as resources ORDER by priority')
       ->setReadPermission('resources', 'admin')->setDefault('resources', '*')->setDefault('type', 'faq');
$router->post('/admin/affiliate/resources/{type}', null, 'admin', 'm_affiliate_resources as resources')
       ->setAllPermissions('resources', 'admin')->setDefault('type', 'faq');

$router->get('/admin/affiliate/resource/edit/{affiliate_resource_id}', null, 'admin', 'm_affiliate_resources[affiliate_resource_id] as resources')//conflicts /admin/affiliate/resources/edit with above
       ->setReadPermission('resources', 'admin')->setDefault('affiliate_resource_id', '0');
$router->post('/admin/affiliate/resource/edit/{affiliate_resource_id}', null, 'admin', 'm_affiliate_resources as resources')
       ->setAllPermissions('resources', 'admin')->setDefault('affiliate_resource_id', '0');

$router->get('/admin/affiliate/payouts', null, 'admin', 'm_affiliate_payouts[1] as payouts')
       ->setReadPermission('payouts', 'admin');
$router->post('/admin/affiliate/payouts', null, 'admin', 'm_affiliate_payouts as payouts')
       ->setAllPermissions('payouts', 'admin');

$router->get('/members/affiliates/register', 'Members/Affiliates/Register', true, 'm_affiliate_info[1] as affiliates', 'm_configs[type] as configs')
       ->setReadPermission('affiliates', Permission::SAME_USER)->setReadPermission('configs', Permission::EVERYONE)
       ->setDefault('affiliates', '*')->setDefault('type', 'affiliate');
$router->post('/members/affiliates/register', null, true, 'm_affiliate_info as affiliates')
       ->setCreatePermission('affiliates', Permission::SAME_USER)->setUpdatePermission('affiliates', Permission::NOBODY);

$router->get('/members/affiliates/resources', 'Members/Affiliates/Resources', true, 'm_affiliate_resources[999] as resources')
       ->setReadPermission('resources', Permission::EVERYONE)->setDefault('resources', '*');

$router->get('/members/affiliates/referrals/{paid}', null, true, 'm_affiliate_referrals[paid][5] as referrals', 'users[user_id=referrals.signup_user_id] as user',
    'm_wallets[user_id=referrals.signup_user_id][5] as purchases ORDER by created_at DESC', 'm_wallet_logs[purchases.wallet_log_id] as log')
       ->setDefault('paid', null)->addConstraint('purchases', function (Builder $builder) { $builder->where('payment_type', '=', 'purchase')->orWhere('payment_type', '=', 'purchase_cancel'); });

$router->get('/members/affiliates/commissions', null, true, 'm_affiliate_payouts[5] as payouts ORDER BY created_at DESC')
       ->setDefault('payouts', '*');

$router->get('/members/affiliates/trackers', null, true, 'm_affiliate_trackers[5] as trackers')
       ->setReadPermission('trackers', Permission::SAME_USER)->setDefault('trackers', '*');
$router->post('/members/affiliates/trackers', null, true, 'm_affiliate_trackers as trackers')
       ->setAllPermissions('trackers', Permission::SAME_USER);

$router->get('/members/affiliates/trackers/edit/{affiliate_tracker_id}', null, true, 'm_affiliate_trackers[affiliate_tracker_id] as trackers')
       ->setReadPermission('trackers', Permission::SAME_USER)->setDefault('affiliate_tracker_id', '0');
$router->post('/members/affiliates/trackers/edit/{affiliate_tracker_id}', null, true, 'm_affiliate_trackers as trackers')
       ->setAllPermissions('trackers', Permission::SAME_USER)->setDefault('affiliate_tracker_id', '0');

$router->get('/members/affiliates/download/referrals', 'Members/Affiliates/Download@referrals', true)->setDefault('_noView', true);
$router->get('/members/affiliates/download/payouts', 'Members/Affiliates/Download@payouts', true)->setDefault('_noView', true);
