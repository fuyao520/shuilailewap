<?php
class OrderController extends UserController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.user_order_id desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$params['pageshow']=$this->pageshow;
		$page['listdata']=Dtable::model('user_order')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$r['goods_list']=OrderGoods::model()->get_order_goods($r['user_order_id']);
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		
		$this->render('/order_index',array('page'=>$page));
	}
	
	//删除订单
	function actionDelete(){
		$uid=Yii::app()->user->uid;
		$order_id=$this->post('order_id');
		$m=UserOrder::model()->findByAttributes(array('uid'=>$uid,'user_order_id'=>$order_id));
		if(!$m){
			die('{code:"-2",statewords:"订单不存在或无权限"}');
		}
		//如果是订单状态为 等待付款 或者 是 交易关闭的状态，则可以删除
		if($m->order_state!=0 && $m->order_state!=5 ){
			die('{code:"-2",statewords:"订单无法删除"}');
		}
		$m->delete();
		$sql="delete  from order_goods   where  order_id=$order_id ";
		Yii::app()->db->createCommand($sql)->execute();
		die('{code:1,statewords:"操作成功"}');
	}
	
	function actionDetail(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$order_id=$this->get('order_id');
		$m=UserOrder::model()->findByPk($order_id);
		if(!$m){
			$this->msg(array('state'=>-2,'msgwords'=>'订单不存在'));
		}
		if($m->uid!=$uid){
			$this->msg(array('state'=>-3,'msgwords'=>'订单无权限'));
		}
		$page['order_detail']=Dtable::toArr($m);
		$page['order_detail']['goods_list']=OrderGoods::model()->get_order_goods($order_id);
	
		$this->render('/order_detail',array('page'=>$page));
	
	}
	
	
}