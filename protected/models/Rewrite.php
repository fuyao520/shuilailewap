<?php
class Rewrite extends CActiveRecord{
	public function tableName() {
		return '{{rewrite}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
