<?php

class PmpageFixture extends CakeTestFixture {
	
	public $import = array('model' => 'PointManager.Pmpage');
	
	public $records = array(
		array(
			'id' => 1,
			'mypage_id' => 1,
			'company_name' => 'テスト会社',
			'prefecture' => '東京',
			'department_name' => '営業部',
			'position_name' => '部長',
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
	);

}