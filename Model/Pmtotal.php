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
    
    //全部のまとめ役、cronで叩く用
    public function createInvoice(){
	    $UserTotalModel = ClassRegistry::init('PointManager.UserTotal');
	    $UserTotalModel->userPayOff();//ユーザー単位の精算
	    $UserTotalModel->otherPayOff();//その他の明細テーブル作る。月額保守費とか
	    $UserTotalModel->forwardToUserTotal();//繰越があったらuserTotal追加する
	    $this->PmPayOff();// pmpage単位の精算
	    $result = $this->payOffMail();//請求書送付のご案内
	    
	    return $result;
    }
    
    
    // pmpage単位で精算
    public function PmPayOff(){
	    $forwardPoint = Configure::read('pointManagerPlugin.forwardPoint');
	    $PmpageModel = ClassRegistry::init('PointManager.Pmpage');
	    $UserTotalModel = ClassRegistry::init('PointManager.UserTotal');
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
		    $total = 0;
		    //ユーザー単位とその他の明細も合わせて取得
		    $UserTotals = $UserTotalModel->find('all', [
			    'conditions' => ['UserTotal.pmpage_id' => $Pmpage['Pmpage']['id'], 'UserTotal.yyyymm' => $ym]
		    ]);
			foreach($UserTotals as $UserTotal){
				$total = $total + $UserTotal['UserTotal']['total'];
			}
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
    
    public function payOffMail(){
	    $PointUserModel = ClassRegistry::init('Point.PointUser');
	    $ym = date('Y-m-t');//今月
	    $Pmtotals = $this->find('all', [
		    'conditions' => [
			    'Pmtotal.yyyymm' => $ym,
			    'Pmtotal.mail_submit' => NULL
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
				    $PointUserModel->sendEmail($mail, '請求書送付のご案内', $Pmtotal, array('template'=>'PointManager.invoice', 'layout'=>'default'));
			    }
		    }
		    $Pmtotal['Pmtotal']['mail_submit'] = 'submit';
		    $this->create();
		    $this->save($Pmtotal);
	    }
	    return $Pmtotals;
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
		    $data['Pmpage']['mf_department_id'] = $response['data']['id'];
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
	    $url = 'https://invoice.moneyforward.com/api/v2/partners/'.$data['Pmpage']['mf_department_id'];
	    $post_data['partner'] = [
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
    
    // curlを実行して配列で返す
    public function curlExec($url, $post_data, $headers = null){
	    $ch = curl_init();
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
	    curl_close($ch);
	    $return = mb_convert_encoding($return, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
	    $aray = json_decode($return, true);
	    if(isset($aray['errors'])){
		    $this->log('Pmtotal.php curlExec error. '.print_r($aray, true), 'emergency');
		    return false;
	    }
	    return $aray;
    }
    
    //アクセストークンを返す。
    public function getMfAccessToken(){
	    $PmconfigModel = ClassRegistry::init('PointManager.Pmconfig');
	    $Pmconfig = $PmconfigModel->find('first', []);
	    if(empty($Pmconfig)){
		    $this->log('Pmtotal.php getMfAccessToken find first error.', 'emergency');
		    return false;
	    }
	    $time_diff = time() - strtotime($Pmconfig['Pmconfig']['modified']);
	    if($time_diff > 86400){// 1日以上経っていたらアクセストークン更新
		    $url = "https://invoice.moneyforward.com/oauth/token";
		    $post_data = [
			    'client_id' => $Pmconfig['Pmconfig']['client_id'],
			    'client_secret' => $Pmconfig['Pmconfig']['client_secret'],
			    'refresh_token' => $Pmconfig['Pmconfig']['refresh_token'],
			    'grant_type' => 'refresh_token',
		    ];
		    $new_token = $this->curlExec($url, $post_data);
		    $Pmconfig['Pmconfig']['access_token'] = $new_token['access_token'];
		    $Pmconfig['Pmconfig']['refresh_token'] = $new_token['refresh_token'];
		    if(!$PmconfigModel->save($Pmconfig)){
			    $this->log('Pmtotal.php getMfAccessToken save error.', 'emergency');
		    }
	    }
	    return $Pmconfig['Pmconfig'];
    }
    
    
    
}