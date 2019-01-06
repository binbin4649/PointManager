<?php

class PointManagerAllModelTest extends CakeTestSuite {

	public static function suite() {
		$suite = new CakeTestSuite('All model tests');
		$path = dirname(__FILE__) . DS;
		$suite->addTestDirectory($path . 'Model' . DS);
		$suite->addTestDirectory($path . 'Model' . DS . 'Behavior' . DS);
		return $suite;
	}
	
}