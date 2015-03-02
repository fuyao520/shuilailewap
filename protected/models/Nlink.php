<?php
class Nlink extends CActiveRecord{
	public function tableName() {
		return '{{nlink}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
