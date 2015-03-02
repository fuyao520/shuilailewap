<?php
class Youhui extends CActiveRecord{
	public function tableName() {
		return '{{youhui}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	//获取某商品优惠促销
	public function get_goods_youhui($goods_id,$order='asc'){
		$sql="select * from youhui where info_id=$goods_id order by buy_total $order ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a;
	
	}
	
	//计算数量能优惠多少元
	function get_reduction_money($data,$buy_total){
		$re['money']=0;
		$re['title']='';
		if(count($data)==0){
			return $re;
		}
		$reduction_money=0;//print_r($data);
		foreach($data as $r){
			if($buy_total>=$r['buy_total']){
				$re['money']=$r['reduce_money'];
				$re['title']='数量达到 '.$r['buy_total'].' 份，减免 '.$r['reduce_money'].' 元';
			}
		}
		return $re;
	}
	//计算优惠活动能减免多少钱
	function get_activity_reduction_money($data,$order_money,$is_login){
		$re['money']=0;
		$re['title']='';
		if(count($data)==0){
			return $re;
		}
		$reduction_money=0;//print_r($data);
		foreach($data as $r){
			if($order_money>=$r['min_amount']){
				//如果优惠限制是非会员，但是用户已经登录，则忽略
				if($r['user_rank']==0 && $is_login==1){
					continue;
				}
				if($r['user_rank']==1 && $is_login==0){
					continue;
				}
				if($r['act_type']==0){  //如果是减免现金
					$re['money']=$r['act_type_ext'];
				}else if($r['act_type']==1){ //如果是打折
					$re['money']=$order_money-($r['act_type_ext']/100*$order_money);
					$re['money']=preg_replace('~(\.\d{2})\d+~','$1',$re['money']);
				}
				$re['title']=$r['activity_name'];
				break;
					
			}
		}
		return $re;
	}
	//取得优惠活动列表 ,state=1 有效 0=所有,
	function get_activity($state=0){
		$where=" where 1 ";
		if($state==1){
			$where .=" and start_time<".time()." and end_time>".time()." ";
		}
		$sql="select * from activity $where  order by activity_id desc ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a;
	}

}
