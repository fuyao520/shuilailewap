<?php
class InfoCaseController extends CompanyController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->company_user->uid;
		$params['where']="and a.company_id=$uid  ";
		$params['order']="  order by a.create_time desc     ";
		$params['pagesize']=Yii::app()->params['company']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$page['listdata']=Dtable::model('info_case')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){			
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		$this->render('/case_index',array('page'=>$page));
	}
	
	public function actionUpdate(){
		$page=array();
		$uid=Yii::app()->company_user->uid;
		if(!isset($_POST['id'])){
			$id=$this->get('id');
			if($id){
				$m=Dtable::model('info_case')->findByAttributes(array('company_id'=>$uid,'info_id'=>$id));
				if(!$m){
					$this->msg(array('state'=>-2,'msgwords'=>'数据出错'));
				}
				$page['info']=$this->toArr($m);
				$page['resource_list']=Attachment::model()->get_attachment('info_case-'.$id);
			}else{
	
			}
		}else{
			$id=$_POST['id']=intval($_POST['id']);			
			//print_r($_POST);die();
			//处理需要的字段
			$field=array();
			$field['company_id']=$uid;	
			$field['company_name']=Yii::app()->company_user->company_name;
			$field['info_title']=helper::escape($this->post('info_title'),1);
			$field['audit']=0;
			$field['last_cate_id']=6;
			$field['info_order']=50;
			$field['stone_cate_id']=intval($this->post('stone_cate_id'));
			$field['year']=intval($this->post('year'));
			$field['city_id']=intval($this->post('city_id'));
			$field['work_type']=intval($this->post('work_type'));
			$field['money']=helper::escape($this->post('money'),1);
			$field['case_type']=intval($this->post('case_type'));
			$field['info_img']=helper::escape($this->post('info_img'),1);
			$field['info_body']=helper::escape($this->post('info_body'),1);
			$field['info_desc']=mb_substr(str_replace("&nbsp;",'',strip_tags($field['info_body'])),0,70,'utf-8');
			if(!$field['info_title']){
				$this->msg(array('state'=>0,'msgwords'=>'标题不能为空','type'=>'json'));
			}
			if(!$field['info_body']){
				$this->msg(array('state'=>0,'msgwords'=>'详细介绍不能为空','type'=>'json'));
			}
			if(!$field['stone_cate_id']){
				$this->msg(array('state'=>0,'msgwords'=>'请选择石种类型','type'=>'json'));
			}
			if(!$field['city_id']){
				$this->msg(array('state'=>0,'msgwords'=>'请选择区域','type'=>'json'));
			}
			if(!$field['work_type']){
				$this->msg(array('state'=>0,'msgwords'=>'请选择作品类型','type'=>'json'));
			}
			if(!$field['case_type']){
				$this->msg(array('state'=>0,'msgwords'=>'请选择工程类型','type'=>'json'));
			}
			
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$dbresult=Dtable::model('info_case')->updateAll($field,"info_id=$id");  //修改记录
			}else{
				$field['create_time']=time();
				$post=$this->data('Dtable',$field,'info_case');
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);
			}
				
			$msgarr['type']='json';
				
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{
				//新增和修改之后的动作
	
				$msgarr['id']=$id;
				//保存资源图片
				$resource_data=isset($_POST['resource_data'])&&is_array($_POST['resource_data'])?$_POST['resource_data']:array();
				//print_r($resource_data);
				Attachment::model()->save_attachment('info_case-'.$id,$resource_data);
	
	
				//成功跳转提示
				$this->msg($msgarr);
			}
			}
	
			$this->render('/case_update',array('page'=>$page));
	}
	
}