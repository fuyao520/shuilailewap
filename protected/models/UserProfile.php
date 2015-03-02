<?php
class UserProfile extends CActiveRecord{
	public function tableName() {
		return '{{user_extern}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
