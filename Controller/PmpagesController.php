<?php 

class PmpagesController extends PointManagerAppController {
  
  public $name = 'Pmpages';

  public $uses = array('PointManager.Pmpage', 'Members.Mypage', 'PointManager.PmUser');
  
  public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];

  public $crumbs = array(
    array('name' => 'マイページトップ', 'url' => array('controller' => 'Pmpages', 'action' => 'index')),
  );

  public function beforeFilter() {
    parent::beforeFilter();
  
  }
  
  // PMユーザー一覧
  public function admin_index(){
	$this->pageTitle = 'PM会員一覧';
	$conditions = [];
	if ($this->request->is('post')){
      $data = $this->request->data;
      if($data['Pmpage']['mypage_id']) $conditions[] = array('Pmpage.mypage_id' => $data['Pmpage']['mypage_id']);
      if($data['Mypage']['name']) $conditions[] = array('Mypage.name like' => '%'.$data['Mypage']['name'].'%');
    }
    $conditions[] = array('Mypage.status' => 0);
    $this->paginate = array('conditions' => $conditions,
      'order' => 'Pmpage.id DESC',
      'limit' => 50
    );
    //$this->PointUser->unbindModel(['hasMany' => ['PointBook']]);
    $Pmpage = $this->paginate('Pmpage');
    $this->set('Pmpage', $Pmpage);
  }
  
  // PM新規追加、mypage以下も生成する
  public function admin_add(){
	  $this->pageTitle = 'PM 新規追加';
	  if(!empty($this->request->data)){
		  if($this->Pmpage->signUp($this->request->data)){
	        $this->setMessage( '登録しました。');
	        $this->redirect(array('action' => 'index'));
	      }else{
	        $this->setMessage('エラー', true);
	      }
	  }
	  $this->set('prefecture', Configure::read('pointManagerPlugin.prefecture'));
	  $this->render('form');
  }
  
  // to associate, PM既存紐付、既存mypageをpmに紐付ける
  public function admin_ass(){
	  $this->pageTitle = 'PM 既存紐付';
	  if(!empty($this->request->data)){
		  if($this->Pmpage->toAss($this->request->data)){
	        $this->setMessage( '登録しました。');
	        $this->redirect(array('action' => 'index'));
	      }else{
	        $this->setMessage('エラー', true);
	      }
	  }
	  $this->set('prefecture', Configure::read('pointManagerPlugin.prefecture'));
  }
  
  // PMユーザー編集
  public function admin_edit($id){
	  $this->pageTitle = 'PM 編集';
	  if(!empty($this->request->data)){
		  if($this->Pmpage->editSave($this->request->data)){
	        $this->setMessage( '編集しました。');
	      }else{
	        $this->setMessage('エラー', true);
	      }
	  }else{
		  $this->request->data = $this->Pmpage->findById($id);
	  }
	  $this->set('prefecture', Configure::read('pointManagerPlugin.prefecture'));
	  $this->render('form');
  }
  
  // PMと既存ユーザーを任意ヒモ付け
  public function admin_user_add($id){
	  $this->pageTitle = 'PM 既存ユーザー紐付け';
	  if(!empty($this->request->data)){
		  $data = $this->request->data;
		  if(empty($data['Pmpage']['add_user'])){
			  $this->setMessage('エラー:会員番号を入力', true);
		  }elseif($this->PmUser->isExtUserTying($data)){
			  $this->setMessage('エラー:登録済み（紐付け済み）', true);
		  }else{
			  if($this->PmUser->userTying($data)){
				  $this->setMessage( '登録しました。');
				  $this->redirect(array('action' => 'index'));
			  }else{
				  $this->setMessage('エラー:', true);
			  }
		  }
	  }
	  $this->set('Mypage', $this->Mypage->findById($id, null, null, -1));
  }
  
  // 管理者編集
  public function edit(){
	  $user = $this->BcAuth->user();
	  if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	  if(!empty($this->request->data)){
		  if($this->Pmpage->editSave($this->request->data)){
	        $this->setMessage( '管理者情報を編集しました。');
	        $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	      }else{
	        $this->setMessage('エラー', true);
	      }
	  }else{
		  $pmpage = $this->Pmpage->findByMypageId($user['id']);
		  unset($pmpage['Mypage']['password']);
		  $this->request->data = $pmpage;
	  }
	  $this->set('prefecture', Configure::read('pointManagerPlugin.prefecture'));
  }
  
  
  
  
  

}

