<?php
class UserFans extends CActiveRecord{
	public function tableName() {
		return '{{user_fans}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	//获取某个用户的关注总数
	public static function get_follow_total($uid){
		$sql="select count(*)  as total from user_fans where uid=$uid";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return intval($a[0]['total']);
	
	}
	
	//获取某个用户的粉丝的总数
	public static function get_fans_total($uid){
		$sql="select count(*)  as total from user_fans where uid2=$uid";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return intval($a[0]['total']);
	
	}

}
