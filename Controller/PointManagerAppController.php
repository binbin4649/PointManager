<?php
/*
* 基底コントローラー
*/

/**
* Include files
*/
App::uses('AppController', 'Controller');

/**
* 基底コントローラー
*
* 
*/
class PointManagerAppController extends AppController {

	public function beforeFilter() {
	  parent::beforeFilter();
	  
	  if (preg_match('/^admin_/', $this->action)) {
	  	$this->subMenuElements = array('point_manager');
	  }
	  
	}
}
