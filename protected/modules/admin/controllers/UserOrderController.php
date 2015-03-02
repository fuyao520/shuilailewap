<?php
class UserOrderController extends AdminController{

	public function actionIndex(){
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.nlink_txt like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.nlink_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.user_order_id desc      ";
		$params['join']="left join user_list as b on b.uid=a.uid ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(UserOrder::model()->tableName())->listdata($params);
		
		
		//总交易
		$sql="select sum(order_money_count) as money from user_order a where 1  ".$params['where'];
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();	
		$page['stat']['total_money']=$a['list'][0]['money']?$a['list'][0]['money']:0;
		
		//成功交易
		$sql="select sum(order_money_count) as money,count(*) as total from user_order a where 1  ".$params['where']." and a.order_state=1 ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();	
		$page['stat']['ok_total_money']=$a['list'][0]['money']?$a['list'][0]['money']:0;
		$page['stat']['ok_total']=$a['list'][0]['total'];
		
		
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Nlink_edit');			
				$info=$this->toArr(UserOrder::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('Nlink_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			$m=UserOrder::model()->findByPK($id);
			if(!$m){
				$m=new Nlink();
			}
			
			$m->nlink_txt=$this->post('nlink_txt');
			if($m->nlink_txt==''){
				$this->msg(array('state'=>0,'msgwords'=>'内链名称不能为空'));
			}
			$m->nlink_url=$this->post('nlink_url');
			$m->norder=intval($this->post('norder'));
			$dbresult=$m->save();
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Nlink_edit');
				$msgarr=array('state'=>1,'url'=>$this->createUrl('nlink/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了内链 ID:'.$id.''.$m->nlink_txt.' ';
			}else{	
				$this->auth_action('Nlink_add');				
				$id=$m->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了内链ID：$dbresult".$m->nlink_txt;
			}
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{
				//新增和修改之后的动作
				$this->logs($logs);
				//成功跳转提示
				$this->msg($msgarr);
			}
	
		}
		$this->render('update',array('page'=>$page));
	}
	public function actionDelete(){
		$this->auth_action('Nlink_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=UserOrder::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了内链ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionChangeMoney(){
		$user_order_id=$this->post('user_order_id');
		$order_money_count=$this->post('order_money_count');
		$m=UserOrder::model()->findByPk($user_order_id);
		if(!$m){
			$this->msg(array('state'=>-1,'msgwords'=>'订单不存在','type'=>'json'));
		}
		$tmp_money=$m->order_money_count;
		$m->order_money_count=$order_money_count;
		$m->save();
		$this->logs('修改了订单'.$user_order_id.'的金额 ￥'.$tmp_money.' 变为 '.$m->order_money_count.'  ');
		$this->msg(array('state'=>1,'type'=>'json'));
	}

}
?>