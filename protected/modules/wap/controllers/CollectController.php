<?php
class CollectController extends UserController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.add_time desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['pageshow']=$this->pageshow;
		$params['select']="a.* ";
		$page['listdata']=Dtable::model('user_collect')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$real_table=vars::get_field_str('collect_types', $r['table_name'],'table');
			$m2=Dtable::model($real_table)->findByPk($r['info_id']);
			if(!$m2){
				$m=UserCollect::model()->findByPk($r['collect_id']);
				$m->delete();
				continue;
			}	
			$r['url']=Cms::model()->set_info_url($this->toArr($m2));
			$r['info_title']=$r['title']=$m2->info_title;
			$r['info_img']=$m2->info_img;
			$r['thumb']=Attachment::simg($m2->info_img);
			$r['type_name']=vars::get_field_str('collect_types', $r['table_name']);		
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		$this->render('/collect_index',array('page'=>$page));
	}
	//收藏信息
	public function actionSave(){
		$allow_table=array('goods');
		$uid=Yii::app()->user->uid;
		$table=$this->post('model');
		if(!in_array($table,$allow_table)){
			$this->msg(array('state'=>0,'msgwords'=>'模型出错~','type'=>'json'));
		}
		$info_id=intval($this->post('info_id'));
		if($info_id==0){
			$this->msg(array('state'=>0,'msgwords'=>'ID出错~','type'=>'json'));
		}
		$m2=Dtable::model($table)->findByPk($info_id);
		if(!$m2){
			$this->msg(array('state'=>0,'msgwords'=>'ID不存在~','type'=>'json'));
		}
		$m=UserCollect::model()->findByAttributes(array('info_id'=>$info_id,'uid'=>$uid));
		if($m){
			$this->msg(array('state'=>0,'msgwords'=>'您已经收藏啦~','type'=>'json'));
		}
		$m=new UserCollect();
		$m->uid=$uid;
		$m->table_name=$table;
		$m->add_time=time();
		$m->info_id=$info_id;
		$m->save();				
		$m2->loves+=1;
		$m2->save();
		$this->msg(array('state'=>1,'msgwords'=>'收藏成功!','type'=>'json'));				
	}
	//取消收藏信息
	public function actionCancel(){
		$allow_table=array('goods');
		$uid=Yii::app()->user->uid;
		$table=$this->post('model');
		if(!in_array($table,$allow_table)){
			$this->msg(array('state'=>0,'msgwords'=>'模型出错~','type'=>'json'));
		}
		$info_id=intval($this->post('info_id'));
		if($info_id==0){
			$this->msg(array('state'=>0,'msgwords'=>'ID出错~','type'=>'json'));
		}
		$m2=Dtable::model($table)->findByPk($info_id);
		if(!$m2){
			$this->msg(array('state'=>0,'msgwords'=>'ID不存在~','type'=>'json'));
		}
		$m=UserCollect::model()->findByAttributes(array('info_id'=>$info_id,'uid'=>$uid));
		if(!$m){
			$this->msg(array('state'=>0,'msgwords'=>'请先进行收藏~','type'=>'json'));
		}
		$m->delete();
		if($m2->loves>0){
			$m2->loves-=1;
			$m2->save();
		}
		$this->msg(array('state'=>1,'msgwords'=>'成功取消!','type'=>'json'));
	}
	

	//删除信息
	public function actionDelete(){
		$uid=Yii::app()->user->uid;
		$id=intval($this->get('id'));
		$m=Dtable::model('user_collect')->findByPk($id);
		if($m->uid!=$uid){
			$this->msg(array('state'=>0,'msgwords'=>'无权限','type'=>'json'));
		}
		$m->delete();
		$this->msg(array('state'=>1,'msgwords'=>'操作成功','type'=>'json'));
	}
	
}