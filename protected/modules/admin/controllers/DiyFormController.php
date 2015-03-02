<?php
class DiyFormController extends AdminController{
	public $page=array();
	
	public function init(){
		parent::init();
		$page['c']=array();
	//本页面的所有操作必须传入 get 的   cate_id，否则无法进行操作
		$page['cate_info']=array();
		if(!isset($_GET['cate_id']) || $_GET['cate_id']==''){
		   	$this->msg(array('state'=>-2,'msgwords'=>'请选择分类'));
		}
		$_GET['cate_id']=intval($_GET['cate_id']);
		$sql="select * from model where model_type=1 and parent_model_id=0 and model_id=".$_GET['cate_id'];
		$rsarr['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rsarr)==0){
		    $this->msg(array('state'=>-2,'msgwords'=>'表单模型不存在'));	
		}
		$page['cate_info']=$rsarr['list'][0];
	   //获取所有父栏目的ID，用于 面包屑导航
		$catearr[]=$page['cate_info'];
		$page['parent_cate_arr']=$catearr;
		//print_r($page['parent_cate_arr']);
		
		//模型字段用于在列表显示的
		$m=ModelField::model()->get_model_field($page['cate_info']['model_id']);
		$page['model_fields']=array();
		$del_fields=array('id');
		foreach($m as $b){
			if(($b['list_show']==1) && (!in_array($b['field_name'],$del_fields)) ){
				$page['model_fields'][]=$b;
			}
		}
		//模型字段 用于在 添加和修改的时候显示
		$page['model_fields2']=array();
		$del_fields=array('id','is_check');
		foreach($m as $b){
			if((!in_array($b['field_name'],$del_fields)) ){
				$page['model_fields2'][]=$b;
			}
		}
		
		//子模型
		$sql03=" select * from model where  parent_model_id=".$page['cate_info']['model_id']." ";//echo $sql03;
		$a['list']=Yii::app()->db->createCommand($sql03)->queryAll();
		if(count($a['list'])>0){
			$page['cmodel']=$a['list'];
		}else{
			$page['cmodel']=array();
		}
		$this->page=$page;

	
				
	}	
	
	public function actionIndex(){
		$page=$this->page;
		$this->auth_action('Nlink_Index');
		//搜索
		$params['where']=" and 1  ";
		
		if($this->get('search_type')=='keys'&&$this->get('search_txt')){
			$wheresql .=" and(a.username like '%".$this->get('search_txt')."%') ";
		}
		if($this->get('search_type')=='id'&&$this->get('search_txt')){
			$wheresql .=" and(a.id =".intval($this->get('search_txt')).") ";
		}
		
		$params['order']="  order by a.id desc      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model($page['cate_info']['model_table_name'])->listdata($params);
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
				$info=$this->toArr(Dtable::model($page['cate_info']['model_table_name'])->findByPk($id));
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
			if(isset($field['id'])){
				unset($field['id']);
			}
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('info_edit');
				$dbresult=Dtable::model($page['cate_info']['model_table_name'])->updateAll($field,"id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('diyForm/index').'?p='.$_GET['p'].'&cate_id='.$_GET['cate_id']); //保存的话，跳转到之前的列表
				$logs='修改了'.$page['cate_info']['model_name'].' ID:'.$id.'';
			}else{	
				$this->auth_action('diyform_add');
				$post=$this->data('Dtable',$field,$page['cate_info']['model_table_name']);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs='添加了'.$page['cate_info']['model_name'].'ID：$dbresult';
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
			$m=Dtable::model($page['cate_info']['model_table_name'])->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了'.$page['cate_info']['model_name'].'ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$page=$this->page;
		$this->auth_action('info_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Dtable::model($page['cate_info']['model_table_name'])->findByPk($id);
			if(!$m) continue;
			$m->corder=$order;
			$m->save();		
		}
		$this->logs('修改了'.$page['cate_info']['model_name'].'的排序');
		$this->msg(array('state'=>1));
	}
	public function actionAudit(){
		$page=$this->page;
		$this->auth_action('form_'.$page['get']['cate_id'].'_audit');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		$audit=intval($this->get('audit'));
		$info_table=$page['cate_info']['model_table_name'];
		foreach($ids as $id){
			$id=intval($id);
			$sql=" update  $info_table  set  is_check=$audit   where id=".$id." ";
			//echo $sql;
			Yii::app()->db->createCommand($sql)->execute();
		}
		//die();
		$this->msg(array('state'=>1));
	}

}
?>