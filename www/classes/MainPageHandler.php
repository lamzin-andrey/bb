<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';
class MainPageHandler extends CBaseHandler{
	public function __construct() {
		$this->css[] = 'promo';
		parent::__construct();
	}
}
