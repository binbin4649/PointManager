<?php 

class UserTotalsController extends PointManagerAppController {
  
  public $name = 'UserTotals';

  public $uses = array('PointManager.UserTotal', 'PointManager.Pmpage', 'PointManager.Pmtotal', 'Members.Mypage');
  
  public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];
  
  public function index($mypage_id){
	$user = $this->BcAuth->user();
	if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	$conditions = [];
	$conditions[] = array('UserTotal.mypage_id' => $mypage_id);
	$this->paginate = array('conditions' => $conditions,
      'order' => 'UserTotal.created DESC',
      'limit' => 20
    );
    $UserTotals = $this->paginate('UserTotal');
	$this->set('UserTotals', $UserTotals);
	$this->set('Mypage', $this->Mypage->findById($mypage_id, null, null, -1));
  }
  
  public function detail($ym = null){
	$user = $this->BcAuth->user();
	if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	if($ym === null) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	$pmpage_id = $this->Pmpage->mypageToPmpage($user['id']);
	//$UserTotals = $this->UserTotal->fromPmpageId($pmpage_id, $ym);
	$UserTotals = $this->UserTotal->unFinish($pmpage_id);
	$Pmtotal = $this->Pmtotal->fromPmpageId($pmpage_id, $ym);
	$this->set('UserTotals', $UserTotals);
	$this->set('Pmtotal', $Pmtotal);
  }

}

