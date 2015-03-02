<?php
class UserOrderSpeedController extends AdminController{

	public function actionIndex(){
		$this->auth_action('UserOrderSpeed_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.nlink_txt like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='info_order_id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.info_order_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.create_time      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['join']=" left join info_order as b on b.info_id=a.info_order_id";
		$params['select']=" a.*,b.info_title";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(UserOrder::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('UserOrderSpeed_edit');			
				$info=$this->toArr(UserOrderSpeed::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('UserOrderSpeed_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['nlink_txt']=$this->post('nlink_txt');
			if($field['nlink_txt']==''){
				$this->msg(array('state'=>0,'msgwords'=>'内链名称不能为空'));
			}
			$field['nlink_url']=$this->post('nlink_url');
			$field['norder']=$this->post('norder',0);
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('UserOrderSpeed_edit');
				$dbresult=UserOrderSpeed::model()->updateAll($field,"nlink_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('nlink/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了内链 ID:'.$id.''.$field['nlink_txt'].' ';
			}else{	
				$this->auth_action('UserOrderSpeed_add');
				$post=$this->data('UserOrderSpeed',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了内链ID：$dbresult".$field['nlink_txt'];
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
		$this->auth_action('UserOrderSpeed_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=UserOrderSpeed::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了内链ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('UserOrderSpeed_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=UserOrderSpeed::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了内链的排序');
		$this->msg(array('state'=>1));
	}

}
?>