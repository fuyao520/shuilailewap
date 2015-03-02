<?php
class Goods extends CActiveRecord{
	public function tableName() {
		return '{{goods}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	//更新所有商品的销售统计
	public function update_goods_sales(){
		$sql="select * from goods ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($a['list'] as $r){
			$total=intval($this->get_goods_sale_total($r['info_id']));
			$sql="update goods set sales=$total where info_id=".$r['info_id'];
			Yii::app()->db->createCommand($sql)->execute();
		}
	}
	//取得某件商品的 销售数量
	public function get_goods_sale_total($goods_id,$order_state=1){
		global $dbm;
		$sql="select sum(b.goods_number)  as total from user_order as a inner join order_goods as b on b.order_id=a.user_order_id where b.goods_id=$goods_id and a.order_state=$order_state";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		return intval($a['list'][0]['total']);
	}
	
}