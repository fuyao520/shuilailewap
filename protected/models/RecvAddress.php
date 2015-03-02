<?php
class RecvAddress extends CActiveRecord{
	public function tableName() {
		return '{{recv_address}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
