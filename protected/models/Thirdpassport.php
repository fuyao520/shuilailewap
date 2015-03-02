<?php
class Thirdpassport extends CActiveRecord{
	public function tableName() {
		return '{{user_thirdpassport}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
