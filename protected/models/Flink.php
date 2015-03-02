<?php
class Flink extends CActiveRecord{
	public function tableName() {
		return '{{flink}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
