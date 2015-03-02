<?php
class VisitHistoryController extends UserController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.create_time desc     ";
		$params['pagesize']=Yii::app()->params['company']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$page['listdata']=Dtable::model('user_visit_history')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$real_table=vars::get_field_str('collect_types', $r['table_name'],'table');
			$m2=Dtable::model($real_table)->findByPk($r['info_id']);	
			$r['url']=Cms::model()->set_info_url($this->toArr($m2));
			$r['info_title']=$r['title']=$m2->info_title;
			$r['info_img']=$m2->info_img;
			$r['thumb']=Attachment::simg($m2->info_img);
			$r['type_name']=vars::get_field_str('collect_types', $r['table_name']);		
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		//$this->render('/visit_index',array('page'=>$page));
	}
	//记录浏览信息
	public function actionSave(){
		$allow_table=array('goods');
		$uid=Yii::app()->user->uid;
		$table=$this->get('model');
		if(!in_array($table,$allow_table)){
			$this->msg(array('state'=>0,'msgwords'=>'模型出错~','type'=>'json'));
		}
		$info_id=intval($this->get('info_id'));
		if($info_id==0){
			$this->msg(array('state'=>0,'msgwords'=>'ID出错~','type'=>'json'));
		}
		$m2=Dtable::model($table)->findByPk($info_id);
		if(!$m2){
			$this->msg(array('state'=>0,'msgwords'=>'ID不存在~','type'=>'json'));
		}
		$m=UserVisitHistory::model()->findByAttributes(array('info_id'=>$info_id,'uid'=>$uid));
		if($m){
			$this->msg(array('state'=>0,'msgwords'=>'您已经浏览啦~','type'=>'json'));
		}
		$m=new UserVisitHistory();
		$m->uid=$uid;
		$m->model_id=7;
		$m->create_time=time();
		$m->info_id=$info_id;
		$m->save();
		$this->msg(array('state'=>1,'msgwords'=>'记录成功!','type'=>'json'));				
	}
	

	//删除信息
	public function actionDelete(){
		$uid=Yii::app()->user->uid;
		$id=intval($this->get('id'));
		$m=UserVisitHistory::model()->findByPk($id);
		if($m->uid!=$uid){
			$this->msg(array('state'=>0,'msgwords'=>'无权限','type'=>'json'));
		}
		$m->delete();
		$this->msg(array('state'=>1,'msgwords'=>'操作成功','type'=>'json'));
	}
	
}