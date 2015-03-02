<?php
class InfoSpecialRelation extends CActiveRecord{
	public function tableName() {
		return '{{info_special_relation}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	

	
}
