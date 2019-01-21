<?php

class UserTotalFixture extends CakeTestFixture {
	
	public $import = array('model' => 'PointManager.UserTotal');
	
	public function init(){
		$this->records = [
			[
				'id' => 1,
				'pmpage_id' => 1,
				'yyyymm' => date('Y-m-t'),
				'total' => 200,
				'name' => 'テスト'
			],
			[
				'id' => 2,
				'pmpage_id' => 1,
				'yyyymm' => date('Y-m-t'),
				'total' => 400,
				'name' => 'テスト'
			],
		];
		parent::init();
	}

}