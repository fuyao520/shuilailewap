<?php
class Collector extends CActiveRecord{
	public function tableName() {
		return '{{collector}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	
}