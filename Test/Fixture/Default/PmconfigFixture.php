<?php

class PmconfigFixture extends CakeTestFixture {
	
	public $import = array('model' => 'PointManager.Pmconfig');

	public function init(){
		$this->records = [
			[
				'id' => 1,
				'client_id' => '13079033563764',
				'client_secret' => 'wayyNDtT74UA2NF-vXC2D_jM3AJ3GCbMLaYGRn3rUmHiSllcl08ct1SLLtK2336gJ5ySg3RTheyWQfiqarkMwQ',
				'refresh_token' => 'sX66IfE4r_y2-BAzduwgY1G4cu5x-XsVbnDQOkV4mZk',
				'access_token' => 'wqvteZsdOh07Q-HiqxFlWi8LcNZtk7OjlWHSrE37VGk',
				'created' => date('Y-m-d H:i:s'),
				'modified' => date('Y-m-d H:i:s')
			]
		];
		parent::init();
	}
	

}