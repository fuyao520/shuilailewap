<?php
class UserOrder extends CActiveRecord{
	public function tableName() {
		return '{{user_order}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
