<?php
App::uses('Pmpage', 'PointManager.Model');


class PmpageTest extends BaserTestCase {
/*
    public $fixtures = array(
        'plugin.point_manager.Default/Mypage',
        'plugin.point_manager.Default/Mylog',
        'plugin.point_manager.Default/PointUser',
        'plugin.point_manager.Default/Pmpage',
        'plugin.point_manager.Default/PmUser',
        'plugin.point_manager.Default/Pmtotal',
    );
*/
    
    public $fixtures;
    
    public function __construct(){
	    $fixtures = array(
	        'plugin.point_manager.Default/Mypage',
	        'plugin.point_manager.Default/Mylog',
	        'plugin.point_manager.Default/PointUser',
	        'plugin.point_manager.Default/PointBook',
	        'plugin.point_manager.Default/Pmpage',
	        'plugin.point_manager.Default/PmUser',
	        'plugin.point_manager.Default/Pmtotal',
	        'plugin.point_manager.Default/Pmconfig',
	    );
	    $Plugin = ClassRegistry::init('Plugin');
	    $lists = $Plugin->find('list');
	    foreach($lists as $list){
		    if($list == 'Nos') $fixtures[] = 'plugin.point_manager.Default/NosUser';
	    }
	    $this->fixtures = $fixtures;
    }

    public function setUp() {
	    Configure::write('MccPlugin.TEST_MODE', true);
        $this->Pmpage = ClassRegistry::init('PointManager.Pmpage');
        $this->PointUser = ClassRegistry::init('Point.PointUser');
        parent::setUp();
    }
    
    public function tearDown(){
	    unset($this->Pmpage);
	    parent::tearDown();
    }

    public function testValidateFalse(){
	    $this->Pmpage->create([
		    'Pmpage' => [
			    'company_name' => '',
			    'prefecture' => ''
		    ]
	    ]);
	    $this->assertFalse($this->Pmpage->validates());
	    $this->assertArrayHasKey('company_name', $this->Pmpage->validationErrors);
	    $this->assertEquals('会社名を入力して下さい。', current($this->Pmpage->validationErrors['company_name']));
	    $this->assertArrayHasKey('prefecture', $this->Pmpage->validationErrors);
	    $this->assertEquals('都道府県を選択してください。', current($this->Pmpage->validationErrors['prefecture']));
    }
    
    public function testValidateTrue(){
	    $this->Pmpage->create([
		    'Pmpage' => [
			    'company_name' => 'テスト社',
			    'prefecture' => '東京'
		    ]
	    ]);
	    $this->assertTrue($this->Pmpage->validates());
    }
    
    public function testToAss(){
	    $data['Mypage']['id'] = 6;
	    $data['Mypage']['zip'] = '100-0001';
	    $data['Mypage']['address_1'] = '札幌市時計台残念';
	    $data['Mypage']['address_2'] = '1-1-1';
	    $data['Mypage']['tel'] = '0312345678';
	    $data['Pmpage'] = [
		    'prefecture' => '北海道',
		    'company_name' => 'テスト会社6',
		    'department_name' => '',
		    'position_name' => '',
		    'invoice_company_name' => '',
		    'invoice_department_name' => '',
		    'invoice_position_name' => '',
		    'invoice_name' => '',
		    'invoice_tel' => '',
		    'invoice_zip' => '',
		    'invoice_prefecture' => '',
			'invoice_address_1' => '',
			'invoice_address_2' => '',
			'invoice_email' => '',
			'memo' => '',
			'other_payoff_name1' => '',
			'other_payoff_total1' => '',
			'other_payoff_name2' => '',
			'other_payoff_total2' => ''
	    ];
	    $r = $this->Pmpage->toAss($data);
	    if($r){
		    $PointUser = $this->PointUser->findById(6);
	    }
	    $this->assertEquals('pay_off', $PointUser['PointUser']['pay_plan']);
    }
    
    

}