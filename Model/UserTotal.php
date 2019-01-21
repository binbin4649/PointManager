<?php
App::import('Model', 'AppModel');

class UserTotal extends AppModel {

	public $name = 'UserTotal';
    
    
    //ユーザー単位に精算
    public function userPayOff(){
	    $PmUserModel = ClassRegistry::init('PointManager.PmUser');
	    $PointUserModel = ClassRegistry::init('Point.PointUser');
	    $PmUsers = $PmUserModel->find('all', []);
	    $ym = date('Y-m-t');//今月
	    $UserTotals = [];
	    foreach($PmUsers as $PmUser){
		    $PointUser = $PointUserModel->findByMypageId($PmUser['Mypage']['id'], null, null, -1);
		    //ユーザー単位で、今月のマイナスポイントを精算、UserTotalを作成
		    if($PointUser['PointUser']['point'] < 0){
			    $datasource = $this->getDataSource();
			    try{
				    $datasource->begin();
				    $total = abs($PointUser['PointUser']['point']);
				    $UserTotal = [];
				    $UserTotal['UserTotal'] = [
					    'pm_user_id' => $PmUser['PmUser']['id'],
					    'pmpage_id' => $PmUser['Pmpage']['id'],
					    'mypage_id' => $PmUser['Mypage']['id'],
					    'name' => $PmUser['Mypage']['name'],
					    'yyyymm' => $ym,
					    'total' => $total
				    ];
				    $UserTotals[] = $UserTotal;
				    $this->create();
				    if(!$this->save($UserTotal)) throw new Exception();
				    $user_total_id = $this->getLastInsertId();
				    $point_add_data = [];
				    $point_add_data = [
				    	'mypage_id' => $PmUser['Mypage']['id'],
				    	'point' => $total,
				    	'reason' => 'invoice',
				    	'reason_id' => $user_total_id
				    ];
				    if(!$PointUserModel->pointAdd($point_add_data)) throw new Exception();
				    $datasource->commit();
			    }catch(Exception $e){
				    $datasource->rollback();
				    $this->log('UserTotal.php UserPayOff error. : ');
			    }
		    }
		    //退会しているユーザーが居たら、PmUserを削除
		    if($PmUser['Mypage']['status'] == '2'){
			    $this->delete($PmUser['PmUser']['id']);
		    }
	    }
	    if(empty($UserTotals)){
		    return false;
	    }else{
		    return $UserTotals;
	    }
    }
    
    // その他の明細があれば精算（テーブル作成）。月額保守とか、
    public function otherPayOff(){
	    $PmpageModel = ClassRegistry::init('PointManager.Pmpage');
	    $Pmpages = $PmpageModel->find('all', [
	    	'conditions' => [
	    		'Mypage.status !=' => '2'
	    	]
	    ]);
	    $UserTotals = [];
	    $ym = date('Y-m-t');//今月
	    foreach($Pmpages as $Pmpage){
		    if(!empty($Pmpage['Pmpage']['other_payoff_name1']) and !empty($Pmpage['Pmpage']['other_payoff_total1'])){
			    $UserTotal = [];
			    $UserTotal['UserTotal'] = [
				    'pmpage_id' => $Pmpage['Pmpage']['id'],
				    'name' => $Pmpage['Pmpage']['other_payoff_name1'],
				    'yyyymm' => $ym,
				    'total' => $Pmpage['Pmpage']['other_payoff_total1']
			    ];
			    $this->create();
			    if($this->save($UserTotal)){
				    $UserTotals[] = $UserTotal;
			    }
		    }
		    if(!empty($Pmpage['Pmpage']['other_payoff_name2']) and !empty($Pmpage['Pmpage']['other_payoff_total2'])){
			    $UserTotal = [];
			    $UserTotal['UserTotal'] = [
				    'pmpage_id' => $Pmpage['Pmpage']['id'],
				    'name' => $Pmpage['Pmpage']['other_payoff_name2'],
				    'yyyymm' => $ym,
				    'total' => $Pmpage['Pmpage']['other_payoff_total2']
			    ];
			    $this->create();
			    if($this->save($UserTotal)){
				    $UserTotals[] = $UserTotal;
			    }
		    }
	    }
	    return $UserTotals;
    }
    
    
    public function forwardToUserTotal(){
	    $PmtotalModel = ClassRegistry::init('PointManager.Pmtotal');
	    $prev_ym = date('Y-m-d', strtotime('last day of previous month'));
	    $ym = date('Y-m-t');//今月
	    $UserTotals = [];
	    $Pmtotals = $PmtotalModel->find('all', [
	    	'conditions' => [
	    		'Pmtotal.status' => 'forward',
	    		'Pmtotal.yyyymm' => $prev_ym
	    	]
	    ]);
	    foreach($Pmtotals as $Pmtotal){
		    $prev_date = date('Y-m', strtotime('last day of previous month'));
		    $name = $prev_date.' 繰越分';
		    $UserTotal = [];
		    $UserTotal['UserTotal'] = [
			    'mypage_id' => $Pmtotal['Pmtotal']['mypage_id'],
			    'pmpage_id' => $Pmtotal['Pmtotal']['pmpage_id'],
			    'name' => $name,
			    'yyyymm' => $ym,
			    'total' => $Pmtotal['Pmtotal']['total']
		    ];
		    $this->create();
		    if($this->save($UserTotal)){
			    $UserTotals[] = $UserTotal;
		    }
	    }
	    return $UserTotals;
    }
    
    
    

}
