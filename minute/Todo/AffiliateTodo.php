<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/5/2016
 * Time: 11:04 AM
 */
namespace Minute\Todo {

    use App\Model\MAffiliateResource;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;

    class AffiliateTodo {
        /**
         * @var TodoMaker
         */
        private $todoMaker;
        /**
         * @var Config
         */
        private $config;

        /**
         * MailerTodo constructor.
         *
         * @param TodoMaker $todoMaker - This class is only called by TodoEvent (so we assume TodoMaker is be available)
         * @param Config $config
         */
        public function __construct(TodoMaker $todoMaker, Config $config) {
            $this->todoMaker = $todoMaker;
            $this->config    = $config;
        }

        public function getTodoList(ImportEvent $event) {
            $todos[] = $this->todoMaker->createManualItem("check-affiliate-settings", "Check affiliate settings", 'Setup commission percent, URL, etc', '/admin/affiliate/settings');
            $todos[] = ['name' => 'Create promotional resources for affiliates', 'status' => MAffiliateResource::where('enabled', '=', 'true')->count() > 0 ? 'complete' : 'incomplete',
                        'link' => '/admin/affiliate/resources'];
            $todos[] = $this->todoMaker->createManualItem("pay-pending-commissions", "Pay pending commissions", 'Clear all pending affiliate commissions', '/admin/affiliate/payouts');
            $todos[] = $this->todoMaker->createManualItem("check-affiliate-signups", "Check if affiliate signups are working properly", 'Signup with an affiliate link and check stats');
            $todos[] = $this->todoMaker->createManualItem("check-affiliate-commissions", "Check affiliate commission with a paid signup", 'Paid signup with an affiliate link and check payouts');

            $event->addContent(['Affiliate' => $todos]);
        }
    }
}