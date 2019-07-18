<?php
App::import('Model', 'AppModel');

class PmUser extends AppModel {

	public $name = 'PmUser';
    
    public $belongsTo = [
		'Mypage' => [
			'className' => 'Members.Mypage',
			'foreignKey' => 'mypage_id'
		],
		'Pmpage' => [
			'className' => 'PointManager.Pmpage',
			'foreignKey' => 'pmpage_id'
		],
	];
    
    
    public function userAdd($data, $mypage_id){
	    $data['Mypage']['username'] = $data['Mypage']['email'];
		$data['Mypage']['status'] = 0;
		$this->Mypage->set($data);
		if($this->Mypage->validates()){
			// mypage保存
			$this->Mypage->create();
			$this->Mypage->save($data);
			$data['PmUser']['mypage_id'] = $this->Mypage->getLastInsertID();
			$data['PmUser']['pmpage_id'] = $this->Pmpage->mypageToPmpage($mypage_id);
			// point_user保存
			$PointUserModel = ClassRegistry::init('Point.PointUser');
			$PointUser = ['PointUser' => [
				'mypage_id' => $data['PmUser']['mypage_id'],
				'point' => 0,
				'credit' => 0,
				'available_point' => 0,
				'pay_plan' => 'pay_off',
				'invoice_plan' => 'pm_month'
			]];
			$PointUserModel->create();
			$PointUserModel->save($PointUser);
			// pm_user保存
			if($this->save($data)){
				return $data;
			}else{
				return false;
			}
		}else{
			return false;
		}
    }
    
    public function user_delete($data){
	    if(empty($data['Mypage']['id'])) return false;
	    $mypage = $data['Mypage'];
	    if(empty($mypage['email'])){
		    $mypage['email'] = $this->Mypage->findById($mypage['id'], null, null, -1)['Mypage']['email'];
	    }
	    //$MccCall = ClassRegistry::init('Mcc.MccCall');
	    //$MccCall->deleteAllReserve($mypage['id']);
	    if($this->Mypage->withdrawal($mypage)){
		    return true;
	    }else{
		    return false;
	    }
    }
    
    // そのユーザーは既に紐付けられているか、紐付いてたらtrue
    public function isExtUserTying($data){
	    if($this->findByPmpageId($data['Pmpage']['add_user'], null, null, -1)){
		    return true;
	    }else{
		    return false;
	    }
    }
    
    // 紐付け
    public function userTying($data){
	    $pmpage_id = $this->Pmpage->mypageToPmpage($data['Mypage']['id']);
	    $PmUser['PmUser']['pmpage_id'] = $pmpage_id;
	    $PmUser['PmUser']['mypage_id'] = $data['Pmpage']['add_user'];
	    $this->create();
	    if($this->save($PmUser)){
		    $this->PointUser = ClassRegistry::init('Point.PointUser');
		    $PointUser = $this->PointUser->findByMypageId($data['Mypage']['id'], null, null, -1);
		    $PointUser['PointUser']['pay_plan'] = 'pay_off';
			$PointUser['PointUser']['invoice_plan'] = 'pm_month';
			$this->PointUser->create();
			if(!$this->PointUser->save($PointUser)){
				$this->log('PmUser.php userTying error. '.print_r($PointUser, true), 'emergency');
			}
	    }
	    return $PmUser;
    }
    

}
