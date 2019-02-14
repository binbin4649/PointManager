<?php 

class PmconfigsController extends PointManagerAppController {
  
  public $name = 'Pmconfigs';

  public $uses = array('PointManager.Pmconfig');
  
  public $components = ['BcAuth', 'Cookie', 'BcAuthConfigure'];
  
  public function admin_edit(){
	  if($this->request->data){
		  if($this->Pmconfig->save($this->request->data)){
			  $this->setMessage('Pmconfig を更新しました。');
		  }else{
			  $this->setMessage('Pmconfig の更新に失敗しました。', true);
		  }
		  $this->redirect(['controller'=>'pmpages', 'action'=>'index']);
	  }else{
		  $this->request->data = $this->Pmconfig->find('first', []);
	  }
  }

}

