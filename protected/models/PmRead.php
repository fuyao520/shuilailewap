<?php
class PmRead extends CActiveRecord{
	public function tableName() {
		return '{{pm_read}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
