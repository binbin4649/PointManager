<?php

App::import('Model', 'AppModel');

class Pmpage extends AppModel {

	public $name = 'Pmpage';
	
	public $belongsTo = [
		'Mypage' => [
			'className' => 'Members.Mypage',
			'foreignKey' => 'mypage_id']
	];
	
	public $hasMany = [
		'PmUser' => [
			'className' => 'PointManager.PmUser',
			'foreignKey' => 'pmpage_id'
	]];
	
	public $validate = array(
        'company_name' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '会社名を入力して下さい。'),
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => '会社名は100文字以内で入力してください。')
        ),
        'prefecture' => array(
            'notBlank' => array(
                'rule' => array('notBlank'),
                'message' => '都道府県を選択してください。'),
        ),
    );
	
	// Pmpage に mypage_id があるか、無かったらtrue
	public function isNotPmpage($mypage_id){
		if($this->findByMypageId($mypage_id, null, null, -1)){
			return false;
		}else{
			return true;
		}
	}
	
	// mypage_id を受け取って、pmpage_id を返す
	public function mypageToPmpage($mypage_id){
		$Pmpage = $this->findByMypageId($mypage_id, null, null, -1);
		return $Pmpage['Pmpage']['id'];
	}
	
	public function signUp($data){
		$data['Mypage']['username'] = $data['Mypage']['email'];
		$data['Mypage']['password_confirm'] = $data['Mypage']['password'];
		$data['Mypage']['status'] = 0;
		//$PmtotalModel = ClassRegistry::init('PointManager.Pmtotal');
		$this->PmTotal = ClassRegistry::init('PointManager.Pmtotal');
		$this->Mylog = ClassRegistry::init('Members.Mylog');
		$this->PointUser = ClassRegistry::init('Point.PointUser');
		
		//$this->Mypage = ClassRegistry::init('Members.Mypage');
		$datasource = $this->getDataSource();
		try{
			$datasource->begin();
			// Mypage 
			$this->Mypage->create();
			if(!$this->Mypage->save($data)) throw new Exception();
			$mypage_id = $this->Mypage->getLastInsertID();
			$data['Pmpage']['mypage_id'] = $mypage_id;
			// PointUser
			$PointUser = ['PointUser' => [
				'mypage_id' => $mypage_id,
				'point' => 0,
				'credit' => 0,
				'available_point' => 0,
				'pay_plan' => 'pay_off',
				'invoice_plan' => 'pm_month'
			]];
			$this->PointUser->create();
			if(!$this->PointUser->save($PointUser)) throw new Exception();
			// Pmpage
			$this->create();
			if(!$this->save($data)) throw new Exception();
			$data['Pmpage']['id'] = $this->getLastInsertID();
			// Pmtotal
			if(!$this->PmTotal->addPartner($data)) throw new Exception();
			$datasource->commit();
		}catch(Exception $e){
			$this->log('Pmpage.php signUp error. '.print_r($e->getMessage(), true), 'emergency');
			$datasource->rollback();
			return false;
		}
		// Mylog
		if(!$this->Mylog->record($mypage_id, 'signup')){
			$this->log('Pmpage.php signUp mylog record error. '.print_r($data, true), 'emergency');
		}
		return $data;
	}
	
	public function toAss($data){
		if(empty($data['Mypage']['id'])){
			return false;
		}
		$Mypage = $this->Mypage->findById($data['Mypage']['id'], null, null, -1);
		if(empty($Mypage)){
			return false;
		}
		if(!$this->isNotPmpage($data['Mypage']['id'])){
			return false;
		}
		$Mypage['Mypage']['zip'] = $data['Mypage']['zip'];
		$Mypage['Mypage']['address_1'] = $data['Mypage']['address_1'];
		$Mypage['Mypage']['address_2'] = $data['Mypage']['address_2'];
		$Mypage['Mypage']['tel'] = $data['Mypage']['tel'];
		$data['Mypage']['name'] = $Mypage['Mypage']['name'];
		$data['Mypage']['email'] = $Mypage['Mypage']['email'];
		unset($Mypage['Mypage']['password']);
		$this->PmTotal = ClassRegistry::init('PointManager.Pmtotal');
		$this->PointUser = ClassRegistry::init('Point.PointUser');
		$PointUser = $this->PointUser->findByMypageId($data['Mypage']['id'], null, null, -1);
		$datasource = $this->getDataSource();
		try{
			$datasource->begin();
			$this->Mypage->create();
			if(!$this->Mypage->save($Mypage, false)){
				$this->log('Pmpage.php toAss error. Mypage.'.print_r($Mypage, true), 'emergency');
				throw new Exception();
			}
			$PointUser['PointUser']['pay_plan'] = 'pay_off';
			$PointUser['PointUser']['invoice_plan'] = 'pm_month';
			$this->PointUser->create();
			if(!$this->PointUser->save($PointUser)){
				$this->log('Pmpage.php toAss error. PointUser.'.print_r($PointUser, true), 'emergency');
				throw new Exception();
			}
			$data['Pmpage']['mypage_id'] = $data['Mypage']['id'];
			$this->create();
			if(!$this->save($data)){
				$this->log('Pmpage.php toAss error. Pmpage.'.print_r($data, true), 'emergency');
				throw new Exception();
			}
			$data['Pmpage']['id'] = $this->getLastInsertID();
			if(!$this->PmTotal->addPartner($data)){
				$this->log('Pmpage.php toAss error. Pmtotal.'.print_r($data, true), 'emergency');
				throw new Exception();
			}
			$datasource->commit();
		}catch(Exception $e){
			$datasource->rollback();
			$this->log('Pmpage.php toAss error. '.print_r($e->getMessage(), true), 'emergency');
			return false;
		}
		return $data;
	}
    
    public function editSave($data){
	    if(empty($data['Mypage']['password'])){
		    unset($data['Mypage']['password']);
	    }else{
		    $data['Mypage']['password_confirm'] = $data['Mypage']['password'];
	    }
	    $this->Pmtotal = ClassRegistry::init('PointManager.Pmtotal');
	    $datasource = $this->getDataSource();
	    try{
		    $datasource->begin();
		    $this->Mypage->validator()
		    	->add('zip', array(
				    'rule' => 'notBlank',
				    'message'=>'郵便番号を入力してください。'
			))->add('address_1', array(
				    'rule' => 'notBlank',
				    'message'=>'住所を入力してください。'
			))->add('tel', array(
				    'rule' => 'notBlank',
				    'message'=>'電話番号を入力してください。'
			));
		    if(!$this->Mypage->save($data))  throw new Exception();
		    if(!$this->save($data)) throw new Exception();
		    //if(!$this->Pmtotal->updatePartner($data))  throw new Exception(); やっぱりなぜかできない。一旦保留。
		    $datasource->commit();
	    }catch(Exception $e){
		    $datasource->rollback();
		    $this->log('Pmpage.php editSave error. '.print_r($e->getMessage(), true), 'emergency');
			return false;
	    }
	    return $data;
    }
    
    

}
