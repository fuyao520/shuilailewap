<?php
class Cart extends CActiveRecord{
	public function tableName() {
		return '{{cart}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	//获取用户购物车的商品
	public function get_list($uid,$sessionid=''){
		if($uid>0){
			$sql="select * from cart as c   where uid=$uid";
		}else{
			$sql="select * from cart as c   where sessionid='$sessionid' and sessionid!=''";
		}
		$list=Yii::app()->db->createCommand($sql)->queryAll();
		$list2=array();
		foreach($list as $r){
			$a=Dtable::model("goods")->findByPk($r['goods_id']);
			$goods=Dtable::toArr($a);
			$r['url']=Cms::model()->set_info_url($goods);
			$r['thumb']=Attachment::simg($goods['info_img']);
			$r['goods_name']=$r['title']=$goods['info_title'];
			$r['goods_img']=$goods['info_img'];
			$r=array_merge($goods,$r);
			$list2[]=$r;
			
		}
		return $list2;
	}
}
