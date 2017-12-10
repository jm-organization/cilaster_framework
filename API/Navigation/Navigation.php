<?php
/**
 * Created in JM Organization.
 *
 * @e-mail: admin@jm-org.net
 * @Author: Magicmen
 *
 * @Date: 10.12.2017
 * @Time: 21:04
 *
 * @Documentation:
 */

namespace Cilaster\API\Navigation;


use Cilaster\Core\Config;
use Cilaster\Core\Router;
use Cilaster\API\Request\GetRequest;

class Navigation {
	public $router;
	public $title;
	public $short_title;
	public $navigator;
	public $route;

	public $site_title;

	public function setTitle($title) {
		$this->title = $title;
	}

	public function __construct($navigator = 'default', Router $router) {
		$this->router = $router::$route;
		$this->navigator = (new Config('application/config'))->get("navigation/$navigator");

		foreach ($this->navigator as $route) {
			if ($route['action'] == $this->router->action) { $this->route = $route; }
		}

		$this->site_title = trim((new Config('application'))->get("about/title"));
	}

	public function getShortTitle() {
		$short_title = ($this->site_title != '')?$this->site_title:'Cilaster CMS';

		return $short_title;
	}

	public function getTitle() {
		$config_product = (new GetRequest())->content()->get('product');
		$product = ($config_product == 'cilaster')?'Cilaster Framework':(ucfirst($config_product));
		$page_title = str_replace([ ':product:' ], [ $product ], $this->route['label']);

		$this->title = (($page_title)?$page_title.' | ':'').$this->getShortTitle();

		return $this->title;
	}

	public function getLink() {
		return $this->route;
	}
}