<?php
App::uses('PmUser', 'PointManager.Model');


class PmUserTest extends BaserTestCase {
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
        $this->PmUser = ClassRegistry::init('PointManager.PmUser');
        parent::setUp();
    }
    
    public function tearDown(){
	    unset($this->PmUser);
	    parent::tearDown();
    }
    
    public function testIsExtUserTying(){
	    $data['Pmpage']['add_user'] = 1;
	    $r = $this->PmUser->isExtUserTying($data);
	    $this->assertTrue($r);
    }
    
    public function testUserTying(){
	    $data['Mypage']['id'] = '8';
	    $data['Pmpage']['add_user'] = '6';
	    $r = $this->PmUser->userTying($data);
		$this->assertEquals('8', $r['PmUser']['pmpage_id']);
    }

/*
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
*/
    
    

}