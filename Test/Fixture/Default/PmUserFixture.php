<?php

class PmUserFixture extends CakeTestFixture {
	
	public $import = array('model' => 'PointManager.PmUser');
	
	public $records = array(
		array(
			'id' => 1,
			'pmpage_id' => 1,
			'mypage_id' => 2,
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
		array(
			'id' => 2,
			'pmpage_id' => 1,
			'mypage_id' => 3,
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
		array(
			'id' => 3,
			'pmpage_id' => 1,
			'mypage_id' => 1,
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
	);

}