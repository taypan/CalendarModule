<?php

namespace App\CalendarModule;

use Nette\Environment;
use Venne\Application\UI;
use Nette\Utils\Html;
/**
 * @resource CalendarModule
 */
class DefaultPresenter extends \Venne\Developer\Presenter\FrontPresenter {



	/**
	 * @privilege read
	 */


	public function renderDefault($month,$year){


		$calendar = new Calendar($this,$month,$year);
		$this->template->calendar = (string) $calendar;



	}






}