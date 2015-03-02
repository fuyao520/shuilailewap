<?php
class TaskController extends HomeController{
	public function actionIndex(){
		echo 'hi';
		echo helper::get_curl_contents('http://zzzzjsdkfkjsdkfjskdfj.com');
		die('hehe');
	}
	public function actionPolling(){
		$this->OrderEnd();
	}
	private function OrderEnd(){
		
		echo 'order end!'.chr(10);
	}
	
	
	
}