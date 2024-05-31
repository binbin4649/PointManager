<?php

class PmconfigFixture extends CakeTestFixture {
	
	public $import = array('model' => 'PointManager.Pmconfig');

	public function init(){
		$this->records = [
			[
				'id' => 1,
				'client_id' => '13079033563764',
				'client_secret' => 'wayyNDtT74UA2NF-vXC2D_jM3AJ3GCbMLaYGRn3rUmHiSllcl08ct1SLLtK2336gJ5ySg3RTheyWQfiqarkMwQ',
				'refresh_token' => '7gYxkhBs3isEqMYxpqMfDwcLruoqcEEDKwFkAexrJJ0',
				'access_token' => 'GGzrO63Mq2fz3jT2yZDYAwfoCV_-o6afVVcPrddZXGI',
				'created' => '2024-05-30 18:19:48',
				'modified' => '2024-05-30 18:19:48'
			]
		];
		parent::init();
	}
	

}