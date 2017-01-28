<?php
/**
 * Created by: MinutePHP Framework
 */
namespace App\Model {

    use Minute\Model\ModelEx;

    class MAffiliateTracker extends ModelEx {
        protected $table      = 'm_affiliate_trackers';
        protected $primaryKey = 'affiliate_tracker_id';
    }
}