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
		
		$datasource = $this->getDataSource();
		try{
			$datasource->begin();
			$this->Mypage->create();
			if(!$this->Mypage->save($data)) throw new Exception();
			$data['Pmpage']['mypage_id'] = $this->Mypage->getLastInsertID();
			$this->create();
			if(!$this->save($data)) throw new Exception();
			$data['Pmpage']['id'] = $this->getLastInsertID();
			$datasource->commit();
		}catch(Exception $e){
			$datasource->rollback();
			return false;
		}
		$PmtotalModel = ClassRegistry::init('PointManager.Pmtotal');
		$PmtotalModel->addPartner($data);
		return $data;
	}
    
    public function editSave($data){
	    if(empty($data['Mypage']['password'])){
		    unset($data['Mypage']['password']);
	    }else{
		    $data['Mypage']['password_confirm'] = $data['Mypage']['password'];
	    }
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
		    $datasource->commit();
	    }catch(Exception $e){
		    $datasource->rollback();
			return false;
	    }
	    $PmtotalModel = ClassRegistry::init('PointManager.Pmtotal');
		$PmtotalModel->updatePartner($data);
		return $data;
	    
/*
	    $this->Mypage->set($data);
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
	    if($this->Mypage->validates()){
		    $this->Mypage->save($data);
		    return $this->save($data);
	    }
*/
    }
    
    

}
