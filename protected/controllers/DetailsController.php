<?php
class DetailsController extends  HomeController{
	public function filters(){
		return array (
				array (
						'COutputCache',
						'duration' => 3600*24*0,
						'varyByParam' => array('from','cate_id','model_table_name','info_id','p'),
						'dependency' => array(
								'class'=>'CDbCacheDependency',
								'sql'=>'SELECT MAX(log_id) FROM cservice_aclog',  //根据管理员操作日志去检测缓存是否失效
						)
						
	
				)
		);
	}
	public function actionIndex(){
		$page=$this->detail_init();
		$this->render('/'.$page['cate']['csetting']['templates_detail'],array('page'=>$page));
	}
	
	public function actionPhoto(){
		$page=$this->detail_init();
		$page['user']=Dtable::toArr(User::model()->findByPk($page['info']['uid']));		
		$m2=UserProfile::model()->findByPk($page['info']['uid']);
		$page['user']=array_merge($page['user'],Dtable::toArr($m2));
		if(!$page['user']){
			$page['user']=array('uname'=>'','tou_img'=>'','uid'=>'');
		}
		$m3=Dtable::model('goods')->findByPk($page['info']['goods_id']);
		if($m3){
			$page['goods']=Dtable::toArr($m3);
			$page['goods']['url']=Cms::model()->set_info_url($page['goods']);
			$page['goods']['thumb']=Attachment::simg($page['goods']['info_img']);
		}
		$this->render('/'.$page['cate']['csetting']['templates_detail'],array('page'=>$page));
	}
	
	private function detail_init(){
		/*
		 //详情页 参数 可选择 ,
		1. last_cate_id+info_id
		2. last_cate_id+info_py
		3. cname_py+info_id
		4. cname_py+info_py
		5. model_table_name+info_id
		6. model_table_name+info_py
		
		*/
		$_GET['cate_id']=$this->get('cate_id');
		$_GET['cname_py']=$this->get('cname_py');
		$_GET['info_id']=$this->get('info_id');
		$_GET['info_py']=isset($_GET['info_py'])?str_replace(array('"',"'"),'',$_GET['info_py']):0;
		$_GET['model_table_name']=$this->get('model_table_name');
		
		//下面六种情况的目的就是为了得到$_GET 的  cate_id 和  info_id
		if($_GET['cate_id'] &&  $_GET['info_id']){
		
		}else if($_GET['cate_id']&&$_GET['info_py']){
			if(!isset(Cms::model()->categorys[$_GET['cate_id']])){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误041'));
			}
			$page['cate']=Cms::model()->categorys[$_GET['cate_id']];
			$sql="select info_id from ".$page['cate']['model_table_name']." where info_py='".$_GET['info_py']."' and last_cate_id=".$page['cate']['cate_id']." limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误021'));
			}
			$_GET['info_id']=$a['list'][0]['info_id'];
		
		
		}else if($_GET['cname_py']&&$_GET['info_id']){
			$sql="select cate_id from info_category where cname_py='".$_GET['cname_py']."' limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误03'));
			}
			$_GET['cate_id']=$a['list'][0]['cate_id'];
		
		}else if($_GET['cname_py']&&$_GET['info_py']){
			$sql="select cate_id from info_category where cname_py='".$_GET['cname_py']."' limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误04'));
			}
			$_GET['cate_id']=$a['list'][0]['cate_id'];
			if(!isset(Cms::model()->categorys[$_GET['cate_id']])){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误041'));
			}
			$page['cate']=Cms::model()->categorys[$_GET['cate_id']];
			$sql="select info_id from ".$page['cate']['model_table_name']." where info_py='".$_GET['info_py']."' and last_cate_id=".$_GET['cate_id']." limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误042'));
			}
			$_GET['info_id']=$a['list'][0]['info_id'];
		
		
		
		}else if($_GET['model_table_name']&&$_GET['info_id']){
			$sql="select * from model where model_table_name='".$_GET['model_table_name']."' limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误05'));
			}
			$page['model']=$a['list'][0];
			$sql="select * from ".$page['model']['model_table_name']." where info_id='".$_GET['info_id']."' limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误051'));
			}
			$_GET['info_id']=$a['list'][0]['info_id'];
			$_GET['cate_id']=$a['list'][0]['last_cate_id'];
		
		
		}else if($_GET['model_table_name']&&$_GET['info_py']){
			$sql="select * from model where model_table_name='".$_GET['model_table_name']."' limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误06'));
			}
			$page['model']=$a['list'][0];
			$sql="select * from ".$page['model']['model_table_name']." where info_py='".$_GET['info_py']."' limit 0,1 ";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($a['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误061'));
			}
			$_GET['info_id']=$a['list'][0]['info_id'];
			$_GET['cate_id']=$a['list'][0]['last_cate_id'];
		}else{
			$this->msg(array('state'=>2,'msgwords'=>'您访问的地址有误00'));
		}
		
		//参数判断结束，cate_id 和info_id 已得到
		
		if(!isset(Cms::model()->categorys[$_GET['cate_id']])){
			$this->msg(array('state'=>-2,'msgwords'=>'您访问的地址有误001'));
		}
		//当前分类
		$page['cate']=Cms::model()->categorys[$_GET['cate_id']];
		
		//取得分类的模型的字段
		$page['model_field']=Cms::model()->get_info_cate_model_field($page['cate']['model_id']);
		
		//关联分类（侧边导航）
		$page['relation_cates']=Cms::model()->cate_son($page['cate']['relation_cate_id']);
		if($page['cate']['relation_cate_id']==0){
			$page['cate']['relation_cate_id']=$page['cate']['cate_id'];
		}
		$page['relation_cate_top']=Cms::model()->categorys[$page['cate']['relation_cate_id']];
		
		//print_r($page['relation_cates']);
		
		//面包屑导航
		$parent=Cms::model()->cate_father($page['cate']['cate_id']);
		$page['snav']=Cms::model()->html_snav($parent);
		
		
		//如果是预览
		if($_GET['info_id']==88888888 && isset($_GET['preview']) && $_GET['preview']==1){
			$page=$this->preview($page);
		}else{
			//取得本条信息
			$info=Cms::model()->info_content($page['cate']['model_table_name'],$_GET['info_id']);
			$page['info']=$info;
			if(!$page['info']) {
				$this->msg(array('state'=>-2,'msgwords'=>'您访问的文档不存在或被删除002'));
			}
			$body_data=Cms::model()->info_content_page($page['info'],$_GET['p']);
			$page['info']['info_body']=$body_data['content'];
			$page['info']['pagebar']=$body_data['pagebar'];
		
			//获取评论数量
			$sql="select count(1) as total from comment_list where fromid='".$page['cate']['model_table_name'].'-'.$_GET['info_id']."'";
			$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
			$page['info']['comment_total']=$a['list'][0]['total'];
		
			//取得上一篇下一篇
			$page['prev_next']=Cms::model()->info_prev_next($page['cate']['model_table_name'],$_GET['info_id'],$page['cate']['cate_id']);
		}
		$info_models=InfoModel::model()->get_model();
		$page['model_cate']=InfoModel::model()->get_child_model_cates($info_models,$page['cate']['model_id']);
		//print_r($page['model_list']);		
		foreach($page['model_cate'] as $r){
			$page[$r['model_table_name']]=Cms::model()->get_model_list_data($r['model_table_name'],$page['info']['info_id']);
		}
		$page['relation_data']=Cms::model()->get_info_info_relation_infos($page['info']['info_id'],$page['cate']['model_id']);
		
		//设置模版
		if(!isset($page['cate']['csetting']['templates_detail'])||$page['cate']['csetting']['templates_detail']==''){
			$page['cate']['csetting']['templates_detail']='detail.php';
		}
		$page['cate']['csetting']['templates_detail']=str_replace('.php','',$page['cate']['csetting']['templates_detail']);
		return $page;
		
	}
	
	
	//给文章增加点击数
	public function actionVisit(){
		$cate_id=intval($this->get('cate_id'));
		$info_id=intval($this->get('info_id'));
		if(!isset(Cms::model()->categorys[$cate_id])){
			$this->msg(array('state'=>0,'msgwords'=>'cate error','type'=>'getjson'));
		}
		$table=Cms::model()->categorys[$cate_id]['model_table_name'];
		$m=Dtable::model($table)->findByPk($info_id);
		if(!$m){
			$this->msg(array('state'=>0,'msgwords'=>'id error','type'=>'getjson'));
		}
		$m->info_visitors++;
		$m->save();
		$this->msg(array('state'=>1,'msgwords'=>'ok','type'=>'getjson'));
			
	}
	/*
	 * 预览
	 * 
	 */
	private function preview($page){
		if(!isset($page)){
			die('error');
		}	
		foreach($_POST as $key=>$r){
			if(preg_match('~^extern__(.*?)$~',$key,$arr)){
				$page['info']['extern_array'][$arr[1]]=$r;
			}else{
				$page['info'][$key]=$r;
			}
		}
		if(!isset($page['info']['id'])||!$page['info']['id']){
			$page['info']['info_id']=$this->get('info_id');
		}else{
			$page['info']['info_id']=intval($this->post('id'));
		}
		$page['info']['url']='#';
		$page['info']['info_title']=$page['info']['title']=$this->post('info_title');
		$page['info']['info_img']=$this->post('info_img');
		$page['info']['thumb']=Attachment::simg($this->post('info_img'));
		$page['info']['info_body']=$this->post('info_body');
		$page['info']['create_time']=strtotime($this->post('create_time'));
		$page['info']['info_from']=$this->post('info_from');
		$page['info']['info_desc']=$this->post('info_desc');
		
		$page['info']['info_tags']=$this->post('info_tags');
		
		$page['info']['last_cate_id']=$page['cate']['cate_id'];
		$page['info']['prev_next']=array('prev'=>array(),'next'=>array());
		$page['info']['comment_total']=0;
		$page['info']['']=0;
		$page['info']['info_visitors']=0;
		//资源图片
		$page['info']['resource']=array();
		$page['info']['resource_url']=isset($page['info']['resource_url'])?$page['info']['resource_url']:array();
		$page['info']['resource_order']=isset($page['info']['resource_order'])?$page['info']['resource_order']:array();
		foreach($page['info']['resource_url'] as $k=>$r){
			if($r!=''){
				$resource_order=intval($page['post']['resource_order'][$k]);
				$page['info']['resource'][]=array('resource_url'=>$r,'thumb'=>Attachment::simg($r),'resource_order'=>$resource_order,'resource_id'=>$k);
			}
		}
		return $page;
	}
	
	
	
	
}