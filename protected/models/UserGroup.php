<?php
class UserGroup extends CActiveRecord{
	public function tableName() {
		return '{{user_group}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
