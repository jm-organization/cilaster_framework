<?php
/**
 * @Created in JM Organization.
 * @Author: Magicmen
 * @Date: 16.08.2017
 * @Time: 18:23
 */

namespace Cilaster\Core;


use Cilaster\API\Http\Mvc;
use Cilaster\API\View;

class Cilaster {
    public static function run() {
		$uri_exist = Router::uri_exist();

		$mvc = new Mvc();
		$view = new View();

		if (Router::$route->action == 'rest') {
			header('Content-Type: application/json; charset=utf-8');

			$configs = new Config('application/database');
			(new \Cilaster\DB\Tools\EntityManager($configs->get()))->create()->getEntityManager();

			\Cilaster\Rest\Rest::start();
		} else {
			if (!IS_INSTALLED && Router::$route->action != 'install') {
				$mvc->redirect($mvc->url('/install.php', [
					'product' => 'cilaster',
					'step' => 1,
				]));
			}

			if (!$uri_exist) { $view->generateErrorPage(); }

			$view->generate();
		}
    }
}