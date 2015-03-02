<?php
class AdArea extends CActiveRecord{
	public function tableName() {
		return '{{ad_area}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
