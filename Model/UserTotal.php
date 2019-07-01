<?php
App::import('Model', 'AppModel');

class UserTotal extends AppModel {

	public $name = 'UserTotal';
    
    // pmpage_id と yyyymm で紐付いてる userTotal を返す
    public function fromPmpageId($pmpage_id, $yyyymm){
	    if(empty($pmpage_id)){
		    return false;
	    }
	    $this->Pmtotal = ClassRegistry::init('PointManager.Pmtotal');
	    $date = $this->Pmtotal->lastDay($yyyymm);
	    $UserTotals = $this->find('all', [
	    	'conditions' => [
	    		'UserTotal.pmpage_id' => $pmpage_id,
	    		'UserTotal.yyyymm' => $date,
	    	]
	    ]);
	    return $UserTotals;
    }
    
    //ユーザー単位に精算
    public function userPayOff(){
	    $PmUserModel = ClassRegistry::init('PointManager.PmUser');
	    $PointUserModel = ClassRegistry::init('Point.PointUser');
	    $PmUsers = $PmUserModel->find('all', []);
	    $UserTotals = [];
	    foreach($PmUsers as $PmUser){
		    $conf_total = 0;
		    $PointUser = $PointUserModel->findByMypageId($PmUser['Mypage']['id'], null, null, -1);
		    //ユーザー単位で、今月のマイナスポイントを精算、UserTotalを作成
		    if($PointUser['PointUser']['point'] < 0){
			    $totals = $this->itemPayOff($PmUser);
			    foreach($totals as $UserTotal){
				    $UserTotals[] = $UserTotal;
				    $conf_total = $conf_total + $UserTotal['UserTotal']['total'];
			    }
			    $total = abs($PointUser['PointUser']['point']);
			    //個別計算と合っているか？確認
			    if($total == $conf_total){
				    $point_add_data = [];
				    $point_add_data = [
				    	'mypage_id' => $PmUser['Mypage']['id'],
				    	'point' => $total,
				    	'reason' => 'invoice'
				    ];
				    if(!$PointUserModel->pointAdd($point_add_data)){
					    $this->log('UserTotal.php itemPayOff userPayOff pointAdd error. : '.print_r($point_add_data, true), 'emergency');
				    }
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
    
    //poinnt_books をpointとreasonごとに集計してUsertotalにする
	public function itemPayOff($PmUser){
		if(!empty($PmUser['Mypage']['id'])){
			$mypage_id = $PmUser['Mypage']['id'];
		}elseif(!empty($PmUser['Pmpage']['mypage_id'])){
			$mypage_id = $PmUser['Pmpage']['mypage_id'];
		}elseif(!empty($PmUser['PmUser']['mypage_id'])){
			$mypage_id = $PmUser['PmUser']['mypage_id'];
		}
		if(!empty($PmUser['PmUser']['id'])){
			$pm_user_id = $PmUser['PmUser']['id'];
		}else{
			$pm_user_id = null;
		}
		if(!empty($PmUser['Pmpage']['id'])){
			$pmpage_id = $PmUser['Pmpage']['id'];
		}elseif(!empty($PmUser['PmUser']['pmpage_id'])){
			$pmpage_id = $PmUser['PmUser']['pmpage_id'];
		}
		$UserTotals = [];
		$ym = date('Y-m-t');//今月末
		$mypage_name = mb_substr($PmUser['Mypage']['name'], 0, 15);
		$PointBookModel = ClassRegistry::init('Point.PointBook');
		$monthlyTotal = $PointBookModel->monthlyTotalByPlan(null, [$mypage_id]);
		foreach($monthlyTotal as $key=>$i){
			$unit = explode(':', $key);
			$this_month = '様('.date('m').'月:'.$unit[0].')';//今月名
			$total = $unit[1] * $i;
			$UserTotal['UserTotal'] = [
			    'pm_user_id' => $pm_user_id,
			    'pmpage_id' => $pmpage_id,
			    'mypage_id' => $mypage_id,
			    'name' => $mypage_name.$this_month,
			    'yyyymm' => $ym,
			    'quantity' => $i,
			    'unit_price' => $unit[1],
			    'total' => $total,
			    'status' => 'before'
		    ];
		    $this->create();
		    if(!$this->save($UserTotal)){
			    $this->log('UserTotal.php itemPayOff save error. : '.print_r($UserTotal, true), 'emergency');
		    }
		    $UserTotals[] = $UserTotal;
		}
		return $UserTotals;
	}
    
    // Pmpage本人のPointも精算、nosではこちらがメイン
    public function pmPayOff(){
	    $PmpageModel = ClassRegistry::init('PointManager.Pmpage');
	    $PointUserModel = ClassRegistry::init('Point.PointUser');
	    $Pmpages = $PmpageModel->find('all', ['conditions' => ['Mypage.status <>' => '2']]);
	    $UserTotals = [];
	    foreach($Pmpages as $Pmpage){
		    $conf_total = 0;
		    $PointUser = $PointUserModel->findByMypageId($Pmpage['Pmpage']['mypage_id'], null, null, -1);
		    if($PointUser['PointUser']['point'] < 0){
			    $totals = $this->itemPayOff($Pmpage);
			    foreach($totals as $UserTotal){
				    $UserTotals[] = $UserTotal;
				    $conf_total = $conf_total + $UserTotal['UserTotal']['total'];
			    }
			    $total = abs($PointUser['PointUser']['point']);
			    if($total == $conf_total){
				    $point_add_data = [];
				    $point_add_data = [
				    	'mypage_id' => $Pmpage['Pmpage']['mypage_id'],
				    	'point' => $total,
				    	'reason' => 'invoice'
				    ];
				    if(!$PointUserModel->pointAdd($point_add_data)){
					    $this->log('UserTotal.php itemPayOff pmPayOff pointAdd error. : '.print_r($point_add_data, true), 'emergency');
				    }
			    }
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
				    'name' => $Pmpage['Pmpage']['other_payoff_name1'].'('.date('m').'月)',
				    'yyyymm' => $ym,
				    'quantity' => 1,
				    'unit_price' => $Pmpage['Pmpage']['other_payoff_total1'],
				    'total' => $Pmpage['Pmpage']['other_payoff_total1'],
				    'status' => 'before'
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
				    'name' => $Pmpage['Pmpage']['other_payoff_name2'].'('.date('m').'月)',
				    'yyyymm' => $ym,
				    'quantity' => 1,
				    'unit_price' => $Pmpage['Pmpage']['other_payoff_total2'],
				    'total' => $Pmpage['Pmpage']['other_payoff_total2'],
				    'status' => 'before'
			    ];
			    $this->create();
			    if($this->save($UserTotal)){
				    $UserTotals[] = $UserTotal;
			    }
		    }
	    }
	    return $UserTotals;
    }
    
    
    //きっと要らない
    public function forwardToUserTotal(){
	    $PmtotalModel = ClassRegistry::init('PointManager.Pmtotal');
	    $prev_ym = date('Y-m-d', strtotime('last day of previous month'));//先月
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
