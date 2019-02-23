<?php
App::uses('UserTotal', 'PointManager.Model');

class UserTotalTest extends BaserTestCase {
    public $fixtures = array(
        'plugin.point_manager.Default/Mypage',
        'plugin.point_manager.Default/Pmpage',
        'plugin.point_manager.Default/PmUser',
        'plugin.point_manager.Default/PointUser',
        'plugin.point_manager.Default/UserTotal',
        'plugin.point_manager.Default/Pmtotal',
        'plugin.point_manager.Default/PointBook',
    );

    public function setUp() {
        $this->UserTotal = ClassRegistry::init('PointManager.UserTotal');
        parent::setUp();
    }
    
    public function tearDown(){
	    unset($this->UserTotal);
	    parent::tearDown();
    }
    
    
    public function testUserPayOff(){
	    $result = $this->UserTotal->userPayOff();
	    $this->assertEquals(100, $result[0]['UserTotal']['total']);
    }
    
    public function testOtherPayOff(){
	    $result = $this->UserTotal->otherPayOff();
	    $this->assertEquals(20000, $result[0]['UserTotal']['total']);
    }
    
    public function testForwardToUserTotal(){
	    $result = $this->UserTotal->forwardToUserTotal();
	    $this->assertEquals(1000, $result[0]['UserTotal']['total']);
    }
    
    public function testpmPayOff(){
	    $result = $this->UserTotal->pmPayOff();
	    $this->assertEquals(2000, $result[0]['UserTotal']['total']);
    }
    

}