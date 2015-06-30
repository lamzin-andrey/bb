<?php
require_once APP_ROOT . '/classes/sys/CBaseHandler.php';

require_once APP_ROOT . '/units/select_tree/php/SelectTree.php';
require_once APP_ROOT . '/units/location_select/php/LocationSelect.php';
require_once APP_ROOT . '/classes/tree_helpers/AdvList.php';
require_once APP_ROOT . '/classes/SpecialLoginHandler.php';

class NewAdvPageHandler extends CBaseHandler{
	//components
	/** @var SelectTree $category_select*/
	public $category_select;
	/** @var Location inputs*/
	public $location_inputs;
	
	//other
	/** @var AdvList*/
	private $_adv_list;
	
	//fields
	/** @var product image web path*/
	public $image = '';
	/** @var is_auth*/
	public $authorized = false;
	/** @var Publisher name*/
	public $name = '';
	/** @var Publisher phone*/
	public $phone = '';
	/** @var Publisher phone*/
	public $addtext = '';
	/** @var Advr title*/
	public $title = '';
	/** @var Advr title*/
	public $price = '';
	/** @var Advr title*/
	public $email = '';
	
	
	public function __construct($app) {
		$this->authorized = CApplication::userIsAuth();
		$this->css[] = 'simple';
		$this->css[] = 'advform';
		$this->js[] = 'simple';
		$this->right_inner = 'cabinet/start.tpl.php';
		parent::__construct($app);
		$this->category_select = new SelectTree($this, 'product_categories', 'get_advcat');
		$this->location_inputs = new LocationSelect($this);
		$this->_adv_list = new AdvList($app);
		$this->_listenPost();
	}
	
	private function _listenPost() {
		if (count($_POST)) {
			$data = array('uid' => 0);
			if ($this->authorized) {
				$data['uid'] = CApplication::getUid();
				//TODO email and name phone from profile, and disable inputs on page
			} elseif($this->_checkCode()) {
				$data['uid'] = $this->_registerGuest();
			} else {
				$this->errors[] = $this->_app->lang['code_is_not_valid'];
			}
			if ($data['uid']) {
				$n = dbvalue("SELECT count(id) AS cc FROM prodhash WHERE uid = '{$data['uid']}' AND is_deleted = 0");
				if ($n > 2) {
					$this->errors = array_merge($this->errors, array($this->_app->lang['advert_limit_expired']));
				} else {
					$r = $this->_adv_list->writeData($data, false, $errors);
					if ($r < 0) {
						$this->errors = array_merge($this->errors, $errors);
					}
				}
			} else {
				//$this->errors[] = 'Bad UID!';
			}
			if (count($this->errors) == 0) {
				$this->messages = array($this->_app->lang['Success_add_adv']);
			}
		}
	}
	private function _checkCode(){
		return (sess('capcode') == req('cp'));
	}
	private function _registerGuest(){
		$lang = $this->_app->lang;
		$_REQUEST['password'] = $_REQUEST['pc'] = req('pwd');
		$login = new SpecialLoginHandler($this->_app);
		
		$msg = $login->signup(false);
		if ($msg != $lang['phone_already_exists'] && $msg != $lang['email_already_exists'] && $msg != $lang['reg_complete'] ) {
			$this->errors[] = $msg;
			return 0;
		}
		$alien_email = ($lang['email_already_exists'] == $msg);
		$phone = AdvLib::preparePhone(req('phone'));
		$uid = dbvalue("SELECT id FROM users WHERE phone = '{$phone}'");
		if (!$uid && $alien_email) {
			$this->errors[] = $lang['Entered_email_use_with_other_phone'];
		}
		return $uid;
	}
}
