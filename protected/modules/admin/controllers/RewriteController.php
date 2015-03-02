<?php
class RewriteController extends AdminController{

	public function actionIndex(){
		$this->auth_action('Rewrite_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.rewrite_name like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.rewrite_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by rewrite_order,rewrite_id desc     ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(Rewrite::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));		
	}	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Rewrite_edit');			
				$info=$this->toArr(Rewrite::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'文档不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('Rewrite_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['rewrite_name']=$this->post('rewrite_name');
			if($field['rewrite_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'伪静态名称不能为空'));
			}
			$field['rewrite_ident']=$this->post('rewrite_ident');
			$field['rewrite_example']=$this->post('rewrite_example');
			$field['true_url']=$this->post('true_url');
			$field['rewrite_rule']=$this->post('rewrite_rule');
			$field['rewrite_type']=intval($this->post('rewrite_type'));
			$field['rewrite_page_rule']=$this->post('rewrite_page_rule');;
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Rewrite_edit');
				$dbresult=Rewrite::model()->updateAll($field,"rewrite_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('rewrite/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了伪静态 ID:'.$id.''.$field['rewrite_name'].' ';
			}else{	
				$this->auth_action('Rewrite_add');
				$post=$this->data('Rewrite',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了伪静态ID：$dbresult".$field['rewrite_name'];
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
		$this->auth_action('Rewrite_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Rewrite::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了伪静态ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('Rewrite_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Rewrite::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了伪静态的排序');
		$this->msg(array('state'=>1));
	}

}
?>