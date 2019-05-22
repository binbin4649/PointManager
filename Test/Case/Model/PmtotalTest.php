<?php
App::uses('Pmtotal', 'PointManager.Model');

class PmtotalTest extends BaserTestCase {
    public $fixtures = array(
        'plugin.point_manager.Default/Mypage',
        'plugin.point_manager.Default/Pmpage',
        'plugin.point_manager.Default/PmUser',
        'plugin.point_manager.Default/Pmtotal',
        'plugin.point_manager.Default/PointUser',
        'plugin.point_manager.Default/UserTotal',
        'plugin.point_manager.Default/PointBook',
        'plugin.point_manager.Default/Pmconfig',
    );

    public function setUp() {
	    Configure::write('MccPlugin.TEST_MODE', true);
        $this->Pmtotal = ClassRegistry::init('PointManager.Pmtotal');
        parent::setUp();
    }
    
    public function tearDown(){
	    unset($this->Pmtotal);
	    parent::tearDown();
    }
    
    
    public function testPmPayOff(){
	    Configure::write('pointManagerPlugin.forwardPoint', 100);
	    $result = $this->Pmtotal->PmPayOff();
	    $this->assertEquals(600, $result[0]['Pmtotal']['total']);
	    $this->assertEquals('run', $result[0]['Pmtotal']['status']);
    }
    
    public function testPayOffMail(){
	    $r = $this->Pmtotal->payOffMail();
	    $this->assertEquals('submit', $r[0]['Pmtotal']['mail_submit']);
	    $this->assertEquals('submit', $r[1]['Pmtotal']['mail_submit']);
    }
    
    public function testPmPayOffForward(){
	    Configure::write('pointManagerPlugin.forwardPoint', 10000);
	    $result = $this->Pmtotal->PmPayOff();
	    $this->assertEquals(600, $result[0]['Pmtotal']['total']);
	    $this->assertEquals('forward', $result[0]['Pmtotal']['status']);
    }
    
    public function testCreateInvoice(){
	    $result = $this->Pmtotal->createInvoice();
	    $this->assertEquals(20770, $result[0]['Pmtotal']['total']);
    }
    
    public function testMfBillingsCreate(){
	    $r = $this->Pmtotal->mfBillingsCreate();
	    $this->assertEquals('test_id', $r[0]['data']['id']);
	    $this->assertEquals('forward', $r[1]['data']['id']);
    }
    
    public function testUserTotalTotal(){
	    $pmpage_id = 1;
	    $result = $this->Pmtotal->userTotalTotal($pmpage_id);
	    $this->assertEquals(600, $result);
    }
    
    public function testUserTotalRun(){
	    $pmpage_id = 1;
	    $result = $this->Pmtotal->userTotalRun($pmpage_id);
	    $this->assertEquals(2, $result[0]['UserTotal']['quantity']);
    }
    
/*
    public function testGetMfAccessToken(){
	    $data['Pmpage'] = [
		    'id' => '1',
		    'invoice_company_name' => 'テストさん',
		    'invoice_zip' => '111-1111',
		    'invoice_tel' => '0312345678',
		    'invoice_prefecture' => '新潟県',
		    'invoice_address_1' => '新発田市',
		    'invoice_address_2' => 'わー',
		    'invoice_name' => '俺',
		    'invoice_position_name' => '代理補佐',
		    'invoice_department_name' => '桃組',
		    'invoice_email' => 'test@test.com',
		    'mf_department_id' => 'asdfghjkl',
	    ];
	    $data['Mypage'] = [
		    'name' => 'おれおれ',
		    'email' => 'test@test.com'
	    ];
	    $result = $this->Pmtotal->updatePartner($data);
	    var_dump($result);
	    die;
    }
*/
    
/*
    public function testGetMfAccessToken(){
	    $data['Pmpage'] = [
		    'id' => '1',
		    'invoice_company_name' => 'テストさん',
		    'invoice_zip' => '111-1111',
		    'invoice_tel' => '0312345678',
		    'invoice_prefecture' => '新潟県',
		    'invoice_address_1' => '新発田市',
		    'invoice_address_2' => 'わー',
		    'invoice_name' => '俺',
		    'invoice_position_name' => '代理補佐',
		    'invoice_department_name' => '桃組',
		    'invoice_email' => 'test@test.com'
	    ];
	    $data['Mypage'] = [
		    'name' => 'おれおれ',
		    'email' => 'test@test.com'
	    ];
	    $result = $this->Pmtotal->addPartner($data);
	    var_dump($result);
	    die;
    }
*/
    

}