<?php

class PointUserFixture extends CakeTestFixture {
	
	public $import = array('model' => 'Point.PointUser');
	
	public $records = array(
		array(
			'id' => 1,
			'mypage_id' => 2,
			'point' => '-100',
			'credit' => 0,
			'available_point' => 0,
			'pay_plan' => 'pay_off',
			'created' => '2018-07-30 16:26:01',
			'modified' => '2018-07-30 16:26:01',
		),
		array(
			'id' => 2,
			'mypage_id' => 3,
			'point' => '-200',
			'credit' => 0,
			'available_point' => 0,
			'pay_plan' => 'pay_off',
			'created' => '2018-07-30 16:26:01',
			'modified' => '2018-07-30 16:26:01',
		),
		array(
			'id' => 3,
			'mypage_id' => 1,
			'point' => '-2000',
			'credit' => 0,
			'available_point' => 0,
			'pay_plan' => 'pay_off',
			'created' => '2018-07-30 16:26:01',
			'modified' => '2018-07-30 16:26:01',
		),
	);

}