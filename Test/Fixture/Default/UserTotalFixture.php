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
				'status' => 'before',
				'created' => '2018-07-30 14:06:01',
				'modified' => '2018-07-30 14:06:01'
			],
			[
				'id' => 2,
				'pmpage_id' => 1,
				'yyyymm' => date('Y-m-t'),
				'quantity' => 4,
				'unit_price' => 100,
				'total' => 400,
				'name' => 'テスト',
				'status' => 'before',
				'created' => '2018-07-30 14:06:01',
				'modified' => '2018-07-30 14:06:01'
			],
			[
				'id' => 3,
				'pmpage_id' => 5,
				'yyyymm' => date('Y-m-t'),
				'quantity' => 10,
				'unit_price' => 100,
				'total' => 1000,
				'name' => 'テスト1',
				'status' => 'before',
				'created' => '2018-07-30 14:06:01',
				'modified' => '2018-07-30 14:06:01'
			],
			[
				'id' => 4,
				'pmpage_id' => 5,
				'yyyymm' => date('Y-m-t'),
				'quantity' => 50,
				'unit_price' => 100,
				'total' => 5000,
				'name' => 'テスト2',
				'status' => 'before',
				'created' => '2018-07-30 14:06:01',
				'modified' => '2018-07-30 14:06:01'
			],
		];
		parent::init();
	}

}