<?php
class PmListController extends AdminController{

	public function actionIndex(){
		$this->auth_action('PmList_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.pm_title like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.pm_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.pm_id desc      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['select']="a.*,(select count(*) from pm_read as r where r.pm_id=a.pm_id)as pm_reads";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(PmList::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('PmList_edit');			
				$info=$this->toArr(PmList::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('PmList_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			$m=PmList::model()->findByPK($id);
			if(!$m){
				$m=new PmList();
			}			
			
			$m->pm_title=$this->post('pm_title');
			if($m->pm_title==''){
				$this->msg(array('state'=>0,'msgwords'=>'标题不能为空'));
			}
			$m->pm_body=helper::escape($this->post('pm_body'));
			$m->uid_post=intval($this->post('uid_post'));
			$m->uid_recv=intval($this->post('uid_recv'));
			$m->pm_type=intval($this->post('pm_type'));
			if($m->pm_type==0){
				$this->msg(array('state'=>0,'msgwords'=>'请选择类型'));
			}
			$m->post_date=time();
			$dbresult=$m->save();
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('PmList_edit');
				$msgarr=array('state'=>1,'url'=>$this->createUrl('pmList/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了内链 ID:'.$id.''.$m->pm_title.' ';
			}else{	
				$this->auth_action('PmList_add');				
				$id=$m->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了内链ID：$dbresult".$m->pm_title;
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
		$this->auth_action('PmList_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=PmList::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了内链ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('PmList_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=PmList::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了内链的排序');
		$this->msg(array('state'=>1));
	}

}
?>