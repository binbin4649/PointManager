<?php
App::uses('Pmtotal', 'PointManager.Model');

class PmtotalTest extends BaserTestCase {
    public $fixtures = array(
        'plugin.point_manager.Default/Mypage',
        //'plugin.point_manager.Default/PointBook',
        'plugin.point_manager.Default/Pmpage',
        'plugin.point_manager.Default/PmUser',
    );

    public function setUp() {
        $this->Pmtotal = ClassRegistry::init('PointManager.Pmtotal');
        parent::setUp();
    }
    
    public function tearDown(){
	    unset($this->Pmtotal);
	    parent::tearDown();
    }
    
    

}