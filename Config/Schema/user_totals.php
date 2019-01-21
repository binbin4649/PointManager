<?php 
class UserTotalsSchema extends CakeSchema {

	public $file = 'user_totals.php';

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $user_totals = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false, 'key' => 'primary'),
		'pm_user_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'unsigned' => false),
		'pmpage_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'unsigned' => false),
		'mypage_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'yyyymm' => array('type' => 'date', 'null' => false, 'default' => null),
		'total' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

}
