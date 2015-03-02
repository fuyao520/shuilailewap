<?php
class FlinkController extends AdminController{

	public function actionIndex(){
		$this->auth_action('Flink_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.flink_name like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.flink_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.flink_id      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(Flink::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Flink_edit');			
				$info=$this->toArr(Flink::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'文档不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('Flink_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['flink_name']=$this->post('flink_name');
			if($field['flink_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'友情链接名称不能为空'));
			}
			$field['flink_is_site']=intval($this->post('flink_is_site'));
			$field['flink_img']=$this->post('flink_img');
			$field['flink_order']=intval($this->post('flink_order'));
			$field['flink_url']=$this->post('flink_url');
			$field['flink_hosturl']=$this->post('flink_hosturl');
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Flink_edit');
				$dbresult=Flink::model()->updateAll($field,"flink_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('flink/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了友情链接 ID:'.$id.''.$field['flink_name'].' ';
			}else{	
				$this->auth_action('Flink_add');
				$post=$this->data('Flink',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了友情链接ID：$dbresult".$field['flink_name'];
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
		$this->auth_action('Flink_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Flink::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了友情链接ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('Flink_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Flink::model()->findByPk($id);
			if(!$m) continue;
			$m->flink_order=$order;
			$m->save();		
		}
		$this->logs('修改了友情链接的排序');
		$this->msg(array('state'=>1));
	}

}
?>