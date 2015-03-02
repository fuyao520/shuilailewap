<?php
class CompanyWater extends CActiveRecord{
	public function tableName() {
		return '{{company_water}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
}
