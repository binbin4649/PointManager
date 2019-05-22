<?php

class PointBookFixture extends CakeTestFixture {
	
	public $import = array('model' => 'Point.PointBook');
	
	public function init(){
		$this->records = [
			[
				'id' => 1,
				'mypage_id' => '1',
				'point_user_id' => '1',
				'point' => '-100',
				'credit' => 0,
				'point_balance' => '-100',
				'credit_balance' => 0,
				'reason' => 'run',
				'reason_id' => '1',
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			],
			[
				'id' => 2,
				'mypage_id' => '1',
				'point_user_id' => '1',
				'point' => '-50',
				'credit' => 0,
				'point_balance' => '-150',
				'credit_balance' => 0,
				'reason' => 'run',
				'reason_id' => '2',
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			],
			[
				'id' => 3,
				'mypage_id' => '1',
				'point_user_id' => '1',
				'point' => '-20',
				'credit' => 0,
				'point_balance' => '-170',
				'credit_balance' => 0,
				'reason' => 'receive',
				'reason_id' => '3',
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			],
		];
		parent::init();
	}
	
	
}