<?php
class AttachmentController extends AdminController{

	public function actionIndex(){
		$this->auth_action('Attachment_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.resource_url like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.resource_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.resource_id desc      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(Attachment::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));		
	}	
	
	public function actionDelete(){
		$this->auth_action('Attachment_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		$filearr=array();
		foreach($ids as $id){
			$id=intval($id);
			$m=Attachment::model()->findByPk($id);
			if(!$m) continue;			
			$filearr[]=$m->resource_url;
			$file=dirname(__FILE__).'/../../../..'.$m->resource_url;
			if(file_exists($file)){
				unlink($file);
			}
			$m->delete();
		
		}
		$this->logs('删除了附件'.implode('|',$filearr));
		$this->msg(array('state'=>1));
	}

}
?>