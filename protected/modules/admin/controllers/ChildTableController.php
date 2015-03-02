<?php
class ChildTableController extends AdminController{
	
	public $page=array();
	/*
	 处理所有的子模型
	必须传入的参数为
	1.顶层模型 信息的 id
	2.顶层模型 信息的模型  id_model_id
	3.需要处理的子模型 cmodel_id
	可选的参数为
	1. 当前需要处理的子模型的上一级模型的  "表名_id"
	
	*/
	public function init(){
		parent::init();
		$page['c']=array();
		if(!isset($_GET['info_id']) || $_GET['info_id']==''){
			$this->msg(array('state'=>-2,'msgwords'=>'信息id错误'));
		}else if(!isset($_GET['id_model_id']) || $_GET['id_model_id']==''){
			$this->msg(array('state'=>-2,'msgwords'=>'信息的模型出错'));
		}else if(!isset($_GET['cmodel_id']) || $_GET['cmodel_id']==''){
			$this->msg(array('state'=>-2,'msgwords'=>'当前模型错误'));
		}else{
			$_GET['info_id']=intval($_GET['info_id']);
			$_GET['id_model_id']=$id_model_id=intval($_GET['id_model_id']);
			$_GET['cmodel_id']=$cmodel_id=intval($_GET['cmodel_id']);
		
		
		
			$sql="select * from model where  model_id=".$id_model_id;
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'信息的模型错误'));
			}
			$page['model']=$a['list'][0];
		
			//查询当前信息
			if($page['model']['model_type']==0){
				$page['model']['id_name']='info_id';
			}else if($page['model']['model_type']==1){
				$page['model']['id_name']='id';
			}
			$sql="select * from ".$page['model']['model_table_name']." where ".$page['model']['id_name']."=".$_GET['info_id'];
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'主信息不存在'));
			}
		
			$page['id_data']=$a['list'][0];		
			$sql="select * from model where  model_id=".$cmodel_id;
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'当前的模型错误'));
			}
			$page['cmodel']=$a['list'][0];
			if($page['cmodel']['model_type']!=$page['model']['model_type']){
				$this->msg(array('state'=>-2,'msgwords'=>'当前模型和信息的模型不是同一类型'));
			}
			if($page['cmodel']['parent_model_id']!=$page['model']['model_id']){
				//msg(array('state'=>-2,'msgwords'=>'当前模型和信息的模型关系不正确'));
			}
			if($page['cmodel']['parent_model_id']==0){
				$this->msg(array('state'=>-2,'msgwords'=>'顶层模型不允许在此页面处理'));
			}
		
			//父模型
			$sql="select * from model where  model_id=".$page['cmodel']['parent_model_id'];
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'父模型错误'));
			}
			$page['pmodel']=$a['list'][0];
			$page['pmodel']['id_name']=$page['pmodel']['model_table_name'].'_id';
			$_GET[$page['pmodel']['id_name']]=isset($_GET[$page['pmodel']['id_name']])?intval($_GET[$page['pmodel']['id_name']]):'';
		
			$page['model']['fields']=ModelField::model()->get_model_field($id_model_id);
		
		
			$page['cmodel']['fields']=ModelField::model()->get_model_field($cmodel_id);
		
			if($page['cmodel']['model_type']==0){
				$page['cmodel']['tid_name']='info_id';
			}else if($page['cmodel']['model_type']==1){
				$page['cmodel']['tid_name']='id';
			}else if($page['cmodel']['model_type']==2){
				$page['cmodel']['tid_name']='id';
			}
		
		
			//模型字段用于在列表显示的
			$m=ModelField::model()->get_model_field($cmodel_id);
			$page['model_fields']=array();
			if($page['cmodel']['model_type']==0){
				$del_fields=array('id','corder','info_id');
			}else if($page['cmodel']['model_type']==1){
				$del_fields=array('id','corder');
			}else{
				$del_fields=array('id');
			}
			foreach($m as $b){
				if(($b['list_show']==1) && (!in_array($b['field_name'],$del_fields)) ){
					$page['model_fields'][]=$b;
				}
			}
			//模型字段 用于在 添加和修改的时候显示
			$page['model_fields2']=array();
			if($page['cmodel']['model_type']==0){
				$del_fields=array('id','info_id');
			}else{
				$del_fields=array('id');
			}
		
			foreach($m as $b){
				if((!in_array($b['field_name'],$del_fields)) ){
					$page['model_fields2'][]=$b;
				}
			}
		
		
			//子模型
			$sql03=" select * from model where  parent_model_id=".$cmodel_id." ";//echo $sql03;
			$a['list']=Yii::app()->db->createCommand($sql03)->queryAll();
			if(count($a['list'])>0){
				$page['cmodels']=$a['list'];
			}else{
				$page['cmodels']=array();
			}
		
		
			//取出所有父模型
			$page['parent_model_cates']=InfoModel::model()->get_parent_model_arr($cmodel_id,'',1);
			$this->page=$page;
		
		}
	}
	
	
	public function actionIndex(){
		$page=$this->page;
		$this->auth_action('Nlink_Index');
		//搜索
		$params['where']=" and a.".$page['cmodel']['tid_name']."=".$_GET['info_id']." and a.".$page['cmodel']['tid_name']."=".$_GET['info_id']." ";
		if($_GET[$page['pmodel']['id_name']]){//echo 'aaaaaaaaaa';
			$params['where'] .=' and a.'.$page['pmodel']['id_name'].'='.$_GET[$page['pmodel']['id_name']];
		}
		
		$params['order']="  order by a.corder,a.id desc      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model($page['cmodel']['model_table_name'])->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=$this->page;
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Nlink_edit');			
				$info=$this->toArr(Dtable::model($page['cmodel']['model_table_name'])->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				
			}else{
				$this->auth_action('info_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			//模型的字段
			foreach($page['model_fields2'] as $f){
				$field[$f['field_name']]=$this->post($f['field_name']);
				$field[$f['field_name']]=form_type_code::get_html(array('m'=>'get_post_value','post_value'=>$field[$f['field_name']],'type'=>$f['form_type'],'linkage_type_id'=>$f['linkage_type_id']));
				
			}
			//print_r($field);die();			
			if($page['cmodel']['model_type']==0){
				$field['info_id']=$_GET['info_id'];
				$field['corder']=intval($this->post('corder'));
			}else if($page['cmodel']['model_type']==1){
				$field['corder']=intval($this->post('corder'));
			}else{
				
			}
			if(isset($field['id'])){
				unset($field['id']);
			}
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('info_edit');
				$dbresult=Dtable::model($page['cmodel']['model_table_name'])->updateAll($field,"id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('childTable/index').'?p='.$_GET['p'].'&info_id='.$_GET['info_id'].'&'.$page['cmodel']['model_table_name'].'_id'.'='.$_GET[$page['pmodel']['id_name']].'&id_model_id='.$_GET['id_model_id'].'&cmodel_id='.$_GET['cmodel_id']); //保存的话，跳转到之前的列表
				$logs='修改了'.$page['cmodel']['model_name'].' ID:'.$id.'';
			}else{	
				$this->auth_action('info_add');
				$post=$this->data('Dtable',$field,$page['cmodel']['model_table_name']);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs='添加了'.$page['cmodel']['model_name'].'ID：$dbresult';
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
		$page=$this->page;
		$this->auth_action('Nlink_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Dtable::model($page['cmodel']['model_table_name'])->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了'.$page['cmodel']['model_name'].'ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$page=$this->page;
		$this->auth_action('info_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Dtable::model($page['cmodel']['model_table_name'])->findByPk($id);
			if(!$m) continue;
			$m->corder=$order;
			$m->save();		
		}
		$this->logs('修改了'.$page['cmodel']['model_name'].'的排序');
		$this->msg(array('state'=>1));
	}

}
?>