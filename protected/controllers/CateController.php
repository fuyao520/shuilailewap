<?php
class CateController extends HomeController{
	public function filters(){
		return array (
			array (
					'COutputCache',
					'duration' => 3600*24*0,
					'varyByParam' => array('from','cate_id','cname_py','game_type','isnet','order','plat','p','search_txt','uid','tag'),							
					'dependency' => array(
							'class'=>'CDbCacheDependency',
							'sql'=>'SELECT MAX(log_id) FROM cservice_aclog',  //根据管理员操作日志去检测缓存是否失效
					)
						
			)
		);
	}
	
	/*默认通用分类,所有分类栏目都可以用该动作处理,如果需特殊处理，请重写方法，或 添加判断*/
	public function actionIndex(){
		$page=$this->cateinit();		
		$params=$page['params'];
		$page['listdata']=Cms::model()->info_list($params);				
		$this->renderPartial('/'.$page['cate']['csetting']['templates_display'],array('page'=>$page));		
	}
	//水
	public function actionGoods(){
		$page=$this->cateinit();
		$params=$page['params'];
		$brand=intval($this->get('brand'));
		$area=intval($this->get('area'));
		$guige=intval($this->get('guige'));
		$order=intval($this->get('order'));
	
		$_GET['search_txt']=isset($_GET['search_txt'])?str_replace(array('"',"'"),'',strip_tags($_GET['search_txt'])):0;
		$key=$_GET['search_txt'];
		
		$params['andwhere']='';
		$params['ordersql']='';
		
		$regionId=$area;
		if($regionId){
			$regionRow=Linkage::model()->findByPk($regionId);
			if(!$regionRow){
				$this->msg(array('state'=>-1,'msgwords'=>'区域错误'));
			}
			if($regionRow->linkage_type_id!=1){
				$this->msg(array('state'=>-1,'msgwords'=>'区域错误02'));
			}
			if($regionRow->linkage_deep==4){
				$page['areaId']=$regionId;		
			}
			if($regionRow->linkage_deep==5){
				$page['areaId']=$regionRow->parent_id;
				$page['streetId']=$regionId;
				
			}
			if($regionRow->linkage_deep==6){
				$regionCommRow=Linkage::model()->findByPk($regionRow->parent_id);
				$page['areaId']=$regionCommRow->parent_id;
				$page['streetId']=$regionRow->parent_id;
				$page['communityId']=$regionId;
			}
			$params['joinsql']="left join (select * from company_region_water group by info_id,region_id) as bc on bc.info_id=l.info_id and bc.region_id=$regionId ";
			$params['andwhere'] .=" and bc.region_id is not null ";
			$params['group']="group by bc.uid ";
			
			//$params['debug']=1;
				
		}
		
		
		if($_GET['search_txt']){
			$params['pagesize']=20;
			$params['pageurl']="/search/".$_GET['search_txt']."/{p}.html";
			$params['andwhere'] .=" and (l.info_tags like '%".$_GET['search_txt']."%' or l.info_title like '%".$_GET['search_txt']."%') ";
		}
		if($brand){
			$g_cates=Linkage::model()->get_linkage_data(17);
			$params['andwhere'].=" and (l.brand='$brand')";
		}
		
		if($guige!=''){
			$params['andwhere'].=" and (l.guige=".$guige.")";
		}
		
		$params_order=array('1'=>'downloads','2'=>'score');
		foreach($params_order as $k=>$r){
			if($k==$order){
				$params['ordersql']="order by ".$r." desc";
			}
		}
		$params['pageurl']="/goods-water-$area-$brand-$guige-$key-$order-{p}.html";
		//$params['debug']=1;
	
		$page['listdata']=Cms::model()->info_list($params);
	
		
				
		
		
		
		$this->renderPartial('/'.$page['cate']['csetting']['templates_display'],array('page'=>$page));
	}
	
	
	
	
	/*进入分类的时候 的判断 和 得到一些共用的变量，方便其他扩展*/
	private function cateinit(){
		parent::init();
		$page=array();
		//可传入分类的拼音，或者 ID（建议传入ID）
		$_GET['cate_id']=$this->get('cate_id');
		$_GET['cname_py']=$this->get('cname_py');
	
		if($_GET['cate_id']=='' &&  $_GET['cname_py']==''){
			$this->msg(array('state'=>-1,'msgwords'=>'您访问的地址有误01'));
		}
		if($_GET['cate_id']==''&&$_GET['cname_py']!=''){
			$sql="select cate_id from info_category where cname_py='".$_GET['cname_py']."' and cate_host='' limit 0,1 ";
			//如果相同的url目录,根据域名检测不同的分类   $domain_arr   对应 栏目的 url目录=>域名
			//$domain_arr=arary('news'=>'news','tupian'=>'p');
			$domain_arr=array();
			$pre_domain=str_ireplace('.'.Yii::app()->params['basic']['sitedomain'],'',$_SERVER['HTTP_HOST']);
			if(in_array($pre_domain,$domain_arr)){
				$cosql="select count(*) as total from info_category where cname_py='".$_GET['cname_py']."' ";
				$a['list']=Yii::app()->db->createCommand($cosql)->queryAll();
				if($a['list'][0]['total']>1){
					$cate_host='http://'.$pre_domain.'.'.Yii::app()->params['basic']['sitedomain'];
					$sql="select cate_id from info_category where cname_py='".$_GET['cname_py']."' and cate_host='".$cate_host."' limit 0,1 ";//echo $sql;
				}else{
					$sql="select cate_id from info_category where cname_py='".$_GET['cname_py']."' limit 0,1 ";
				}
			}
			$rscate01['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($rscate01['list'])==0){
				$this->msg(array('state'=>-1,'msgwords'=>'您访问的地址有误02'));
			}
			$_GET['cate_id']=$rscate01['list'][0]['cate_id'];
		}
		if(!isset(Cms::model()->categorys[$_GET['cate_id']])){
			$this->msg(array('state'=>-1,'msgwords'=>'您访问的地址有误03'));
		}
	
		//当前分类
		$page['cate']=Cms::model()->categorys[$_GET['cate_id']];
	
		//取得分类的模型的字段
		$page['model_field']=Cms::model()->get_info_cate_model_field($page['cate']['model_id']);
	
		//关联分类（侧边导航）
		$page['relation_cates']=InfoCategory::model()->cate_son($page['cate']['relation_cate_id']);
		if($page['cate']['relation_cate_id']==0){
			$page['cate']['relation_cate_id']=$page['cate']['cate_id'];
		}
		$page['relation_cate_top']=Cms::model()->categorys[$page['cate']['relation_cate_id']];
	
		//print_r($page['relation_cates']);
	
		//面包屑导航
		$parent=Cms::model()->cate_father($page['cate']['cate_id']);
		$page['snav']=Cms::model()->html_snav($parent);
	
		//当前分类的所有文档和分页
		if(isset($page['cate']['csetting']['pagesize']) && $page['cate']['csetting']['pagesize']>=1){
			$pagesize=$page['cate']['csetting']['pagesize'];
		}else{
			$pagesize=Yii::app()->params['basic']['pagesize'];
		}
		//手机的简洁页码
		if($this->from=='mobile'){
			$params['pageshowtype']=7;
		}
		
		$page['params']=array('cate_id'=>$page['cate']['cate_id'],'p'=>$_GET['p'],'pagesize'=>$pagesize);
		//$page['params']['debug']=1;
		//设置模版
		if(!isset($page['cate']['csetting']['templates_display'])||$page['cate']['csetting']['templates_display']==''){
			$page['cate']['csetting']['templates_display']='list.php';
		}
		if(!isset($page['cate']['csetting']['templates_list'])||$page['cate']['csetting']['templates_list']==''){
			$page['cate']['csetting']['templates_list']='default.php';
		}
		$page['cate']['csetting']['templates_display']=str_replace('.php','',$page['cate']['csetting']['templates_display']);
		return $page;
	}
	
	
}