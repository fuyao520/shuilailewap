<?php
class InfoPhotoController extends UserController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.create_time desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$page['listdata']=Dtable::model('info_photo')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){			
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		$this->render('/photo_index',array('page'=>$page));
	}
	
	public function actionUpdate(){
		$page=array();
		$uid=Yii::app()->user->uid;
		if(!$_POST){
			$id=$this->get('id');
			$m=InfoPhoto::model()->findByPk($id);	
			if($m){				
				$page['info']=$this->toArr($m);
			}else{
				
			}
			$page['resource_list']=Attachment::model()->get_attachment('info_photo-'.$id);
			$params=array();
			$params['where']="and uid=$uid";
			$params['pagesize']=20;	
			$params['select']=" a.*,(select count(1) from comment_list b where b.fromid=concat('info_photo','-',a.info_id) ) as comments_total ";		
			$page['listdata']=Dtable::model('info_photo')->listdata($params);
			$list=$page['listdata']['list'];
			$page['listdata']['list']=array();
			foreach($list as $r){
				$r['resource_list']=Attachment::model()->get_attachment('info_photo-'.$r['info_id']);
				$r['url']=Cms::model()->set_info_url($r);
				$page['listdata']['list'][]=$r;
			}
			
			
			
			
		}else{					
			$id=$_POST['id']=intval($_POST['id']);			
			$m=InfoPhoto::model()->findByPk($id);		
			//如果有post.id 为保存修改，否则为保存新增
			if(!$m){
				$m=new InfoPhoto();
			}			
			$m->uid=$uid;
			$m->info_editor=Yii::app()->user->uname;
			$goods_url=helper::escape($this->post('goods_url'),1);
			if(!preg_match('~\/goods\/(\d+)\.html~',$goods_url,$result)){
				$this->msg(array('state'=>0,'msgwords'=>'宝贝链接填写错啦！','type'=>'json'));
			}
			$m->goods_id=$result[1];
			$mp=Dtable::model('goods')->findByPk($m->goods_id);
			if(!$mp){
				$this->msg(array('state'=>0,'msgwords'=>'宝贝链接有误噢！','type'=>'json'));
			}
			
			
			$m->info_body=helper::escape($this->post('info_body'),1);
			if(strlen($m->info_body)<5){
				$this->msg(array('state'=>0,'msgwords'=>'请填写晒单简介，字数不能少于5','type'=>'json'));
			}
			
			
			$m->info_title=mb_substr(str_replace("&nbsp;",'',strip_tags($m->info_body)),0,30,'utf-8');
			$m->info_desc=mb_substr(str_replace("&nbsp;",'',strip_tags($m->info_body)),0,70,'utf-8');
			$m->audit=1;
			$m->info_order=50;
			$m->create_time=time();
			$m->info_img=isset($_POST['resource_data']['resource_url'][1])?urldecode($_POST['resource_data']['resource_url'][1]):'';
			if(!isset($_POST['resource_data']['resource_url'][1]) && !$_POST['resource_data']['resource_url'][1]){
				$this->msg(array('state'=>0,'msgwords'=>'至少要上传一张图片噢~','type'=>'json'));
			}
			
			$m->last_cate_id=46;			
			$dbresult=$m->save();	
			
			$msgarr['type']='json';
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
								
			}else{
				$id=$m->primaryKey;
			}
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{	

				$msgarr['id']=$id;
				//保存资源图片
				$resource_data=isset($_POST['resource_data'])&&is_array($_POST['resource_data'])?$_POST['resource_data']:array();
				//print_r($resource_data);
				Attachment::model()->save_attachment('info_photo-'.$id,$resource_data);
				//成功跳转提示
				$this->msg($msgarr);
			}
			
			
			
		}
		$this->render('/photo_update',array('page'=>$page));
	}
	
	//删除信息
	public function actionDelete(){
		$uid=Yii::app()->user->uid;
		$id=intval($this->get('id'));
		$m=InfoPhoto::model()->findByPk($id);
		if($m->uid!=$uid){
			$this->msg(array('state'=>0,'msgwords'=>'无权限','type'=>'json'));
		}
		$m->delete();
		$this->msg(array('state'=>1,'msgwords'=>'操作成功','type'=>'json'));
	}
	
	//攒一个，喜欢
	public function actionSaveLove(){
		$uid=Yii::app()->user->uid;
		$arr=array();
		if(isset(Yii::app()->session['photo'])){
			$arr=Yii::app()->session['photo'];
		}		
		$info_id=intval($this->post('info_id'));
		if($info_id==0){
			$this->msg(array('state'=>0,'msgwords'=>'ID出错~','type'=>'json'));
		}
		if(isset($arr[$info_id])&&$arr[$info_id]==1){
			$this->msg(array('state'=>0,'msgwords'=>'已经赞过啦~','type'=>'json'));
		}
		$m2=InfoPhoto::model()->findByPk($info_id);
		if(!$m2){
			$this->msg(array('state'=>0,'msgwords'=>'ID不存在~','type'=>'json'));
		}		
		$m2->loves+=1;
		$m2->save();
		$arr[$info_id]=1;
		Yii::app()->session['photo']=$arr;
		
		$this->msg(array('state'=>1,'msgwords'=>'人气+1','type'=>'json'));
	}
	
}