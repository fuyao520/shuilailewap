<?php
class InfoPhoto extends CActiveRecord{
	public function tableName() {
		return '{{info_photo}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public static function get_total($uid){
		$sql="select count(*)  as total from info_photo where uid=$uid";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return intval($a[0]['total']);
	
	}

}
