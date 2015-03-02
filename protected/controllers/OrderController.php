<?php
class OrderController extends HomeController{
	public $uid=0;
	public function init(){
		parent::init();
		$this->uid=0;
		if(Yii::app()->user->isGuest==0){
			$this->uid=Yii::app()->user->uid;
		}
	
		
	}
	public function filterAccessAuth($filterChain) {
		//保存订单和订单页面 ，会员和非会员共用，   其他动作 只能给 非会员使用，会员去自己的会员中心看
		$action=$this->getAction()->getId();//echo $action;
		if(Yii::app()->user->isGuest==0 ){
			if($action=='index' || $action=='saveOrderInfo'){
				$filterChain->run();
			}else{
				header("location:/user/order/index");
				die();
			}
		}else{
			$filterChain->run();
		}
	}
	
	public function actionIndex(){
		$uid=$this->uid;
		$sessionid=Yii::app()->session->sessionID;
		$type=$this->get('type');
		$goods_id=$this->get('goods_id');
		$num=$this->get('num');
		$goods_attr=$this->get('goods_attr');
		
		if($this->get('type')=='exchange_goods'){
			 if($page['member']['is_login']==0){
			     $this->msg(array('state'=>2,'msgwords'=>'积分兑换需要登录！'));			 
			 }
			 $sql="select b.*,a.*,b.info_title as goods_name,b.info_img as goods_img from exchange_goods as a left join goods as b on b.info_id=a.goods_id where a.goods_id=$goods_id and b.info_id=$goods_id and b.audit=1  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>2,'msgwords'=>'积分商品不存在'));	
			}
			$info_data=$a['list'][0];
			if($info_data['exchange_point']>$page['member']['points']){
				$this->msg(array('state'=>2,'msgwords'=>'您当前的积分不够！'));		
			}
			$a=Cms::model()->info_content('goods',$info_data['info_id']);
			$info_data=array_merge($info_data,$a);
			$info_data['goods_attr']='[]';
			$info_data['goods_total']=1;
			$info_data['goods_price']=$info_data['now_price'];
			$info_data['now_price']=0;
			$info_data['exchange_url']=url::encode('exchange_goods_detail',array('goods_id'=>$info_data['info_id']));
			$page['goods_list'][]=$info_data;
				
		}else if($this->get('type')=='group_buy'){
			 $sql="select b.*,a.*,b.info_title as goods_name,b.info_img as goods_img from group_goods as a left join goods as b on b.info_id=a.goods_id where a.goods_id=$goods_id and b.info_id=$goods_id and b.audit=1  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>2,'msgwords'=>'团购商品不存在'));	
			}
			if($a['list'][0]['end_time']<time()){
				$this->msg(array('state'=>2,'msgwords'=>'该团购已结束'));		
			}
			if($num<=0){
				$this->msg(array('state'=>2,'msgwords'=>'数量出错'));	
			}
			$info_data=$a['list'][0];
			$a=Cms::model()->info_content('goods',$info_data['info_id']);
			$info_data=array_merge($info_data,$a);
			$info_data['goods_attr']='[]';
			$info_data['goods_total']=$num;
			$info_data['now_price']=$info_data['group_price'];
			$info_data['group_url']=url::encode('group_goods_detail',array('goods_id'=>$info_data['info_id']));
			$page['goods_list'][]=$info_data;
				
		}else if($this->get('type')=='immediately_buy'){ //立刻购买
			$sql="select a.info_id as goods_id,a.info_title as goods_name,a.info_img as goods_img,now_price from goods as a where a.info_id=$goods_id and a.audit=1  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>2,'msgwords'=>'商品不存在'));	
			}
			if($num<=0){
				$this->msg(array('state'=>2,'msgwords'=>'数量出错'));	
			}
			
			$a['list'][0]['info_id']=$a['list'][0]['goods_id'];
			$info_data=$a['list'][0];
			$a=Cms::model()->info_content('goods',$info_data['info_id']);
			$info_data=array_merge($info_data,$a);
			
			$info_data['goods_attr']=array();
			if($goods_attr){
				$a=json_decode($goods_attr,1);
				foreach($a as $r){
					$sql="select b.linkage_name as attr_type_name,a.* from goods_attr as a left join linkage as b on b.linkage_id=a.attr_type_id where a.info_id=".$goods_id." and id=".$r['attr_id'];
					$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
					if(count($a['list'])==0){
						$this->msg(array('state'=>2,'msgwords'=>'选购属性出错'));
					}
					$info_data['goods_attr'][]=$a['list'][0];
				}	
			}
			$info_data['goods_total']=$num;
			$info_data['goods_attr']=json_encode($info_data['goods_attr']);
			$info_data['group_url']=url::encode('group_goods_detail',array('goods_id'=>$info_data['info_id']));
			$page['goods_list'][]=$info_data;
				
		}else{
			//取出购物车的商品列表
			
			$page['goods_list']=Cart::model()->get_list($uid,$sessionid);
		}
		
		
		
		$page['order_cate']=0;
		if(count($page['goods_list'])==0){
			$page['relation_cate_top']['cate_id']='home';
		    $this->msg(array('state'=>2,'msgwords'=>'您的购物车暂无商品！'));		
		}
		
		if(!Yii::app()->user->isGuest){	
			//取出收货地址
			$sql="select * from recv_address where uid=$uid ";
			$rsarrs2['list']=Yii::app()->db->createCommand($sql)->queryAll();
			$page['address_list']=$rsarrs2['list'];
		}else{
			$page['address_list']=array();
		}
		
		//取出配送方式
		$sql="select * from shipping where enabled=1 ";
		$rsarrs3['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$page['shipping_list']=$rsarrs3['list'];
		
		
		$this->render('/mall/index',array('page'=>$page));
		
	}
	
	//确认生成订单
	public function actionSaveOrderInfo(){
		$goods_total_gift=0;  //商品数量是否优惠过
		$uid=$this->uid;
		$sessionid=Yii::app()->session->sessionID;
		
		
		
		$address_id=$this->post('address_id');
		$shipping_id=$this->post('shipping_id');
		$postscript=$this->post('postscript');
		$tohours=$this->post('tohours');
		$consignee=$this->post('consignee');
		$address=$this->post('address');
		$mobile=$this->post('mobile');
		$tel=urldecode($this->post('tel'));
		$email=urldecode($this->post('email'));
		$type=urldecode($this->post('type'));
		$goods_id=$this->post('goods_id');
		$num=$this->post('num');
		$goods_attr=urldecode($this->post('goods_attr'));
		if(trim($consignee)==''){
		    die('{"code":"-10","statewords":"联系人不能为空"}');	 	
		}
		if(!preg_match('~^1\d{10}$~',$mobile,$result)){
		    die('{"code":"-9","statewords":"手机号码格式不正确"}');	 	
		}
		if(strlen(trim($address))<5){
		    die('{"code":"-11","statewords":"收货地址请填写完整"}');	 	
		}
		$field=array();
		$field['order_money_count']=0;
		
		if($type=='exchange_goods'){
			 if($page['member']['is_login']==0){
			     $this->msg(array('state'=>2,'msgwords'=>'积分兑换需要登录！'));			 
			 }
			 $field['extension_code']='exchange_goods';
			 $sql="select b.*,a.*,b.info_title as goods_name,b.info_img as goods_img from exchange_goods as a left join goods as b on b.info_id=a.goods_id where a.goods_id=$goods_id and b.info_id=$goods_id and b.audit=1  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>2,'msgwords'=>'积分商品不存在'));	
			}
			$info_data=$a['list'][0];
			if($info_data['exchange_point']>$page['member']['points']){
				$this->msg(array('state'=>2,'msgwords'=>'您当前的积分不够！'));		
			}
			$info_data['goods_attr']='[]';
			$info_data['goods_total']=1;
			$info_data['goods_price']=$info_data['now_price'];
			$info_data['now_price']=0;
			$goods_list[]=$info_data;
			$field['extension_id']=$info_data['info_id'];
			$field['integral']=$info_data['exchange_point'];
			
		}else if($type=='group_buy'){
			 $field['extension_code']='group_buy';
			 $sql="select b.*,a.*,b.info_title as goods_name,b.info_img as goods_img from group_goods as a left join goods as b on b.info_id=a.goods_id where a.goods_id=$goods_id and b.info_id=$goods_id and b.audit=1  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>2,'msgwords'=>'团购商品不存在'));	
			}
			if($a['list'][0]['end_time']<time()){
				$this->msg(array('state'=>2,'msgwords'=>'该团购已结束'));		
			}
			if($num<=0){
				$this->msg(array('state'=>2,'msgwords'=>'数量出错'));	
			}
			$info_data=$a['list'][0];
			$info_data['goods_attr']='[]';
			$info_data['goods_total']=$num;
			$info_data['goods_price']=$info_data['now_price'];
			$info_data['now_price']=$info_data['group_price'];
			$goods_list[]=$info_data;
			$field['extension_id']=$info_data['info_id'];
			
		}else if($type=='immediately_buy'){ //立刻购买
			
			$num=$this->post('num');
			$sql="select a.info_id as goods_id,a.info_title as goods_name,a.info_img as goods_img,a.* from goods as a where a.info_id=$goods_id and a.audit=1  ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>2,'msgwords'=>'商品不存在'));	
			}
			if($num<=0){
				$this->msg(array('state'=>2,'msgwords'=>'数量出错'));	
			}
			$info_data=$a['list'][0];		
			$info_data['goods_attr']=array();
			$info_data['goods_price']=$info_data['now_price'];
			if($goods_attr){
				$a=json_decode($goods_attr,1);
				foreach($a as $r){
					$sql="select b.linkage_name as attr_type_name,a.* from goods_attr as a left join linkage as b on b.linkage_id=a.attr_type_id where a.info_id=".$goods_id." and id=".$r['attr_id'];
					$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
					if(count($a['list'])==0){
						$this->msg(array('state'=>2,'msgwords'=>'选购属性出错'));
					}
					$info_data['goods_price']+=$a['list'][0]['attr_price'];
					$info_data['goods_attr'][]=$a['list'][0];
				}	
			}
			$info_data['goods_total']=$num;
			$info_data['goods_attr']=json_encode($info_data['goods_attr']);
			$goods_list[]=$info_data;
				
		}else{
			//取出购物车的商品
			if(Yii::app()->user->isGuest==0){	
				$sql="select p.*,c.* from cart as c left join goods as p on p.info_id=c.goods_id where uid=$uid";
			}else{
				$sql="select p.*,c.* from cart as c left join goods as p on p.info_id=c.goods_id where sessionid='$sessionid' and sessionid!=''";	
			}	
			$c['list']=Yii::app()->db->createCommand($sql)->queryAll();
			$goods_list=$c['list'];
			if(count($goods_list)==0){
				die('{"code":"-2","statewords":"商品出问题了"}');		
			}
		}
		//计算总价
		foreach($goods_list as $r){
			$a=Youhui::model()->get_goods_youhui($r['info_id'],'asc');
			$re=Youhui::model()->get_reduction_money($a,$r['goods_total']); 
			if($re['money']>0){
			    $field['order_money_count']-=$re['money'];	
				$field['is_gift']=1;
				$goods_total_gift=1;
			}
			$goods_attr=json_decode($r['goods_attr'],1);
			foreach($goods_attr as $r2){
				$r['now_price']+=$r2['attr_price'];
			}
			$field['order_money_count']+=$r['now_price']*$r['goods_total'];	 
		}
		$sql="select * from shipping where shipping_id=".$this->post('shipping_id')." and enabled=1 ";
		$a2['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a2['list'])==0){
			die('{"code":"-2","statewords":"配送方式出错"}');	
		}
		$shipping_data=$a2['list'][0];
		$field['uid']=$uid;
		if($this->uid>0){	
			$field['sessionid']='';
		}else{
			$field['sessionid']=Yii::app()->session->sessionID;
		}
		$field['postscript']=$this->post('postscript');
		$field['tohours']=$this->post('tohours');
		//收货人信息
		$field['consignee']=$this->post('consignee');
		$field['address']=$this->post('address');
		$field['mobile']=$this->post('mobile');
		$field['tel']=$this->post('tel');
		$field['email']=$this->post('email');
		//配送信息
		$field['shipping_id']=$shipping_data['shipping_id'];
		$field['shipping_name']=$shipping_data['shipping_name'];
		$field['shipping_fee']=$shipping_data['insure'];
		$field['trade_no']=date("YmdHis").substr(microtime(),2,4);
		$field['create_time']=time();
		//加上运费
		$field['order_money_count']+=$shipping_data['insure'];	
		//算出是否享受优惠活动
		$activity_data=Youhui::model()->get_activity(1);
		$activity_result=Youhui::model()->get_activity_reduction_money($activity_data,$field['order_money_count'],Yii::app()->user->isGuest?0:1);
		if($activity_result['money']>0 && $goods_total_gift==0){
			$field['order_money_count']-=$activity_result['money'];
			$field['is_gift']=1;
			$field['gift_detail']=$activity_result['title'];
		}
		
		//事物回滚
		$transaction = Yii::app()->db->beginTransaction();
		try {
			//$sql=helper::get_sql('user_order','insert',$field);//echo $sql;
			$post=$this->data('Dtable',$field,'user_order');
			$dbresult=$post->save();
			$user_order_id=$post->primaryKey;
			if(!$user_order_id){
				die('{"code":"-2","statewords":"订单数据出现错误"}');
			}
			
		    foreach($goods_list as $r){
		   		$field_s=array();
				$field_s['order_id']=$user_order_id;
			    $field_s['goods_id']=$r['info_id'];
				$field_s['goods_name']=$r['info_title'];
				$field_s['goods_img']=$r['info_img'];
				$field_s['goods_sn']=$r['goods_sn'];
				$field_s['goods_number']=$r['goods_total'];
				$field_s['is_real']=1;
				$field_s['market_price']=$r['market_price'];
				$goods_attr=json_decode($r['goods_attr'],1);
				if(is_array($goods_attr)){
					foreach($goods_attr as $r2){
						$r['now_price']+=$r2['attr_price'];
					}
				}
				$field_s['goods_price']=$r['now_price'];
				$field_s['goods_attr']=$r['goods_attr'];
		        
				$a=Youhui::model()->get_goods_youhui($r['info_id'],'asc');
				$re=Youhui::model()->get_reduction_money($a,$r['goods_total']); 
				if($re['money']>0){	
					$field_s['is_gift']=1;
					$field_s['gift_detail']=$re['title'];
				}
				
				$post=$this->data('Dtable',$field_s,'order_goods');
				$post->save();
				
			}
			if($this->post('type')=='exchange_goods'){
				//减去所需积分
				$field_p=array();
				$field_p['points']=-$field['integral'];
				$field_p['create_date']=time();
				$field_p['uid']=$uid;
				$field_p['points_reason']='积分商城消费，订单号 '.$field['trade_no'];
				//$p_sql=helper::get_sql("user_points",'insert',$field_p);
				$post=$this->data('Dtable',$field_p,'user_points');
				$post->save();
			}else if($this->post('type')=='group_buy'){
			
			}else if($this->post('type')=='immediately_buy'){
			
			}else{
				if($this->uid>0){	
					$clearsql="delete from cart where uid=$uid";
				}else{
					$clearsql="delete from cart where sessionid='$sessionid' and sessionid!='' and uid=0";				
				}
				$a=Yii::app()->db->createCommand($clearsql)->execute();
				
			}
			
			//商品的剩余数量要相应减去
			foreach($goods_list as $r){
				$sql="update goods set goods_total=goods_total-".$r['goods_total']." where info_id=".$r['info_id'];
				Yii::app()->db->createCommand($sql)->execute();
			}
			$transaction->commit();//提交事务
		} catch (Exception $e) {
			$transaction->rollback(); //如果操作失败, 数据回滚
			//echo $e->getMessage();
			die('{"code":"0","statewords":"订单创建失败，数据出错"}');
		}
		
		
		die('{"code":"1","statewords":"操作成功","user_order_id":'.$user_order_id.'}');
	}
	
	//未登录的订单列表
	public function actionList(){
		$page=array();
		$sessionid=Yii::app()->session->sessionID;
		$params['where']="and sessionid='$sessionid' and sessionid!='' and uid=0  ";
		$params['order']="  order by a.user_order_id desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$params['pageshow']=1;
		$page['listdata']=Dtable::model('user_order')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$r['goods_list']=OrderGoods::model()->get_order_goods($r['user_order_id']);
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
	
		$this->render('/mall/list',array('page'=>$page));
	}
	
	function actionDetail(){
		$page=array();
		$sessionid=Yii::app()->session->sessionID;
		$order_id=$this->get('order_id');
		$m=UserOrder::model()->findByPk($order_id);
		if(!$m){
			$this->msg(array('state'=>-2,'msgwords'=>'订单不存在'));
		}
		if($m->sessionid!=$sessionid){
			$this->msg(array('state'=>-3,'msgwords'=>'订单无权限'));
		}
		$page['order_detail']=Dtable::toArr($m);
		$page['order_detail']['goods_list']=OrderGoods::model()->get_order_goods($order_id);
		
		$this->render('/mall/detail',array('page'=>$page));
	
	}
	//删除订单
	function actionDelete(){
		$sessionid=Yii::app()->session->sessionID;
		$order_id=$this->post('order_id');
		$m=UserOrder::model()->findByAttributes(array('sessionid'=>$sessionid,'uid'=>0,'user_order_id'=>$order_id));
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
	

}


?>