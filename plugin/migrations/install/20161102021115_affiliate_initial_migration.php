<?php
use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class AffiliateInitialMigration extends AbstractMigration
{
    public function change()
    {
        // Automatically created phinx migration commands for tables from database minute

        // Migration for table m_affiliate_info
        $table = $this->table('m_affiliate_info', array('id' => 'affiliate_info_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('username', 'string', array('limit' => 255))
            ->addColumn('paypal_email', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('country', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('phone', 'float', array('null' => true))
            ->addColumn('phone_verified', 'enum', array('null' => true, 'default' => 'false', 'values' => array('false','true')))
            ->addIndex(array('user_id'), array('unique' => true))
            ->addIndex(array('username'), array('unique' => true))
            ->create();


        // Migration for table m_affiliate_payouts
        $table = $this->table('m_affiliate_payouts', array('id' => 'affiliate_payout_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('txn_id', 'string', array('null' => true, 'limit' => 255))
            ->addColumn('amount', 'float', array())
            ->addIndex(array('txn_id'), array('unique' => true))
            ->addIndex(array('user_id'), array())
            ->create();


        // Migration for table m_affiliate_referrals
        $table = $this->table('m_affiliate_referrals', array('id' => 'affiliate_referral_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('created_at', 'datetime', array())
            ->addColumn('signup_user_id', 'integer', array('limit' => 11))
            ->addColumn('paid', 'enum', array('null' => true, 'values' => array('false','true')))
            ->addIndex(array('user_id', 'signup_user_id'), array('unique' => true))
            ->create();


        // Migration for table m_affiliate_resources
        $table = $this->table('m_affiliate_resources', array('id' => 'affiliate_resource_id'));
        $table
            ->addColumn('updated_at', 'datetime', array())
            ->addColumn('type', 'string', array('null' => true, 'limit' => 55))
            ->addColumn('group', 'string', array('limit' => 55))
            ->addColumn('priority', 'integer', array('null' => true, 'default' => '0', 'limit' => 11))
            ->addColumn('title', 'string', array('limit' => 255))
            ->addColumn('value_type', 'enum', array('default' => 'text', 'values' => array('text','banner','code')))
            ->addColumn('value', 'text', array())
            ->addColumn('enabled', 'enum', array('null' => true, 'default' => 'true', 'values' => array('true','false')))
            ->addIndex(array('type'), array())
            ->create();


        // Migration for table m_affiliate_trackers
        $table = $this->table('m_affiliate_trackers', array('id' => 'affiliate_tracker_id'));
        $table
            ->addColumn('user_id', 'integer', array('limit' => 11))
            ->addColumn('tracker_type', 'enum', array('values' => array('google','facebook','statcounter')))
            ->addColumn('tracker_code', 'string', array('limit' => 255))
            ->addColumn('enabled', 'enum', array('default' => 'true', 'values' => array('false','true')))
            ->addIndex(array('user_id', 'tracker_type'), array('unique' => true))
            ->create();


    }
}