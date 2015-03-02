<?php
class SiteSeo extends CActiveRecord{
	public function tableName() {
		return '{{site_seo}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function getSeodata(){
		$sql="select * from site_seo ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();	
		return $a;
	}

}
