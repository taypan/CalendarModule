<?php


namespace App\CalendarModule;

use \Venne\Developer\Module\Service\IRouteService;

/**
 * @author Jiří Müller
 */
class Module extends \Venne\Developer\Module\AutoModule {


	public function getName()
	{
		return "calendar";
	}


	public function getDescription()
	{
		return "calendar description";
	}


	public function getVersion()
	{
		return "0.1";
	}


	public function setRoutes(\Nette\Application\Routers\RouteList $router, $prefix = "")
	{
		$router[] = new \Nette\Application\Routers\Route($prefix . '<month>/<year>', array(
					'module' => 'Calendar',
					'presenter' => 'Default',
					'action' => 'default',
					'month' => date("m"),
					'year' => date("Y")
								)
		);
	}


}
