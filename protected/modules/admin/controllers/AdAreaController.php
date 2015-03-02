<?php
class AdAreaController extends AdminController{

	public function actionIndex(){
		$this->auth_action('AdArea_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.area_name like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.area_id=".intval($this->get('search_txt')).") ";
		}
		$params['select']=" a.*,(select count(*) from ad_list where area_id=a.area_id) as totals";
		$params['order']="  order by a.area_id      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(AdArea::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('AdArea_edit');			
				$info=$this->toArr(AdArea::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'文档不存在'));
				}
				$page['info']=$info;
			}else{
				$this->auth_action('AdArea_add');
			}
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['area_name']=$this->post('area_name');
			if($field['area_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'广告位名称不能为空'));
			}
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('AdArea_edit');
				$dbresult=AdArea::model()->updateAll($field,"area_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('adArea/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了广告位 ID:'.$id.''.$field['area_name'].' ';
			}else{	
				$this->auth_action('AdArea_add');
				$post=$this->data('AdArea',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了广告位ID：$dbresult".$field['area_name'];
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
		$this->auth_action('AdArea_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=AdArea::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了广告位ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('AdArea_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=AdArea::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了广告位的排序');
		$this->msg(array('state'=>1));
	}

}
?>