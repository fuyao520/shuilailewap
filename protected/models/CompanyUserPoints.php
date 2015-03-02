<?php
class CompanyUserPoints extends CActiveRecord{
	public function tableName() {
		return '{{company_user_points}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public static function get_total($uid){
		$sql="select sum(points) as total from company_user_points where uid=$uid";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return intval($a[0]['total']);
	
	}

}
