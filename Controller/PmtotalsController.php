<?php 

class PmtotalsController extends PointManagerAppController {
  
  public $name = 'Pmtotals';

  public $uses = array('PointManager.Pmtotal', 'PointManager.Pmpage');
  
  public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];
  
  public function admin_index(){
	$this->pageTitle = '請求一覧';
	$conditions = [];
	if ($this->request->is('post')){
      $data = $this->request->data;
      if($data['Pmtotal']['mypage_id']) $conditions[] = array('Pmtotal.mypage_id' => $data['Pmtotal']['mypage_id']);
      if($data['Pmtotal']['status']) $conditions[] = array('Pmtotal.status' => $data['Pmtotal']['status']);
    }
    //$conditions[] = array('Mypage.status' => 0);
    $this->paginate = array('conditions' => $conditions,
      'order' => 'Pmtotal.id DESC',
      'limit' => 50
    );
    //$this->PointUser->unbindModel(['hasMany' => ['PointBook']]);
    $Pmtotal = $this->paginate('Pmtotal');
    $this->set('Pmtotal', $Pmtotal);
    $this->set('status', Configure::read('pointManagerPlugin.PmtotalStatus'));
  }
  
  public function admin_edit($id){
	  $this->pageTitle = 'Pmtotal 編集';
	  if(!empty($this->request->data)){
		  if($this->Pmtotal->save($this->request->data)){
	        $this->setMessage( '編集しました。');
	        $this->redirect(array('action' => 'index'));
	      }else{
	        $this->setMessage('エラー', true);
	      }
	  }else{
		  $this->request->data = $this->Pmtotal->findById($id);
	  }
	  $this->set('status', Configure::read('pointManagerPlugin.PmtotalStatus'));
	  $UserTotals = $this->Pmtotal->toUserTotals($id);
	  $this->set('UserTotals', $UserTotals);
  }
  
  public function index(){
	$user = $this->BcAuth->user();
	if($this->Pmpage->isNotPmpage($user['id'])){
		$this->setMessage('請求先に指定されているアカウントのみ参照できます。', true);
		$this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	}
	$conditions = [];
	$conditions[] = array('Pmtotal.mypage_id' => $user['id']);
	$conditions[] = array('Pmtotal.status <>' => 'delete');
	$this->paginate = array('conditions' => $conditions,
      'order' => 'Pmtotal.created DESC',
      'limit' => 20
    );
    $Pmtotals = $this->paginate('Pmtotal');
	$this->set('Pmtotals', $Pmtotals);
  }
  

}

