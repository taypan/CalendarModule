<?php

namespace App\CalendarModule;

use Nette\Utils\Html;
use Nette\Templating\FileTemplate;


class Calendar
{


	public $month;
	public $year;

	private $html;
	private $template;
	private $rendered = FALSE;
	private $days;
	private $presenter;


	public function __construct($presenter, $month = NULL,$year = NULL,$templateFile = "/templates/calendar.latte") {
		if(!$month){
			$month = date("n");
		}

		if(!$year){
			$month = date("Y");
		}

		$this->presenter = $presenter;
		$this->setDate($month,$year);

		$this->template = new FileTemplate(__DIR__ . $templateFile);
		$this->template->registerHelperLoader('Nette\Templating\DefaultHelpers::loader');
		$this->template->registerFilter(new \Nette\Latte\Engine);
		//$this->template->__
		//$this->template->setCacheStorage(new \Nette\Caching\Storages\PhpFileStorage($this->params['rootDir'].'/temp'));

	}


	public function setDate($month,$year){
		$this->rendered = false;
		$this->month = $month;
		$this->year = $year;
	}



	public function getHtml(){
		if(!$this->rendered){
			$this->render();
		}
		return (string)$this->template;
	}

	public function getDay($day){
		if(!$this->rendered){
			$this->render();
		}
		return $this->days[$day];
	}

	private function render() {
		$this->rendered = true;

		$this->days = array(); //asociative array of elemnts of days
		$day = 1;
		$str =  $day ."-". $this->month ."-". $this->year. " 00:00:00";
		$now = strtotime($str);

		$this->html = Html::el('table',array("border" => 2));


		//day of week of firts day of month
		$begin = date("N",$now)-1;

		// number of weeks in month
		$weeks =  (int)(($begin + date("t",$now) -1)/ 7);


		for($i = 0;$i <= $weeks;$i++){
			$tr = $this->html->create('tr');
			for($j = 0;$j < 7;$j++){
				$tr->create('td');
			}
		}


		for($i = $begin,$j = 1; $i < date("t",$now) + $begin;$i++,$j++){
			$this->days[$j] = $this->html[(int)($i / 7)][$i % 7];
			$this->days[$j]->setText($j);

		}

		$this->template->month = date("F",$now);
		$this->template->year = date("Y",$now);
		$this->template->table = $this->html;

		
		$nextMonth = $this->month;
		$prevMonth = $this->month;
		
		$nextYear = $this->year;
		$prevYear = $this->year;
		
		$nextMonth++;
		if($nextMonth == 13){
			$nextMonth = 1;
			$nextYear++;
		}
		
		$prevMonth--;
		if($prevMonth == 0){
			$prevMonth = 12;
			$prevYear--;
		}
		
		$this->template->prev = $this->presenter->link(":Calendar:default:",array('month' => $prevMonth,'year' => $prevYear));
		$this->template->next = $this->presenter->link(":Calendar:default:",array('month' => $nextMonth,'year' => $nextYear));



	}

	public function __toString(){
		return (string)$this->getHtml();
	}

}

