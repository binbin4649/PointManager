<?php

class NosUserFixture extends CakeTestFixture {
	
	public $import = array('model' => 'Nos.NosUser');
	
	public $records = array(
		array(
			'id' => 1,
			'mypage_id' => '6',
			'isadmin' => 'admin',
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
	);

}