<?php
require_once dirname(__FILE__) . '/classes/sys/CBaseApplication.php';
class CApplication extends CBaseApplication {
	
	public function __construct() {
		$this->title("Базовое приложение", "Движок без названия");
		parent::__construct();
	}
	
	protected function _route($url) {
		$work_folder = WORK_FOLDER;
		switch ($url) {
			/*case $work_folder . '/cabinet':
				$this->layout = 'tpl/simple_page.master.tpl.php';
				$this->handler = $h = $this->_load('CabinetPageHandler');
				return;*/
			case $work_folder . '/podat_obyavlenie':
				$this->layout = 'tpl/simple_page.master.tpl.php';
				$this->handler = $h = $this->_load('NewAdvPageHandler');
				return;
			case $work_folder . '/testdbmapping':
				$this->layout = 'tpl/simple_page.master.tpl.php';
				$this->handler = $h = $this->_load('TestDbMappingHandler');
				return;
		}
		parent::_route($url);
		
		$this->layout = 'tpl/simple_page.master.tpl.php';
		$this->handler = $h = $this->_load('SimplePageHandler');
	}
	/**
	 * @desc Обработка возможных действий при регистрации и авторизации
	**/
	protected function _loginActions() {
		$this->handler = $h = $this->_load('SpecialLoginHandler');
	}
}
