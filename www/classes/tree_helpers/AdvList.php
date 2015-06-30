<?php
require_once APP_ROOT . '/classes/sys/CAbstractDbTree.php';

class AdvList extends CAbstractDbTree{
	public function __construct($app) {
		$this->table('prodhash');
		//устанавливаю "неожиданные" ассоциации полей запроса и полей таблицы БД
		//ключ значения массива - имя поля в таблице,  значение - ключ в request
		$this->assoc(
			array(
				'category' => 'advcat',
				'image' => 'ipath'
			)
		);
		//устанавливаю имена полей таблицы БД которые надо вставить
		//db fields
		$this->insert(
			array('region', 'city', 'price', 'title', 'image', 'addtext', 'uid', 'created', 'category')
		);
		//устанавливаю имена полей таблицы БД которые надо обновить
		//db fields
		$this->update(
			array('region', 'city', 'price', 'title', 'image', 'addtext', 'category')
		);
		//устанавливаю имена полей в которые надо записать текущее время
		$this->timestamps(
			array('created')
		);
		//Устанавливаю необходимые для заполнения поля
		$this->required('title', $app->lang['Error_title_required']);
		$this->required('addtext', $app->lang['Error_body_required']);
		$this->required('name', $app->lang['Error_name_required']);
		$this->required('advcat', $app->lang['Error_category_required']);
		$this->required('region', $app->lang['Error_region_required']);
		//$this->required('email', $app->lang['email_required']);
		
		//Проверяю, владелиц ли пользователь редактируемого комментария
		$auth_user_uid = sess('uid');
		$field_owner_id = 'uid';
		$this->setUpdateOwnerCondition($auth_user_uid, $field_owner_id);
		$this->is_deleted_table_alias = 'prodhash';
		parent::__construct($app);
	}
	
	protected function validate($use_json = true) {
		$lang = utils_getCurrentLang();
		$errors_child = array();
		$enter = req('cp');
		if ($enter != sess('capcode')) {
			if ($use_json) {
				json_error('msg', $lang['code_is_not_valid']);
			} else {
				return array($lang['code_is_not_valid']);
			}
		}
		$errors = parent::validate($use_json);
		$errors = array_merge($errors_child, $errors);
		return $errors;
	}
	
	protected function req($name) {
		if ($name == 'is_accepted') {
			return '0';
		}
		if ($name == 'advcat') {
			return ireq($name);
		}
		$v = parent::req($name);
		/*if ($name == 'skey') {
			if (!$v) {
				json_error('msg', $this->_app->lang['default_error']);
			}
			$v = 'quick_start/' . $v;
		}*/
		return $v;
	}
	/**
	 * @desc Получить поля для апдейта
	 * @param  $id Идентификатор записи
	 * @param  string $additional_fields перечисление сеоез запятую дополнительных плоей
	 * @return $row | false row Содержит выборку полей заданных для update и поле на которое назначен первичный ключ
	**/
	public function getRecord($id, $additional_fields = false) {
		$row = parent::getRecord($id, $additional_fields);
		$row['body'] = str_replace('<pre>', "[code]\n", $row['body']);
		$row['body'] = str_replace('</pre>', '[/code]', $row['body']);
		return $row;
	}
}
