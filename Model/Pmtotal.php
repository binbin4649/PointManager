<?php
App::import('Model', 'AppModel');

class Pmtotal extends AppModel {

	public $name = 'Pmtotal';
	
	public $belongsTo = [
		'Mypage' => [
			'className' => 'Members.Mypage',
			'foreignKey' => 'mypage_id'],
		'Pmpage' => [
			'className' => 'PointManager.Pmpage',
			'foreignKey' => 'pmpage_id'],
	];
	
	// pmtotal_id で UserTotals を返す
	public function toUserTotals($id){
		$this->UserTotal = ClassRegistry::init('PointManager.UserTotal');
		$Pmtotal = $this->findById($id, null, null, -1);
		$UserTotals = $this->UserTotal->fromPmpageId($Pmtotal['Pmtotal']['pmpage_id'], $Pmtotal['Pmtotal']['yyyymm']);
		return $UserTotals;
	}
	
	// 指定月の Pmtotal を返す
	public function fromPmpageId($pmpage_id, $yyyymm){
		if(empty($pmpage_id)){
		    return false;
	    }
	    $date = $this->lastDay($yyyymm);
	    $Pmtotal = $this->find('first', [
			'conditions' => [
				'Pmtotal.pmpage_id' => $pmpage_id,
				'Pmtotal.yyyymm' => $date
			]
		]);
		return $Pmtotal;
	}
	
	// yyyymm を 指定月の月末 yyyy-mm-dd 形式で返す
	public function lastDay($yyyymm){
		return date('Y-m-d', strtotime('last day of ' . $yyyymm));
	}
    
    //全部のまとめ役、cronで叩く用
    public function createInvoice(){
	    $UserTotalModel = ClassRegistry::init('PointManager.UserTotal');
	    $user_payoff = $UserTotalModel->userPayOff();//ユーザー単位の精算
	    $pmpage_payoff = $UserTotalModel->pmPayOff();// pmpage自身のポイント精算
	    $other_payoff = $UserTotalModel->otherPayOff();//その他の明細テーブル作る。月額保守費とか
	    //$result = $UserTotalModel->forwardToUserTotal();//繰越があったらuserTotal追加する
	    $pm_payoff = $this->PmPayOff();// pmpage単位の精算
	    $billing = $this->mfBillingsCreate();//MFに請求書データ送る
	    $mail = $this->payOffMail();//請求書送付のご案内
	    return $mail;
    }
    
    
    // UserTotalを合算、pmpage単位で精算
    public function PmPayOff(){
	    $forwardPoint = Configure::read('pointManagerPlugin.forwardPoint');
	    $PmpageModel = ClassRegistry::init('PointManager.Pmpage');
	    $ym = date('Y-m-t');//今月
	    $Pmtotals = [];
	    $Pmpages = $PmpageModel->find('all', [
	    	'conditions' => ['Mypage.status <>' => '2']
	    ]);
	    foreach($Pmpages as $Pmpage){
		    //念には念の為、2回精算を防止
		    $overlapBan = $this->find('first', [
			    'conditions' => ['Pmtotal.pmpage_id'=>$Pmpage['Pmpage']['id'], 'Pmtotal.yyyymm'=>$ym]
		    ]);
		    if($overlapBan) continue;
			$total = $this->userTotalTotal($Pmpage['Pmpage']['id']);
			//0円だったら生成しない
			if($total == 0) continue;
			//繰越判定
			if($forwardPoint > $total){
				$status = 'forward';
			}else{
				$status = 'run';
			}
			$Pmtotal = [];
			$Pmtotal['Pmtotal'] = [
				'mypage_id' => $Pmpage['Mypage']['id'],
				'pmpage_id' => $Pmpage['Pmpage']['id'],
				'yyyymm' => $ym,
				'total' => $total,
				'status' => $status
			];
			$this->create();
			if($this->save($Pmtotal)){
				$Pmtotals[] = $Pmtotal;
			}else{
				$this->log('Pmtotal.php PmPayOff save error.');
			}
	    }
	    return $Pmtotals;
    }
    
    //締め前の合計金額を出す
    public function userTotalTotal($pmpage_id){
	    $total = 0;
	    $UserTotalModel = ClassRegistry::init('PointManager.UserTotal');
	    //ユーザー単位とその他の明細も合わせて取得
	    $UserTotals = $UserTotalModel->find('all', [
		    'conditions' => [
		    	'UserTotal.pmpage_id' => $pmpage_id,
		    	'UserTotal.status' => 'before'
		    	//'UserTotal.yyyymm' => $ym
		    ]
	    ]);
		foreach($UserTotals as $UserTotal){
			$total = $total + $UserTotal['UserTotal']['total'];
		}
		return $total;
    }
    
    // UserTotal status を全部runに、
    public function userTotalRun($pmpage_id){
	    $UserTotalModel = ClassRegistry::init('PointManager.UserTotal');
	    $UserTotals = $UserTotalModel->find('all', [
		    'conditions' => [
		    	'UserTotal.pmpage_id' => $pmpage_id,
		    	'UserTotal.status' => 'before'
		    ]
	    ]);
	    foreach($UserTotals as $UserTotal){
		    $UserTotalModel->create();
		    $UserTotal['UserTotal']['status'] = 'run';
		    if(!$UserTotalModel->save($UserTotal)){
			    $this->log('Pmtotal.php userTotalRun save error. : '.print_r($UserTotal, true), 'emergency');
			    return false;
		    }
	    }
	    return $UserTotals;
    }
    
    public function payOffMail(){
	    $MypageModel = ClassRegistry::init('Members.Mypage');
	    $return = [];
	    $ym = date('Y-m-t');//今月末
	    $Pmtotals = $this->find('all', [
		    'conditions' => [
			    'Pmtotal.yyyymm' => $ym,
			    'Pmtotal.mail_submit' => NULL,
			    'Pmpage.invoice_mail_notice' => 'yes'
		    ]
	    ]);
	    foreach($Pmtotals as $Pmtotal){
		    $mails = [];
		    $mails[] = $Pmtotal['Mypage']['email'];
		    if(!empty($Pmtotal['Pmpage']['invoice_email'])){
			    $invoice_emails = explode(",", $Pmtotal['Pmpage']['invoice_email']);
			    foreach($invoice_emails as $invoice_email){
				    $mails[] = $invoice_email;
			    }
		    }
		    $Pmtotal = $this->billingAddress($Pmtotal);
		    foreach($mails as $mail){
			    if(!Configure::read('MccPlugin.TEST_MODE')){
				    if($Pmtotal['Pmtotal']['status'] == 'forward'){
					    $MypageModel->sendEmail($mail, '請求繰越のご案内', $Pmtotal, array('template'=>'PointManager.forward', 'layout'=>'default'));
				    }else{
					    $options = [
						    'template' => 'PointManager.invoice',
						    'layout' => 'default',
						    'attachments' => $this->billingPdfPath($Pmtotal['Pmtotal']['id']),
					    ];
					    $MypageModel->sendEmail($mail, '請求書送付のご案内', $Pmtotal, $options);
				    }
			    }
		    }
		    $Pmtotal['Pmtotal']['mail_submit'] = 'submit';
		    $this->create();
		    if(!$this->save($Pmtotal)){
			    $this->log('Pmtotal.php payOffMail save error. '.print_r($Pmtotal, true), 'emergency');
		    }
		    $return[] = $Pmtotal;
	    }
	    return $return;
    }
    
    // 会社によって支払日が違う
    public function dueDateNextMonth($mypage_id){
	    $Invoice2Month = Configure::read('NosPlugin.Invoice2Month');
	    $due_date = '';
	    if(!empty($Invoice2Month)){
		    foreach($Invoice2Month as $id){
			    if($mypage_id == $id){
				    $due_date = date('Y-m-d', strtotime('last day of 2 month'));//翌々月末
			    }
		    }
	    }
	    if(empty($due_date)){
		    $due_date = date('Y-m-d', strtotime('last day of next month'));//翌月末
	    }
	    return $due_date;
    }
    
    public function mfBillingsCreate(){
	    $url = 'https://invoice.moneyforward.com/api/v2/billings';
	    $document_name = Configure::read('NosPlugin.InvoiceDocumentName');
	    $title = Configure::read('NosPlugin.InvoiceTitle');
	    if(empty($document_name)){
		    $document_name = '請求書';
	    }
	    $res = [];
	    $ym = date('Y-m-t');//今月末
	    $billing_date = date('Y-m-d', strtotime('first day of next month'));//翌月1日
	    $Pmtotals = $this->find('all', [
		    'conditions' => [
			    'Pmtotal.yyyymm' => $ym,
			    'Pmtotal.mf_billing_id' => NULL
		    ]
	    ]);
	    foreach($Pmtotals as $Pmtotal){
		    if($Pmtotal['Pmtotal']['status'] == 'forward'){
			    $response['data']['id'] = 'forward';
		    }else{
			    $due_date = $this->dueDateNextMonth($Pmtotal['Pmtotal']['mypage_id']);
			    // UserTotal status を全部runに、
				$UserTotals = $this->userTotalRun($Pmtotal['Pmpage']['id']);
				$post_data = [];
				$post_data['billing'] = [
					'department_id' => $Pmtotal['Pmpage']['mf_department_id'],
					'billing_number' => $Pmtotal['Pmtotal']['id'],
					'billing_date' => $billing_date,
					'due_date' => $due_date,
					'document_name' => $document_name,
					'title' => $title,
				];
				foreach($UserTotals as $UserTotal){
					$post_data['billing']['items'][] = [
						'name' => $UserTotal['UserTotal']['name'],
						'quantity' => $UserTotal['UserTotal']['quantity'],
						'unit_price' => $UserTotal['UserTotal']['unit_price'],
						'excise' => "ten_percent"
					];
				}
				$response = $this->mfAccess($url, $post_data, true);
		    }
			if(!empty($response['data']['id'])){
			    $Pmtotal['Pmtotal']['mf_billing_id'] = $response['data']['id'];
			    $this->create();
			    if(!$this->save($Pmtotal)){
				    $this->log('Pmtotal.php mfBillingsCreate error3. '.print_r($Pmtotal, true), 'emergency');
			    }
			    $this->billingPdf($response['data']['id'], $Pmtotal['Pmtotal']['id']);
		    }else{
			    $this->log('Pmtotal.php mfBillingsCreate error2. '.print_r($response, true), 'emergency');
			    $this->log('Pmtotal.php mfBillingsCreate error. '.print_r($post_data, true), 'emergency');
		    }
		    $res[] = $response;
	    }
	    return $res;
    }
    
    
    public function billingAddress($Pmtotal){
	    if(empty($Pmtotal['Pmpage']['invoice_tel'])) $Pmtotal['Pmpage']['invoice_tel'] = $Pmtotal['Mypage']['tel'];
	    if(empty($Pmtotal['Pmpage']['invoice_zip'])) $Pmtotal['Pmpage']['invoice_zip'] = $Pmtotal['Mypage']['zip'];
	    if(empty($Pmtotal['Pmpage']['invoice_prefecture'])) $Pmtotal['Pmpage']['invoice_prefecture'] = $Pmtotal['Pmpage']['prefecture'];
	    if(empty($Pmtotal['Pmpage']['invoice_address_1'])) $Pmtotal['Pmpage']['invoice_address_1'] = $Pmtotal['Mypage']['address_1'];
	    if(empty($Pmtotal['Pmpage']['invoice_address_2'])) $Pmtotal['Pmpage']['invoice_address_2'] = $Pmtotal['Mypage']['address_2'];
	    if(empty($Pmtotal['Pmpage']['invoice_company_name'])) $Pmtotal['Pmpage']['invoice_company_name'] = $Pmtotal['Pmpage']['company_name'];
	    if(empty($Pmtotal['Pmpage']['invoice_department_name'])) $Pmtotal['Pmpage']['invoice_department_name'] = $Pmtotal['Pmpage']['department_name'];
	    if(empty($Pmtotal['Pmpage']['invoice_position_name'])) $Pmtotal['Pmpage']['invoice_position_name'] = $Pmtotal['Pmpage']['position_name'];
	    //メール送信先の宛名が複数あったら配列に入れる。複数無ければ一つだけ。
	    $Pmtotal['Pmpage']['invoice_names'][] = $Pmtotal['Mypage']['name'];
	    if(empty($Pmtotal['Pmpage']['invoice_name'])){
		    $Pmtotal['Pmpage']['invoice_name'] = $Pmtotal['Mypage']['name'];
	    }else{
		    $Pmtotal['Pmpage']['invoice_names'][] = $Pmtotal['Pmpage']['invoice_name'];
	    }
	    if(!empty($Pmtotal['Pmpage']['invoice_name2'])){
		    $Pmtotal['Pmpage']['invoice_names'][] = $Pmtotal['Pmpage']['invoice_name2'];
	    }
	    return $Pmtotal;
    }
    
    
    
    // 取引先登録用
    public function addPartner($data){
	    $data = $this->billingAddress($data);
	    $url = 'https://invoice.moneyforward.com/api/v2/partners';
	    $post_data['partner'] = [
		    'code' => $data['Pmpage']['id'],
		    'name' => $data['Pmpage']['invoice_company_name'],
		    'name_suffix' => '様',
		    'zip' => $data['Pmpage']['invoice_zip'],
		    'tel' => $data['Pmpage']['invoice_tel'],
		    'prefecture' => $data['Pmpage']['invoice_prefecture'],
		    'address1' => $data['Pmpage']['invoice_address_1'],
		    'address2' => $data['Pmpage']['invoice_address_2'],
		    'person_name' => $data['Pmpage']['invoice_name'],
		    'person_title' => $data['Pmpage']['invoice_position_name'],
		    'department_name' => $data['Pmpage']['invoice_department_name'],
		    'email' => $data['Mypage']['email'],
		    'cc_emails' => $data['Pmpage']['invoice_email']
	    ];
	    $response = $this->mfAccess($url, $post_data, true);
	    if(!empty($response['data']['id'])){
		    $PmpageModel = ClassRegistry::init('PointManager.Pmpage');
		    $data['Pmpage']['mf_partner_id'] = $response['data']['id'];
		    $data['Pmpage']['mf_department_id'] = $response['data']['relationships']['departments']['data'][0]['id'];
		    return $PmpageModel->save($data); 
	    }else{
		    $this->log('Pmtotal.php addPartner error2. '.print_r($response, true), 'emergency');
		    $this->log('Pmtotal.php addPartner error. '.print_r($post_data, true), 'emergency');
		    return false;
	    }
    }
    
    // 取引先更新用
    public function updatePartner($data){
	    $data = $this->billingAddress($data);
	    $url = 'https://invoice.moneyforward.com/api/v2/partners/'.$data['Pmpage']['mf_partner_id'];
	    $post_data['partner'] = [
		    'code' => $data['Pmpage']['id'],
		    'name' => $data['Pmpage']['invoice_company_name'],
		    'departments' => [[
			    'id' => $data['Pmpage']['mf_department_id'],
			    'zip' => $data['Pmpage']['invoice_zip'],
			    'tel' => $data['Pmpage']['invoice_tel'],
			    'prefecture' => $data['Pmpage']['invoice_prefecture'],
			    'address1' => $data['Pmpage']['invoice_address_1'],
			    'address2' => $data['Pmpage']['invoice_address_2'],
			    'person_name' => $data['Pmpage']['invoice_name'],
			    'person_title' => $data['Pmpage']['invoice_position_name'],
			    'name' => $data['Pmpage']['invoice_department_name'],
			    'email' => $data['Mypage']['email'],
			    'cc_emails' => $data['Pmpage']['invoice_email']
		    ]]
	    ];
	    $response = $this->mfAccess($url, $post_data, true);
	    if(!$response){
		    $this->log('Pmtotal.php updatePartner error2. '.print_r($response, true), 'emergency');
		    $this->log('Pmtotal.php updatePartner error. '.print_r($post_data, true), 'emergency');
	    }
	    return $response;
    }
    
    
    // url と data だけで結果を取得できる。下記2つを合体させたモノ
    // headers == true でヘッダー出す。無ければpost_dateにbefore_data含める
    // $url = string
    // $post_data = array
    // $headers = boolean
    public function mfAccess($url, $post_data = [], $header = false){
	    if(Configure::read('MccPlugin.TEST_MODE')){
		   $aray['data']['id'] = 'test_id';
		   $aray['data']['relationships']['departments']['data'][0]['id'] = 'test_departments_id';
		   return $aray;
	    }
	    $headers = null;
	    $Pmconfig = $this->getMfAccessToken();
	    if($header){
		    $headers = [
			    'Authorization: BEARER '.$Pmconfig['access_token'],
			    'Content-Type: application/json'
		    ];
	    }else{
		    $before_data = [
			    'client_id' => $Pmconfig['client_id'],
			    'client_secret' => $Pmconfig['client_secret'],
			    'access_token' => $Pmconfig['access_token'],
		    ];
		    $post_data = array_merge($before_data, $post_data);
	    }
	    return $this->curlExec($url, $post_data, $headers);
    }
    
    public function billingPdfPath($pmtotal_id){
	    $path = APP.'Plugin/PointManager/webroot/files/pdf/invoice-'.$pmtotal_id.'.pdf';
	    return $path;
    }
    
    public function billingPdf($billing_id, $pmtotal_id){
	    if(Configure::read('MccPlugin.TEST_MODE')){
		    return true;
	    }
	    $path = $this->billingPdfPath($pmtotal_id);
	    $url = 'https://invoice.moneyforward.com/api/v1/billings/'.$billing_id.'.pdf';
	    $Pmconfig = $this->getMfAccessToken();
	    $headers = [
		    'Authorization: BEARER '.$Pmconfig['access_token']
	    ];
	    $fp = fopen($path, 'w+');
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_FILE, $fp);
	    $return = curl_exec($ch);
		curl_close($ch);
		fclose($fp);
	    return $return;
    }
    
    // curlを実行して配列で返す
    public function curlExec($url, $post_data, $headers = null){
	    $date = date('Ym');
	    $fp = fopen(APP.'/tmp/curl'.$date.'.log', 'a');
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_VERBOSE, true);
	    curl_setopt($ch, CURLOPT_STDERR, $fp);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_URL, $url); 
	    curl_setopt($ch,CURLOPT_POST, true);
	    if($headers != null){
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
	    }else{
		    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
	    }
	    $return =  curl_exec($ch);
	    fclose($fp);
	    curl_close($ch);
	    $return = mb_convert_encoding($return, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
	    $aray = json_decode($return, true);
	    if(isset($aray['errors']) or isset($aray['error'])){
		    $this->log('Pmtotal.php curlExec error. '.print_r($aray, true), 'emergency');
		    return false;
	    }
	    return $aray;
    }
    
    
    //curl -d client_id=[CLIENT_ID] -d client_secret=[CLIENT_SECRET] -d redirect_uri=[REDIRECT_URL] -d grant_type=authorization_code -d code=[認証コード] -X POST https://invoice.moneyforward.com/oauth/token
    //アクセストークンを返す。
    public function getMfAccessToken(){
	    $PmconfigModel = ClassRegistry::init('PointManager.Pmconfig');
	    $Pmconfig = $PmconfigModel->find('first', []);
	    if(empty($Pmconfig)){
		    $this->log('Pmtotal.php getMfAccessToken find first error.', 'emergency');
		    return false;
	    }
	    $time_diff = time() - strtotime($Pmconfig['Pmconfig']['modified']);
	    if($time_diff > 43200){// 43200 = 12時間
		    $url = "https://invoice.moneyforward.com/oauth/token";
		    $post_data = [
			    'client_id' => $Pmconfig['Pmconfig']['client_id'],
			    'client_secret' => $Pmconfig['Pmconfig']['client_secret'],
			    'refresh_token' => $Pmconfig['Pmconfig']['refresh_token'],
			    'grant_type' => 'refresh_token',
		    ];
		    $new_token = $this->curlExec($url, $post_data);
		    if(isset($new_token['error']) or isset($new_token['errors'])){
			    $this->log('Pmtotal.php getMfAccessToken MF API Error. '.print_r($new_token, true), 'emergency');
			    return false;
		    }
		    if(empty($new_token['access_token']) or empty($new_token['refresh_token'])){
			    $this->log('Pmtotal.php getMfAccessToken new token empty. '.print_r($new_token, true), 'emergency');
			    return false;
		    }
		    $Pmconfig['Pmconfig']['access_token'] = $new_token['access_token'];
		    $Pmconfig['Pmconfig']['refresh_token'] = $new_token['refresh_token'];
		    $PmconfigModel->create();
		    if(!$PmconfigModel->save($Pmconfig)){
			    $this->log('Pmtotal.php getMfAccessToken save error.', 'emergency');
			    return false;
		    }
	    }
	    return $Pmconfig['Pmconfig'];
    }
    
    //使ってない
    //ログインしてないと認証コードがとれない＝テストはできない
    // $data = ['client_id', 'client_secret'];
    public function createMfAccessToken($data){
	    $siteUrl = urlencode(Configure::read('BcEnv.siteUrl'));
	    $auth_url = 'https://invoice.moneyforward.com/oauth/authorize?client_id='.$data['client_id'].'&redirect_uri='.$siteUrl.'&response_type=code&scope=write';
	    $headers = get_headers($auth_url, 1);
	    $url = "https://invoice.moneyforward.com/oauth/token";
	    $post_data = [
		    'client_id' => $Pmconfig['Pmconfig']['client_id'],
		    'client_secret' => $Pmconfig['Pmconfig']['client_secret'],
		    'redirect_uri' => '',
		    'grant_type' => 'authorization_code',
		    'code' => $code,
	    ];
	    
    }
    
}
