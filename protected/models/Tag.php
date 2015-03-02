<?php
class Tag extends CActiveRecord{
	public function tableName() {
		return '{{tag}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
