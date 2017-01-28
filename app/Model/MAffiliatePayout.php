<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MAffiliatePayout extends ModelEx {
        protected $table      = 'm_affiliate_payouts';
        protected $primaryKey = 'affiliate_payout_id';
    }
}