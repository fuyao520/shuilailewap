<?php
class TagCate extends CActiveRecord{
	public function tableName() {
		return '{{tag_cate}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

}
