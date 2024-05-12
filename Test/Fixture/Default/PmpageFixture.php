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
			'other_payoff_name1' => '月額保守費',
			'other_payoff_total1' => 20000,
			'other_payoff_name2' => '',
			'other_payoff_total2' => '0',
			'invoice_email' => '',
			'invoice_name' => 'テスト2',
			'invoice_name2' => 'テスト3',
			'invoice_mail_notice' => 'yes',
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
		array(
			'id' => 2,
			'mypage_id' => 4,
			'company_name' => 'テスト会社2',
			'prefecture' => '東京',
			'department_name' => '営業部',
			'position_name' => '部長',
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
		array(
			'id' => 5,
			'mypage_id' => 5,
			'company_name' => 'テスト会社5',
			'prefecture' => '東京',
			'department_name' => '営業部',
			'position_name' => '部長',
			//'invoice_email' => 'binbin4649@gmail.com',
			'invoice_mail_notice' => 'yes',
			'mf_department_id' => 'rxTbVvBFaAnjqwri4o7jjg',
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
		array(
			'id' => 7,
			'mypage_id' => 7,
			'company_name' => 'テスト会社7',
			'prefecture' => '東京',
			'department_name' => '営業部',
			'position_name' => '部長',
			'invoice_mail_notice' => 'yes',
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
		array(
			'id' => 8,
			'mypage_id' => 8,
			'company_name' => 'テスト会社8',
			'prefecture' => '東京',
			'department_name' => '営業部',
			'position_name' => '部長',
			'invoice_mail_notice' => 'yes',
			'created' => '2018-07-30 14:06:01',
			'modified' => '2018-07-30 14:06:01'
		),
	);

}