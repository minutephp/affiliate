<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Members\Affiliates {

    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class Register {

        public function index () {
            return (new View())->with(new Helper('AngularCountrySelect'));
        }
	}
}