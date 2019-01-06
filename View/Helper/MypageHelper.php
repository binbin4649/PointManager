<?php
	
App::import('Vendor', 'Members.Mobile-Detect/Mobile_Detect');

class MypageHelper extends BcAppHelper {
	
	public function mobileDetect() {
		$detect = new Mobile_Detect;
		if ($detect->isiOS()) {
			$deviceType = 'ios';
		}elseif($detect->isAndroidOS()){
			$deviceType = 'android';
		}else{
			$deviceType = 'other';
		}
		return $deviceType;
	}
	
}