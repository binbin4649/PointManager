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
        $this->Pmpage = ClassRegistry::init('PointManager.Pmpage');
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
    
/*
    public function testSignUp(){
	    $data = [
		    'Mypage' => [
			    'name' => 'testさん',
			    'email' => 'test1@test.com',
			    'password' => '111222',
			    'tel' => '03-1111-1111',
			    'zip' => '001-0003',
			    'address_1' => '札幌市時計台1−1−1',
			    'address_2' => '',
		    ],
		    'Pmpage' => [
			    'company_name' => '株式会社テスト',
			    'prefecture' => '北海道',
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
			    'other_payoff_total2' => '',
		    ]
	    ];
	    $r = $this->Pmpage->signUp($data);
	    //var_dump($this->Pmpage->validationErrors);
	    var_dump($r);
	    die;
    }
*/
    
    

}