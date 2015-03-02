<?php
class VerifyCodeController extends UserController{
	public function actionIndex(){
		$type=isset($_GET['type'])?$_GET['type']:'';
		//特定的 session key
		$allow_type=array(
				'get_rancode'=>'rancode',
				'get_login_rancode'=>'login_rancode',
				'get_reg_rancode'=>'reg_rancode',
				'get_forgetpassword_rancode'=>'forgetpassword_rancode',
				'get_cellphone_rancode'=>'cellphone_rancode'
		);
		if(!isset($allow_type[$type])){
			$type='get_rancode';
			//$this->msg(array('state'=>-2,'msgwords'=>'不被允许'));
		}
		$session_name=$allow_type[$type];
		helper::verify_code($session_name);
	}
}