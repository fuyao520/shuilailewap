<?php
class PmList extends CActiveRecord{
	public function tableName() {
		return '{{pm_list}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function get_unread_total($uid){
		$sql="select count(*) as total from pm_list as a left join pm_read as b on b.uid=a.uid_recv and b.pm_id=a.pm_id where uid_recv=$uid and read_date is null";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a[0]['total'];
	}

}
