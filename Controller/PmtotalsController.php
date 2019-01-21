<?php 

class PmtotalsController extends PointManagerAppController {
  
  public $name = 'Pmtotals';

  public $uses = array('PointManager.Pmtotal', 'PointManager.Pmpage');
  
  public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];
  
  public function index(){
	$user = $this->BcAuth->user();
	if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	$conditions = [];
	$conditions[] = array('Pmtotal.mypage_id' => $user['id']);
	$this->paginate = array('conditions' => $conditions,
      'order' => 'Pmtotal.created ASC',
      'limit' => 20
    );
    $Pmtotals = $this->paginate('Pmtotal');
	$this->set('Pmtotals', $Pmtotals);
  }
  

}

