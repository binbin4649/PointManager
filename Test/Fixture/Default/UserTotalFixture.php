<?php

class UserTotalFixture extends CakeTestFixture {
	
	public $import = array('model' => 'PointManager.UserTotal');
	
	public function init(){
		$this->records = [
			[
				'id' => 1,
				'pmpage_id' => 1,
				'yyyymm' => date('Y-m-t'),
				'quantity' => 2,
				'unit_price' => 100,
				'total' => 200,
				'name' => 'テストテスト',
				'status' => 'before'
			],
			[
				'id' => 2,
				'pmpage_id' => 1,
				'yyyymm' => date('Y-m-t'),
				'quantity' => 4,
				'unit_price' => 100,
				'total' => 400,
				'name' => 'テスト',
				'status' => 'before'
			],
		];
		parent::init();
	}

}