<?php
class AdminGroup extends CActiveRecord{
	public function tableName() {
		return '{{cservice_group}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function get_groups(){
		return $this->findAll();
	}
	
}