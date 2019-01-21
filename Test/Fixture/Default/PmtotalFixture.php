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
				'payment_date' => '',
				'mf_billing_id' => '',
			],
		];
		parent::init();
	}
	

}