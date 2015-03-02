<?php
class OrderGoods extends CActiveRecord{
	public function tableName() {
		return '{{order_goods}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function get_order_goods($order_id){
		
		$sql="select * from order_goods where order_id=$order_id";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a;
	}

}
