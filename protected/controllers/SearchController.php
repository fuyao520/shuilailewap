<?php
class SearchController extends HomeController{

	public function filters(){
		return array (
				array (
					'COutputCache +index',
					'duration' => 3600*24*1,
					'varyByParam' => array('from','search_type','search_txt','p'),
					'dependency' => array(
							'class'=>'CDbCacheDependency',
							'sql'=>'SELECT MAX(log_id) FROM cservice_aclog',  //根据管理员操作日志去检测缓存是否失效
					)
				)
		);
	}
	
	//全文检索，xunsearch插件
	public function actionIndex(){
		$pagesize=20;
		//判断搜索类型是否存在
		$a=0;
		if($this->get('search_type')=='game'){
			$seclass='search_game';
			$table='game_mobile';
		}else{
			$_GET['search_type']='article';
			$seclass='search_article';
			$table='article';
		}
		
		
		$search_txt=$_GET['search_txt']=isset($_GET['search_txt'])?str_replace(array('"',"'"),'',strip_tags($_GET['search_txt'])):0;
		//Yii::app()->search->setQuery('cname:'.$search_txt); 
		//echo time().$search_txt;
		$se=Yii::app()->$seclass;		
		$offset=($_GET['p']-1)*$pagesize;
		$docs =$se->setLimit($pagesize,$offset)
		->setSort('create_time') // 按 chrono 字段的值倒序
		->search($search_txt); // 取得搜索结果文档
		$list=array();
		foreach ($docs as $mr){
		   // 其中常用魔术方法：percent() 表示匹配度百分比, rank() 表示匹配结果序号
		  // echo $r->rank() . ' --- ['.date("Y-m-d", $r->create_time).']' . $r->info_title . " [" . $r->percent() . "%] - <br>";
			$m=Dtable::model($table)->findByPk($mr->info_id);
			if($m){
				$arr=Dtable::toArr($m);
				$r=array();
				$r['thumb']=Attachment::simg($arr['info_img']);
				$r['title']=$arr['info_title'];
				$r['tag_list']=Cms::model()->get_info_tags($arr['info_tags']);
				$r['url']=Cms::model()->set_info_url($arr);
				$r['create_time']=$arr['create_time'];
				$r=array_merge($r,$arr);
				$list[]=$r;
			}
		}
		$total=$se->getLastCount();
		$pagearr=helper::pagehtml(array('total'=>$total,"pagesize"=>$pagesize,"show"=>8));
		
		$page['listdata']['list']=$list;
		$page['listdata']['pagearr']=$pagearr;
		//echo '共搜索到 '.$total.'条结果';
		$this->render('/search',array('page'=>$page));
	}
/*
	public function actionIndex(){
		$params=array();
		$params['where'] ='';
		$params['pagebar']=1;
		$_GET['search_type']='article';		
		//判断搜索类型是否存在
		$a=0;
		$type=$this->get('search_type');
		foreach(vars::$fields['search_type'] as $r){
			if($type==$r['value']){
				$a=1;
				break;
			}
		}
		if($a==0){
			$type='article';
		}
		$search_txt=$_GET['search_txt']=isset($_GET['search_txt'])?str_replace(array('"',"'"),'',strip_tags($_GET['search_txt'])):0;
				
		if(!$_GET['search_txt']){
			$params['where'] =' and 1=2 ';
		}
		
		$model_name=$_GET['search_type'];		
		$pagesize=20;
		$pageurl="";
		//$params['debug']=1;
		// $params['where'] .=" and (match(`info_title`,`info_tags`,`info_py`,`info_desc`) against('".$_GET['search_txt']."' IN BOOLEAN MODE))";
		$params['where'] .=" and ( a.info_title like '%".$search_txt."%' or  a.info_tags like '%".$search_txt."%'  )";	
		$params['pageshow']=8;
		$page['listdata']=Dtable::model($model_name)->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$r['url']=Cms::model()->set_info_url($r);
			$r['title']=$r['info_title'];
			$r['thumb']=Attachment::simg($r['info_img']);
			$r['tag_list']=Cms::model()->get_info_tags($r['info_tags']);
			$list[]=$r;
		}
		$page['listdata']['list']=$list;//print_r($page['listdata']);
		$this->render('/search',array('page'=>$page));
	}
	*/
}