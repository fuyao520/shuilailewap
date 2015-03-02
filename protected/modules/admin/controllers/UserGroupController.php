<?php
class UserGroupController extends AdminController{

	public function actionIndex(){
		$this->auth_action('UserGroup_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.group_name like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.group_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.group_rank desc      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(UserGroup::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));		
	}	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('UserGroup_edit');			
				$info=$this->toArr(UserGroup::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('UserGroup_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['group_name']=$this->post('group_name');
			if($field['group_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'用户组名称不能为空'));
			}
			$field['group_rank']=$this->post('group_rank');
			$field['group_level']=json_encode($this->post('group_levels'));
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('UserGroup_edit');
				$dbresult=UserGroup::model()->updateAll($field,"group_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('userGroup/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了用户组 ID:'.$id.''.$field['group_name'].' ';
			}else{	
				$this->auth_action('UserGroup_add');
				$post=$this->data('UserGroup',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了用户组ID：$dbresult".$field['group_name'];
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
		$this->auth_action('UserGroup_del');
		$id=intval($this->get('id'));
		$m=UserGroup::model()->findByPk($id);
		if(!$m) continue;
		$m->delete();
		$this->logs('删除了用户组ID（'.$id.''.$m->group_name.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('UserGroup_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=UserGroup::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了用户组的排序');
		$this->msg(array('state'=>1));
	}

}
?>