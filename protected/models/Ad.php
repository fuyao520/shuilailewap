<?php
class Ad extends CActiveRecord{
	public function tableName() {
		return '{{ad_list}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
