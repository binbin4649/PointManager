<?php

class PmtotalFixture extends CakeTestFixture {
	
	public $import = array('model' => 'PointManager.Pmtotal');
	
	public function init(){
		$this->records = [
			[
				'id' => 1,
				'mypage_id' => 1,
				'pmpage_id' => 1,
				'yyyymm' => date('Y-m-d', strtotime('last day of previous month')),
				'total' => 1000,
				'status' => 'forward',
				'mail_submit' => '',
				'invoice_submit' => '',
				'payment_date' => null,
				'mf_billing_id' => '',
				'created' => '2018-07-30 14:06:01',
				'modified' => '2018-07-30 14:06:01'
			],
			[
				'id' => 2,
				'mypage_id' => 5,
				'pmpage_id' => 5,
				'yyyymm' => date('Y-m-t'),
				'total' => 6000,
				'status' => 'run',
				'mail_submit' => null,
				'invoice_submit' => null,
				'mf_billing_id' => null,
				'created' => '2018-07-30 14:06:01',
				'modified' => '2018-07-30 14:06:01'
			],
			[
				'id' => 3,
				'mypage_id' => 7,
				'pmpage_id' => 7,
				'yyyymm' => date('Y-m-t'),
				'total' => 4000,
				'status' => 'forward',
				'mail_submit' => null,
				'invoice_submit' => null,
				'created' => '2018-07-30 14:06:01',
				'modified' => '2018-07-30 14:06:01'
			],
		];
		parent::init();
	}
	

}