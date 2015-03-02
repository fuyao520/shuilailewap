<?php
class UserLogin extends CActiveRecord{
	public function tableName() {
		return '{{user_login}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
