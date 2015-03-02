<?php
class SiteSeoController extends AdminController{

	public function actionIndex(){
		$this->auth_action('SiteSeo_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.mark like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.displayorder,a.id      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(SiteSeo::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('SiteSeo_edit');			
				$info=$this->toArr(SiteSeo::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('SiteSeo_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			$m=SiteSeo::model()->findByPK($id);
			if(!$m){
				$m=new SiteSeo();
			}
			
			$m->mark=$this->post('mark');
			if($m->mark==''){
				$this->msg(array('state'=>0,'msgwords'=>'seo页面名称不能为空'));
			}
			$m->url=$this->post('url');
			$m->seo_title=$this->post('seo_title');
			$m->seo_keyword=$this->post('seo_keyword');
			$m->seo_description=$this->post('seo_description');
			$m->displayorder=intval($this->post('displayorder'));
			
			$dbresult=$m->save();
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('SiteSeo_edit');
				$msgarr=array('state'=>1,'url'=>$this->createUrl('siteSeo/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了seo页面 ID:'.$id.''.$m->mark.' ';
			}else{	
				$this->auth_action('SiteSeo_add');				
				$id=$m->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了seo页面ID：$dbresult".$m->mark;
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
		$this->auth_action('SiteSeo_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=SiteSeo::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了seo页面ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('SiteSeo_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=SiteSeo::model()->findByPk($id);
			if(!$m) continue;
			$m->displayorder=$order;
			$m->save();		
		}
		$this->logs('修改了seo页面的排序');
		$this->msg(array('state'=>1));
	}

}
?>