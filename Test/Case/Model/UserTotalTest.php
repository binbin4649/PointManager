<?php
App::uses('UserTotal', 'PointManager.Model');

class UserTotalTest extends BaserTestCase
{
	public $fixtures = array(
		'plugin.point_manager.Default/Mypage',
		'plugin.point_manager.Default/Pmpage',
		'plugin.point_manager.Default/PmUser',
		'plugin.point_manager.Default/PointUser',
		'plugin.point_manager.Default/UserTotal',
		'plugin.point_manager.Default/Pmtotal',
		'plugin.point_manager.Default/PointBook',
	);

	public function setUp()
	{
		$this->UserTotal = ClassRegistry::init('PointManager.UserTotal');
		parent::setUp();
	}

	public function tearDown()
	{
		unset($this->UserTotal);
		parent::tearDown();
	}

	public function testPdfExistsFalse()
	{
		$pmtotal_id = '2';
		$result = $this->UserTotal->pdfExists($pmtotal_id);
		$this->assertEquals('invoice-2.pdf', $result);
	}

	public function testPdfExists()
	{
		$pmtotal_id = '1';
		$result = $this->UserTotal->pdfExists($pmtotal_id);
		$this->assertEquals('invoice-1.pdf', $result);
	}

	public function testUserPayOff()
	{
		$result = $this->UserTotal->userPayOff();
		$this->assertEquals(100, $result[0]['UserTotal']['total']);
	}

	public function testOtherPayOff()
	{
		$result = $this->UserTotal->otherPayOff();
		$this->assertEquals(20000, $result[0]['UserTotal']['total']);
	}

	public function testForwardToUserTotal()
	{
		$result = $this->UserTotal->forwardToUserTotal();
		$this->assertEquals(1000, $result[0]['UserTotal']['total']);
	}

	public function testpmPayOff()
	{
		$result = $this->UserTotal->pmPayOff();
		$this->assertEquals(100, $result[0]['UserTotal']['total']);
	}

	public function testFromPmpageId()
	{
		$pmpage_id = 1;
		$yyyymm = date('Ym');
		$r = $this->UserTotal->fromPmpageId($pmpage_id, $yyyymm);
		$this->assertEquals('1', $r[0]['UserTotal']['pmpage_id']);
	}

	public function testItemPayOff()
	{
		$PmUserModel = ClassRegistry::init('PointManager.PmUser');
		$PmUser = $PmUserModel->findByMypageId(1);
		$r = $this->UserTotal->itemPayOff($PmUser);
		$this->assertEquals(100, $r[0]['UserTotal']['unit_price']);
	}

	public function testTotalDiff()
	{
		$total = '500';
		$conf_total = '700';
		$Pmpage['Pmpage']['id'] = '1';
		$Pmpage['Pmpage']['mypage_id'] = '1';
		$r = $this->UserTotal->totalDiff($total, $conf_total, $Pmpage);
		$this->assertEquals('-200', $r['UserTotal']['total']);
	}
}
