<?php
App::uses('Pmpage', 'PointManager.Model');

class PmpageTest extends BaserTestCase {
    public $fixtures = array(
        'plugin.point_manager.Default/Mypage',
        //'plugin.point_manager.Default/PointBook',
        'plugin.point_manager.Default/Pmpage',
        'plugin.point_manager.Default/PmUser',
    );

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
    
    

}