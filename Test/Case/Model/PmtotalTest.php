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
    
	/*
	https://api.biz.moneyforward.com/authorize?response_type=code&client_id=13079033563764&scope=mfc/invoice/data.write&redirect_uri=http://localhost/
	&client_idとredirect_uriを取り替えて、ブラウザでアクセス

	http://localhost/?code=AxbUfX7xgNsE-W2nNp8nStcSnwvQXfm0gJMLNsd03qw&iss=https%3A%2F%2Fbiz.moneyforward.com
	codeの部分を控えて、$authCodeに入れる。有効期限に注意

	ブラウザ、.test.php -> PointManeger -> Pmtotal 
	var_dumpのコメントアウトをはずして実行
	*/
    public function testExecuteMfApiTokenRequest() {
        //$clientID = '13079033563764';
		$clientID = '';
        $clientSecret = 'wayyNDtT74UA2NF-vXC2D_jM3AJ3GCbMLaYGRn3rUmHiSllcl08ct1SLLtK2336gJ5ySg3RTheyWQfiqarkMwQ';
        $authCode = 'AxbUfX7xgNsE-W2nNp8nStcSnwvQXfm0gJMLNsd03qw';
        $redirectURI = 'http://localhost/';
		if(empty($clientID) || empty($clientSecret)){
			$this->markTestSkipped('access_tokenを取得する時に実行する。');
		}
        $result = $this->Pmtotal->executeMfApiTokenRequest($clientID, $clientSecret, $authCode, $redirectURI);
		// var_dump($result);
		// die;

        $this->assertIsArray($result);
        $this->assertArrayHasKey('access_token', $result);
        $this->assertArrayHasKey('token_type', $result);
        $this->assertArrayHasKey('scope', $result);
        $this->assertArrayHasKey('refresh_token', $result);
    }

    public function testRefreshMfAccessToken() {
        // $clientID = '13079033563764';
		$clientID = '';
        $clientSecret = 'wayyNDtT74UA2NF-vXC2D_jM3AJ3GCbMLaYGRn3rUmHiSllcl08ct1SLLtK2336gJ5ySg3RTheyWQfiqarkMwQ';
        $refreshToken = 'PPopY4qBRLV7obkNZ6ov-Dmnu-_HOk0Bh6KWdBkTXvs';//PmconfigFixture.phpを見て新しいtokenを入れる
		if(empty($clientID) || empty($clientSecret)){
			$this->markTestSkipped('access_tokenをrefreshする時に実行する。');
		}
        $result = $this->Pmtotal->refreshMfAccessToken($clientID, $clientSecret, $refreshToken);
		var_dump($result);
		die;

        $this->assertIsArray($result);
        $this->assertArrayHasKey('access_token', $result);
        $this->assertArrayHasKey('token_type', $result);
        $this->assertArrayHasKey('scope', $result);
        $this->assertArrayHasKey('refresh_token', $result);
    }

	// public function testBillingPdf()
	// {
	// 	$billing_id = 'Gu-1_YwfvQN2u8tG_JgzlQ';
	// 	$pmtotal_id = '2';
	// 	$result = $this->Pmtotal->billingPdf($billing_id, $pmtotal_id);
	// 	var_dump($result);
	// 	die;
	// }

	// public function testMfBillingsCreate()
	// {
	// 	$result = $this->Pmtotal->mfBillingsCreate();
	// 	var_dump($result);
	// 	die;
		
	// }

    public function testAddPartner() {
        $data = [
            'Pmpage' => [
                'id' => '123',
				'mypage_id' => 1,
                'invoice_company_name' => 'テスト株式会社',
                'invoice_zip' => '100-0001',
                'invoice_tel' => '03-1234-5678',
                'invoice_prefecture' => '東京都',
                'invoice_address_1' => '千代田区',
                'invoice_address_2' => 'テストビルディング',
                'invoice_name' => '山田太郎',
                'invoice_position_name' => '部長',
                'invoice_department_name' => '営業部',
                'invoice_email' => 'invoice@example.com'
			],
			'Mypage' => [
				'id' => 1,
				'name' => 'テスト太郎',
				'email' => 'test@example.com'
			]
        ];

        $expected = [
            'id' => 'test_id',
            'departments' => [
                ['id' => 'test_departments_id']
            ]
        ];
        $result = $this->Pmtotal->addPartner($data);
        $this->assertNotEmpty($result);
        $this->assertEquals($expected['id'], $result['Pmpage']['mf_partner_id']);
        $this->assertEquals($expected['departments'][0]['id'], $result['Pmpage']['mf_department_id']);
    }

    public function testBillingPdfPath(){
	    $pmtotal_id = '70';
	    $result = $this->Pmtotal->billingPdfPath($pmtotal_id);
	    $this->assertEquals(APP.'Plugin/PointManager/webroot/files/pdf/invoice-70.pdf', $result);
    }
    
/*
    public function testBillingPdf(){
	    $billing_id = 'kSplMFj3N70_7GHKy_Nkzw';
	    $pmtotal_id = '70';
	    $r = $this->Pmtotal->billingPdf($billing_id, $pmtotal_id);
	    var_dump($r);
	    die;
    }
*/
    
    public function testFilesPdfIsWritable(){
	    $r = is_writable(APP.'Plugin/PointManager/webroot/files/pdf/');
	    $this->assertTrue($r);
    }
    
    public function testPmPayOff(){
	    Configure::write('pointManagerPlugin.forwardPoint', 100);
	    $result = $this->Pmtotal->PmPayOff();
	    $this->assertEquals(600, $result[0]['Pmtotal']['total']);
	    $this->assertEquals('run', $result[0]['Pmtotal']['status']);
    }
    
    public function testPayOffMail(){
	    //Configure::write('MccPlugin.TEST_MODE', false);
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
	    // $this->assertEquals(21070, $result[0]['Pmtotal']['total']);
		$this->assertEquals(6000, $result[0]['Pmtotal']['total']);
    }
    
    // public function testMfBillingsCreate(){
	//     $r = $this->Pmtotal->mfBillingsCreate();
	//     $this->assertEquals('test_id', $r[0]['data']['id']);
	//     $this->assertEquals('forward', $r[1]['data']['id']);
    // }
    
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
    
    public function testDueDateNextMonth(){
	    $mypage_id = 1;
	    $r = $this->Pmtotal->dueDateNextMonth($mypage_id);
	    $date = date('Y-m-d', strtotime('last day of next month'));
	    $this->assertEquals($date, $r);
    }
    
    public function testDueDateNextNextMonth(){
	    Configure::write('NosPlugin.Invoice2Month', ['193']);
	    $mypage_id = 193;
	    $r = $this->Pmtotal->dueDateNextMonth($mypage_id);
	    $date = date('Y-m-d', strtotime('last day of 2 month'));
	    $this->assertEquals($date, $r);
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