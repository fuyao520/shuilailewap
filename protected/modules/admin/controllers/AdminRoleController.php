<?php
class AdminRoleController extends AdminController{
	public function actionIndex(){
		$this->auth_action('role_show');	
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] =" and(a.role_name like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] =" and(a.role_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.role_id desc    ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model('cservice_role')->listdata($params);
		$this->render('index',array('page'=>$page));
	}	
	public function actionUpdate(){
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				if($id==Yii::app()->params['management']['super_role_id']){
					$this->msg(array('state'=>0,'msgwords'=>'超级管理员无法修改'));
				}
				$sql="select a.* from cservice_role as a   where a.role_id='".$id."' ";//die($sql);
				$info=$this->query($sql);
				if(count($info)==0){
					$this->msg(array('state'=>0,'msgwords'=>'角色不存在'));
				}
				$page['info']=$info[0];
				$role_auths=AdminRoleAuthority::get_role_auth($id);
				$page['role_auth']=array();
				foreach($role_auths as $r){
					$page['role_auth'][]=$r['authority_id'];
				}
				//print_r($page['recommend']);
			}else{
				$page['role_auth']=array();
			}
	
		}else{//判断为保存
			$id=$_POST['id']=$_POST['id'];
			if($id==Yii::app()->params['management']['super_role_id']){
				$this->msg(array('state'=>0,'msgwords'=>'超级管理员无法修改'));
			}
			//处理需要的字段
			$field=array();
			$field['role_name']=isset($_POST['role_name'])?$_POST['role_name']:'';
			if($field['role_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'内链名称不能为空'));
			}
			//$field['role_id']=isset($_POST['role_id'])?$_POST['role_id']:'';
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$dbresult=AdminRole::model()->updateAll($field,"role_id='$id'");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('adminRole/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了角色 ID:'.$id.''.$field['role_name'].' ';
			}else{	
				$post=$this->data('AdminRole',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了角色ID：$dbresult".$field['role_name'];
			}
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{
				//新增和修改之后的动作
				$role_leve_arr=isset($_POST['role_levels'])&&is_array($_POST['role_levels'])?$_POST['role_levels']:array();
				$sql="select * from cservice_role_authority where role_id='".$id."'";
				$arr001=$this->query($sql);
				$idarr=array();
				foreach($arr001 as $r){
					$idarr[]=$r['authority_id'];
				}
				
				foreach($idarr as $idw){  //遍历 清除不存在的 数据
					if(!in_array($idw,$role_leve_arr)){ //老的数组 的信息ID 是否 在新的数组上
						$sql="delete from cservice_role_authority where  role_id='$id' and authority_id='".$idw."' ";
						Yii::app()->db->createCommand($sql)->execute();
					}
				}
				
				foreach($role_leve_arr as $r){			
					$post=AdminRoleAuthority::model()->findByAttributes(array('role_id'=>$id,'authority_id'=>$r));
					if(!$post){			
						$post=new AdminRoleAuthority();
						$post->role_id=$id;
						$post->authority_id=$r;
					    $post->save();
					}
				}
				
				
				$this->logs($logs);	
				//成功跳转提示
				$this->msg($msgarr);
			}
	
		}
		$this->render('update',array('page'=>$page));
	}
	public function actionDelete(){
		$this->auth_action('role','role_del');
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		foreach($ids as $id){	
			$id=intval($id);
			$m=AdminRole::model()->findByPk($id);
			$m->delete();
		}
		//die();
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		foreach($_POST['listorders'] as $id=>$order){
			AdminRole::model()->updateAll(array('norder'=>intval($order)),"role_id='".intval($id)."'");  //修改记录
		}
		$this->logs('修改了内链的排序');
		$this->msg(array('state'=>1));
	}

}
?>