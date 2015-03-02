<?php
class CartController extends HomeController{
	public $uid=0;
	public function init(){
		parent::init();
		if(Yii::app()->user->isGuest){
			$this->uid=0;
		}else{
			$this->uid=Yii::app()->user->uid;
		}
	}
	function actionIndex(){
		$page=array();
		$sessionid=Yii::app()->session->sessionID;
		$params['where']="and sessionid='$sessionid' and sessionid!=''  ";
		$params['order']="  order by a.cart_id desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$params['pageshow']=1;
		$page['listdata']=Dtable::model('cart')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$a=Dtable::model("goods")->findByPk($r['goods_id']);
			$goods=Dtable::toArr($a);
			$r['goods_name']=$goods['info_title'];
			$r['goods_img']=$goods['info_img'];
			$r['now_price']=$goods['now_price'];
			$list[]=$r;
		}
		$page['listdata']['list']=$list;//print_r($list);die();
	
		$this->render('/mall/cart',array('page'=>$page));
	}
	
	
	function actionAddCart(){
		$field=array();
		$field['uid']=$this->uid;
		$field['sessionid']=Yii::app()->session->sessionID;
		$field['goods_id']=intval($this->get('goods_id'));
		$field['goods_total']=intval($this->get('goods_total'));
		$goods_attr=$this->get('goods_attr');
		if($field['goods_total']<=0){
		    die('{"code":"-4","statewords":"数量出错"}');	
		}
	
		$sql="select * from goods where info_id=".$field['goods_id']." ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0){
		    die('{"code":"-2","statewords":"ID错误"}');	
		}
		$goods_data=$a['list'][0];
		$field['goods_attr']=array();
		if($goods_attr){
			$a=json_decode($goods_attr,1);
			foreach($a as $r){
				$sql="select b.linkage_name as attr_type_name,a.* from goods_attr as a left join linkage as b on b.linkage_id=a.attr_type_id where a.info_id=".$field['goods_id']." and id=".$r['attr_id'];
				$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
				if(count($a['list'])==0){
				    die('{"code":"-2232","statewords":"选购属性出错"}');		
				}
				$field['goods_attr'][]=$a['list'][0];
			}	
		}
		$field['goods_attr']=json_encode($field['goods_attr']);
		
		$field['create_time']=time();
		if($this->uid>0){	
			$sql="select * from cart where uid=".$field['uid']." and goods_id=".$field['goods_id']." and goods_attr='".helper::escape($field['goods_attr'])."' ";
		}else{
		    $sql="select *  from cart where sessionid='".$field['sessionid']."' and sessionid!=''  and goods_id=".$field['goods_id']." and goods_attr='".helper::escape($field['goods_attr'])."' ";	
		}
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])>0){
			$cart_id=$a['list'][0]['cart_id'];
			//die('{"code":"-1","statewords":"已经放入购物车"}');
			if($this->uid>0){	
				$sql="update cart set goods_total=goods_total+".$field['goods_total']." where uid=".$field['uid']." and cart_id=".$cart_id."  ";
			}else{
				$sql="update cart set goods_total=goods_total+".$field['goods_total']." where sessionid='".$field['sessionid']."' and sessionid!=''  and cart_id=".$cart_id." ";	
			}
			
			$a=Yii::app()->db->createCommand($sql)->execute();
		    die('{"code":"1","statewords":"成功增加数量"}');
		}
		$post=$this->data('Cart',$field);
		$a=$post->save();
		if($a===false){
		    die('{"code":"-5","statewords":"数据出错"}');	
		}else{
			die('{"code":"1","statewords":"成功加入购物车"}');
		}
		
		die();
		
	    	
	}
	
	function actionDelete(){
		$uid=$this->uid;
		$sessionid=Yii::app()->session->sessionID;
		$cart_id=intval($this->get('cart_id'));
		if($this->uid){
			$sql="select * from cart where cart_id=$cart_id and uid=$uid ";
		}else{
		    $sql="select * from cart where cart_id=$cart_id and sessionid='$sessionid' ";	
		}
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0){
		    die('{"code":"-2","statewords":"ID错误"}');	
		}
		$a=Cart::model()->deleteByPk($cart_id);
		
		die('{"code":"1","statewords":"删除成功"}');	
		
	}
	
	function actionDeleCartAll(){
		$uid=$this->uid;
		$sessionid=Yii::app()->session->sessionID;
		$sql="select * from cart where uid=$uid ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0){
		    die('{"code":"-2","statewords":"ID错误"}');	
		}
		if($this->uid>0){
			$sql="delete  from cart where  uid=$uid ";
		}else{
		    $sql="delete  from cart where  sessionid='$sessionid' and (sessionid!='') ";	
		}
		$a=Yii::app()->db->createCommand($sql)->execute();
		die('{"code":"1","statewords":"清除成功"}');	
		
	}
	
	function actionUpdateCartTotal(){
		$uid=$this->uid;
		$sessionid=Yii::app()->session->sessionID;
		$cartdata=$this->post('cartdata');
		$cartdata=json_decode($cartdata,1);
		
		foreach($cartdata as $r){
			$r['goods_total']=intval($r['goods_total']);
			if($r['goods_total']<=0)continue;
			if($this->uid>0){
				$sql="update cart set goods_total=".$r['goods_total']." where  uid=$uid and cart_id=".$r['cart_id']." ";
			}else{
				$sql="update cart set goods_total=".$r['goods_total']." where sessionid='$sessionid' and(sessionid!='') and cart_id=".$r['cart_id']." ";
			}
			
		    $a=Yii::app()->db->createCommand($sql)->execute();
		}
		die('{"code":"1","statewords":"更新成功"}');	
		
	}
	
	function actionGetCartTotalMoney(){
	
		$sessionid=Yii::app()->session->sessionID;
		$uid=$this->uid;
		if($this->uid>0){
			$sql="select p.*,c.* from cart as c left join goods as p on p.info_id=c.goods_id where uid=$uid";	
		}else{
			$sql="select p.*,c.* from cart as c left join goods as p on p.info_id=c.goods_id where sessionid='$sessionid' and sessionid!='' ";
		}
		$rsarrs['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$page['goods_list']=$rsarrs['list'];
		$cart_total=0;
		$cart_money=0;
		foreach($page['goods_list'] as $r)
		{
			$cart_total+=$r['goods_total'];
	 		$cart_money+=$r['now_price']*$r['goods_total'];
		}
		die('{"total":"'.$cart_total.'","money":"'.$cart_money.'"}');
	}
	//右侧餐车
	function actionGetCartInfo(){
		$re=array();
		$uid=$this->uid;
		$sessionid=Yii::app()->session->sessionID;
		if($this->uid>0){
			$sql="select * from cart where uid=$uid";	
		}else{
			$sql="select * from cart where sessionid='$sessionid' and sessionid!='' ";
		}
		
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0){
		    die('{"code":"-2","statewords":"ID错误或购物车空的"}');	
		}
		if($this->uid>0){
			$sql="select p.*,c.* from cart as c left join goods as p on p.info_id=c.goods_id where uid=$uid";	
		}else{
			$sql="select p.*,c.* from cart as c left join goods as p on p.info_id=c.goods_id where sessionid='$sessionid' and sessionid!='' ";
		}
		
		$rsarrs['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$page['goods_list']=$rsarrs['list'];
		$cart_total=0;
		$cart_money=0;
		foreach($page['goods_list'] as $r){
			$cart_total+=$r['goods_total'];
	 		$cart_money+=$r['now_price']*$r['goods_total'];
		}
		$re['code']=1;
		$re['cart_total']=$cart_total;
		$re['cart_money']=$cart_money;
		$re['goods_list']=$page['goods_list'];
		die(json_encode($re));
	}
	
		
	
}