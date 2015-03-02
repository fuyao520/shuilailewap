<?php
class User extends CActiveRecord{
	public function tableName() {
		return '{{user_list}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function password_encryption($str){
		$re=md5(md5(md5($str)));
		return $re;
	}

	//检查email是否存在,0 表示不存在，其他 返回  用户的数据
	function get_user_uphone_info($uphone=''){
		global $dbm;
		$sql="select  * from user_list where uphone='$uphone'  ";
		$rsu['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rsu['list'])==0){
			return 0;
		}
		return $rsu['list'][0];
	}
	//检查email是否存在,0 表示不存在，其他 返回  用户的数据
	function get_user_uname_info($uname=''){
		global $dbm;
		$sql="select  * from user_list where uname='$uname'  ";
		$rsu['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rsu['list'])==0){
			return 0;
		}
		return $rsu['list'][0];
	}
	//检查email是否存在,0 表示不存在，其他 返回  用户的数据
	function get_user_email_info($email=''){
		$sql="select * from user_list where uemail='$email'  ";
		$rsu['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rsu['list'])==0){
			return 0;
		}
		return $rsu['list'][0];
	}
	//登陆
	public function login($uname){
		
	}
	
	//注册新用户
	public function reg_new($uphone,$uname,$email,$upass,$group_id,$uqq){
		/***返回结果 -4用户名不合法，-3email不合法, -2 用户名已被注册 ,-1 邮箱已被注册,-5 密码 不合法，其他 为注册成功，用户的id **/
		/*
		if(verify::check_mobile($uphone)==0){
			return -7;
		}
		*/
		if(verify::check_username($uname)==0){
			return -4;
		}
		if(verify::check_email($email)==0){
			return -3;
		}
		if(verify::check_password($upass)==0){
			return -5;
		}
		/*
		if($this->get_user_uphone_info($uphone)>0){
			return -6;
		}
		*/
	    if($this->get_user_uname_info($uname)>0){
			return -2;
		}
		if($this->get_user_email_info($email)>0){
		    return -1;
		}
		$reg_time=time();
		$upass=$this->password_encryption($upass);
	    //$expire_date=$reg_time+60*60;
		$reg_ip=$_SERVER['REMOTE_ADDR'];
		$m=new User();
		$m->uphone=$uphone;
		$m->uname=$uname;
		$m->upass=$upass;
		$m->uemail=$email;
		$m->uqq=$uqq;
		$m->reg_date=$reg_time;
		$m->group_id=$group_id;
		$m->reg_ip=$reg_ip;
		$m->save();
		$insert_id=$m->primaryKey;
		return $insert_id;	
				
	}

}
