<?php
App::uses('UserTotal', 'PointManager.Model');

class UserTotalTest extends BaserTestCase {
    public $fixtures = array(
        'plugin.point_manager.Default/Mypage',
        //'plugin.point_manager.Default/PointBook',
        'plugin.point_manager.Default/Pmpage',
        'plugin.point_manager.Default/PmUser',
        'plugin.point_manager.Default/PointUser',
    );

    public function setUp() {
        $this->UserTotal = ClassRegistry::init('PointManager.UserTotal');
        parent::setUp();
    }
    
    public function tearDown(){
	    unset($this->UserTotal);
	    parent::tearDown();
    }
    
    
    public function testUserPayOffTrue(){
	    $result = $this->UserTotal->userPayOff();
	    $this->assertTrue($result);
    }
    

}