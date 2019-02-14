<?php 

class PmUsersController extends PointManagerAppController {
  
  public $name = 'PmUsers';

  public $uses = array('PointManager.Pmpage','PointManager.PmUser', 'siteConfig', 'Point.PointUser', 'Members.Mypage', 'Point.PointBook');
  
  public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];


  public function beforeFilter() {
    parent::beforeFilter();
  
  }
  
  public function admin_index($pmpage_id){
	$conditions = array('PmUser.pmpage_id' => $pmpage_id);
	$this->paginate = array('conditions' => $conditions,
	  'limit' => 50
	);
	$PmUsers = $this->paginate('PmUser');
	$Pmpage = $this->Pmpage->findById($pmpage_id);
	$name = $Pmpage['Pmpage']['company_name'].' '.$Pmpage['Mypage']['name'];
	$this->pageTitle = $name.' ユーザー一覧';
	foreach($PmUsers as $key=>$val){
		$PmUsers[$key]['PointUser'] = $this->PointUser->findByMypageId($val['Mypage']['id'], null, null, -1)['PointUser'];
	}
	$this->set('PmUsers', $PmUsers);
  }
  
  //ユーザー一覧
  //退会しても、ポイント精算が残っている場合は表示される。
  public function index(){
	$user = $this->BcAuth->user();
	if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	$pmpage_id = $this->Pmpage->mypageToPmpage($user['id']);;
	$conditions = [];
	$conditions[] = array('PmUser.pmpage_id' => $pmpage_id);
	$this->paginate = array('conditions' => $conditions,
      'order' => 'PmUser.mypage_id ASC',
      'limit' => 20
    );
    $pmusers = $this->paginate('PmUser');
    foreach($pmusers as $key=>$user){
	    $point = $this->PointUser->findByMypageId($user['Mypage']['id'], null, null, -1);
	    $pmusers[$key]['PointUser'] = $point['PointUser'];
    }
    $this->set('pmusers', $pmusers);
  }
  
  //ユーザー新規追加
  public function add(){
	  //$user = $this->Session->read('BcAuth');
	  $user = $this->BcAuth->user();
	  if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	  $this->pageTitle = 'ユーザー追加';
	  if(!empty($this->request->data)){
		  $data = $this->request->data;
		  if($data['Mypage']['password_auto'] == '1'){
			  $password = $this->generatePassword(6);
			  $data['Mypage']['password'] = $password;
			  $data['Mypage']['password_confirm'] = $password;
		  }
		  $data = $this->PmUser->userAdd($data, $user['id']);
		  $data['Admin'] = $user;
		  if($data){
			  unset($this->request->data);
			  $siteName = $this->siteConfig->findByName('name')['SiteConfig']['value'];
			  $this->sendMail($data['Mypage']['email'], '[登録完了]'.$siteName, $data, array('template'=>'PointManager.user_add', 'layout'=>'default'));
			  $this->sendMail($user['email'], '[登録完了]'.$siteName, $data, array('template'=>'PointManager.user_add', 'layout'=>'default'));
			  $this->setMessage( $data['Mypage']['name'].'さんを登録、メールを送信しました。続けて登録できます。');
		  }else{
			  $this->setMessage('エラー', true);
		  }
	  }
  }
  
  public function edit($id = null){
	  if($id == null ) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	  $user = $this->BcAuth->user();
	  if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
	  $this->pageTitle = 'ユーザー編集';
	  if($this->request->data){
		  $data = $this->request->data;
		  if($data['Mypage']['delete'] == '1'){
			  if($this->PmUser->user_delete($data)){
				  $this->setMessage( $data['Mypage']['name'].'さんを削除しました。');
				  $this->redirect(array('plugin' => 'point_manager', 'controller' => 'pm_users', 'action' => 'index'));
			  }else{
				  $this->setMessage('エラー：PmUsersController.php function edit delete error.', true);
				  $this->redirect(array('plugin' => 'point_manager', 'controller' => 'pm_users', 'action' => 'index'));
			  }
		  }else{
			  if(empty($data['Mypage']['password'])){
				  unset($data['Mypage']['password']);
			  }
			  if($this->Mypage->save($data)){
				  $this->setMessage( $data['Mypage']['name'].'さんを編集しました。');
				  $this->redirect(array('plugin' => 'point_manager', 'controller' => 'pm_users', 'action' => 'index'));
			  }else{
				  $this->setMessage('エラー：', true);
			  }
		  }
	  }else{
		  $pmuser = $this->PmUser->findByMypageId($id);
		  unset($pmuser['Mypage']['password']);
		  $this->request->data = $pmuser;
	  }
	  
  }
  
  public function point_book($ym = null){
	  $user = $this->BcAuth->user();
	  if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
      $PmUsers = $this->PmUser->findAllByPmpageId($user['id'], null, null, -1);
      $conditions = [];
      foreach($PmUsers as $PmUser){
	      $conditions['OR'][] = ['PointBook.mypage_id' => $PmUser['PmUser']['mypage_id']];
      }
      if($ym === null){
	      $ym = date('Ym');
      }
      $year = substr($ym, 0, 4);
	  $month = substr($ym, 4, 2);
      $conditions[] = ['PointBook.created >=' => date('Y-m-d', strtotime('first day of ' .$year.'-'.$month))];
      $conditions[] = ['PointBook.created <=' => date('Y-m-d', strtotime('last day of ' .$year.'-'.$month))];
      $books = $this->PointBook->find('all', [
	      'conditions' => $conditions,
	      'order' => 'PointBook.created DESC',
	      'recursive' => 1,
      ]);
      $this->set('now_date', date('Y年n月', strtotime(date($year.'-'.$month))));
      $this->set('ym', $ym);
	  $this->set('books', $books);
  }
  
  public function download($ym = null){
	  $user = $this->BcAuth->user();
	  if($this->Pmpage->isNotPmpage($user['id'])) $this->redirect(array('plugin' => 'members', 'controller' => 'mypages', 'action' => 'index'));
      $PmUsers = $this->PmUser->findAllByPmpageId($user['id'], null, null, -1);
      $conditions = [];
      foreach($PmUsers as $PmUser){
	      $conditions['OR'][] = ['PointBook.mypage_id' => $PmUser['PmUser']['mypage_id']];
      }
      if($ym === null){
	      $ym = date('Ym');
      }
      $year = substr($ym, 0, 4);
	  $month = substr($ym, 4, 2);
      $conditions[] = ['PointBook.created >=' => date('Y-m-d', strtotime('first day of ' .$year.'-'.$month))];
      $conditions[] = ['PointBook.created <=' => date('Y-m-d', strtotime('last day of ' .$year.'-'.$month))];
      $books = $this->PointBook->find('all', [
	      'conditions' => $conditions,
	      'order' => 'PointBook.created DESC',
	      'recursive' => 1,
      ]);
      $this->autoRender = false;
      $this->response->type('csv');
      $this->response->download($ym.".csv");
      $fp = fopen('php://output','w');
      stream_filter_append($fp, 'convert.iconv.UTF-8/CP932', STREAM_FILTER_WRITE);
      $head = ['Date', 'No.', 'Name', 'Action', 'Point', 'Total'];
      fputcsv($fp, $head);
      foreach($books as $book){
	      $output = [];
	      $output['Date'] = $book['PointBook']['created'];
	      $output['No.'] = $book['PointBook']['mypage_id'];
	      $output['Name'] = $book['Mypage']['name'];
	      $output['Action'] = $book['PointBook']['reason'];
	      $output['Point'] = number_format($book['PointBook']['point']);
	      $output['Total'] = number_format($book['PointBook']['point_balance']);
		  fputcsv($fp, $output);
	  }
      fclose($fp);
  }
  

}

