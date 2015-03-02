<?php
class UserStarController extends AdminController{

	public function actionIndex(){
		$this->auth_action('UserStar_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(uname like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.create_time  desc    ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['join']="left join user_list as b on b.uid=a.uid";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(UserStar::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('UserStar_edit');			
				$info=$this->toArr(UserStar::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('UserStar_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			$m=UserStar::model()->findByPK($id);
			if(!$m){
				$m=new UserStar();
			}
			
			$m->uid=intval($this->post('uid'));
			if($m->uid==''){
				$this->msg(array('state'=>0,'msgwords'=>'用户id不能为空'));
			}			
			$m->reason=$this->post('reason');
			$m->create_time=strtotime($this->post('create_time'));
			$m->cover=$this->post('cover');
			$dbresult=$m->save();
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('UserStar_edit');
				$msgarr=array('state'=>1,'url'=>$this->createUrl('userStar/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了达人 ID:'.$id.''.$m->uid.' ';
			}else{	
				$this->auth_action('UserStar_add');				
				$id=$m->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了达人ID：$id".$m->uid;
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
		$this->auth_action('UserStar_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=UserStar::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了内链ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('UserStar_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=UserStar::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了内链的排序');
		$this->msg(array('state'=>1));
	}

}
?>