<?php
class AdminUserController extends AdminController{

	public function actionIndex(){
		$this->auth_action('admin_show');	
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] =" and(a.csname like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] =" and(a.csno=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.csno    ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['select']="a.*,b.groupname";
		$params['join']="left join cservice_group as b on b.groupid=a.groupid ";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model('cservice')->listdata($params);
		$this->render('index',array('page'=>$page));
	}	
	public function actionUpdate(){
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$info=$this->toArr(AdminUser::model()->findByPk($id));
				if(count($info)==0){
					$this->msg(array('state'=>0,'msgwords'=>'不存在'));
				}
				$page['info']=$info;
				$page['admin_roles']=AdminUser::get_user_role($id);
			}else{
				$page['admin_roles']=AdminUser::get_user_role($id);
			}
			$roles=AdminRole::get_role();
			$page['roles']=array();
			foreach($roles as $r){
				$r['checked']=0;
				foreach($page['admin_roles'] as $r2){
					if($r2['role_id']==$r['role_id']){
						$r['checked']=1;
						break;
					}
				}
				$page['roles'][]=$r;
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			if($_POST['id']==Yii::app()->params['management']['super_admin_id']){
				$this->msg(array('state'=>0,'msgwords'=>'此为网站管理帐号不能更改'));
			}
			$field['csname']=$this->post('csname');
			$cspwd=isset($_POST['cspwd'])?($_POST['cspwd']):'';
			if(verify::check_username($field['csname'])==0){
				$this->msg(array('state'=>0,'msgwords'=>'管理员帐号不合法'));
			}
			if($cspwd!=''){
				if(verify::check_username($cspwd)==0){
					$this->msg(array('state'=>0,'msgwords'=>'密码不合法'));
				}
				$field['cspwd']=AdminUser::password($cspwd);
			}
			$field['csname_true']=isset($_POST['csname_true'])?$_POST['csname_true']:'';
			$k001=$this->query(" select count(1) as total from cservice where csname='".$field['csname']."' and csno!=$id ");
			if($k001[0]['total']>0){
				$this->msg(array('state'=>0,'msgwords'=>'该帐号已存在！'));
			}
			$field['groupid']=$this->post('groupid',0);
			$field['csemail']=$this->post('csemail');
			$field['csmobile']=$this->post('csmobile');
			//如果有post.id 为保存修改，否则为保存新增
			if($id){	
				$dbresult=AdminUser::model()->updateAll($field,"csno=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('adminUser/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了系统用户 ID:'.$id.''.$field['csname'].' ';
			}else{	
				if(verify::check_username($cspwd)==0){
					$this->msg(array('state'=>0,'msgwords'=>'密码不合法'));
				}
				$post=$this->data('AdminUser',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了系统用户ID：$dbresult".$field['csname'];
			}
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{
				//新增和修改之后的动作
				$roles=$this->post('roles',array());
				AdminUser::save_user_roles($id,$roles);
				
				$this->logs($logs);
				//成功跳转提示
				$this->msg($msgarr);
			}
	
		}
		$this->render('update',array('page'=>$page));
	}
	public function actionDelete(){
		$this->auth_action('admin_del');
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		foreach($ids as $id){	
			$id=intval($id);
			$m=AdminUser::model()->findByPk($id);
			$m->delete();
		}
		//die();
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		foreach($_POST['listorders'] as $id=>$order){
			//AdminUser::model()->updateAll(array('norder'=>intval($order)),"csno=".intval($id)."");  //修改记录
		}
		$this->logs('修改了内链的排序');
		$this->msg(array('state'=>1));
	}

}
?>