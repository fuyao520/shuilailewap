<?php
class RecvAddressController extends UserController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.create_time desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$params['pageshow']=$this->pageshow;
		$page['listdata']=Dtable::model('recv_address')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){			
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		$this->render('/recv_address_index',array('page'=>$page));
	}
	
	public function actionUpdate(){
		$page=array();
		$uid=Yii::app()->user->uid;
		if(!$_POST){
			$id=$this->get('id');
			$m=RecvAddress::model()->findByPk($id);	
			if($m){				
				$page['info']=$this->toArr($m);
			}else{
				
			}	
			
			
		}else{					
			$id=$_POST['id']=intval($_POST['id']);			
			$m=RecvAddress::model()->findByPk($id);		
			//如果有post.id 为保存修改，否则为保存新增
			if(!$m){
				$m=new RecvAddress();
			}			
			$m->uid=$uid;
			$m->recv_contact=urldecode($this->post('recv_contact'));
			if($m->recv_contact==''){
				$this->msg(array('state'=>0,'msgwords'=>'联系人不能为空','type'=>'json'));
			}
			$m->recv_cellphone=urldecode($this->post('recv_cellphone'));
			if(!verify::check_mobile($m->recv_cellphone)){
				$this->msg(array('state'=>0,'msgwords'=>'手机号请填写正确','type'=>'json'));
			}
			$m->recv_address=urldecode($this->post('recv_address'));
			if(strlen($m->recv_address)<5){
				$this->msg(array('state'=>0,'msgwords'=>'收货地址请填写正确','type'=>'json'));
			}
			
			
			$m->create_time=time();			
			$dbresult=$m->save();	
			$msgarr['type']='json';
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
								
			}else{
				$id=$m->primaryKey;
			}
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{	
				$this->msg($msgarr);
			}
		}
		$this->render('/recv_address_update',array('page'=>$page));
	}
	
	//删除信息
	public function actionDelete(){
		$uid=Yii::app()->user->uid;
		$id=intval($this->get('id'));
		$m=RecvAddress::model()->findByPk($id);
		if($m->uid!=$uid){
			$this->msg(array('state'=>0,'msgwords'=>'无权限','type'=>'json'));
		}
		$m->delete();
		$this->msg(array('state'=>1,'msgwords'=>'操作成功','type'=>'json'));
	}
	
	//设为默认
	public function actionSetDefault(){
		$uid=Yii::app()->user->uid;
		$id=intval($this->post('id'));
		$m=RecvAddress::model()->findByPk($id);
		if(!$m || $m->uid!=$uid){
			$this->msg(array('state'=>0,'msgwords'=>'无权限','type'=>'json'));
		}
		$m2=RecvAddress::model()->findByAttributes(array('uid'=>$uid,'is_default'=>1));
		if($m2){
			$m2->is_default=0;
			$m2->save();
		}
		$m->is_default=1;
		$m->save();
		$this->msg(array('state'=>1,'msgwords'=>'操作成功','type'=>'json'));
	}
	
}