<?php
class UserPointsController extends AdminController{

	public function actionIndex(){
		$this->auth_action('UserPoints_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.uid like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='uid'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.uid=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.points_id desc      ";
		$params['join']="left join user_list as u on u.uid=a.uid";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(UserPoints::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('UserPoints_edit');			
				$info=$this->toArr(UserPoints::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('UserPoints_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['uid']=$this->post('uid');
			if($field['uid']==''){
				$this->msg(array('state'=>0,'msgwords'=>'会员ID不能为空'));
			}
			$field['points_reason']=$this->post('points_reason');
			$field['points']=$this->post('points');
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('UserPoints_edit');
				$dbresult=UserPoints::model()->updateAll($field,"uid=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('userPoints/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了积分 uID:'.$id.''.$field['uid'].' ';
			}else{	
				$this->auth_action('UserPoints_add');
				$post=$this->data('UserPoints',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了积分uID：$dbresult".$field['uid'];
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
		$this->auth_action('UserPoints_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=UserPoints::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了积分ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}

}
?>