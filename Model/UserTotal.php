<?php
App::import('Model', 'AppModel');

class UserTotal extends AppModel {

	public $name = 'UserTotal';
    
    
    //ユーザー単位で、今月のマイナスポイントを精算、UserTotalを作成
    //退会しているユーザーが居たら、PmUserを削除
    public function userPayOff(){
	    $PmUserModel = ClassRegistry::init('PointManager.PmUser');
	    $PmUsers = $PmUserModel->find('all', []);
	    var_dump($PmUsers);
	    die;
	    
    }
    

}
