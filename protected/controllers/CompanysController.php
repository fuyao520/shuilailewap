<?php
class CompanysController extends HomeController{
	public $page;
	public $distance=0.8;  //800米之内
	public function filters(){
		return array (
			array (
					'COutputCache',
					'duration' => 3600*24*0,
					'varyByParam' => array('from'),
					'dependency' => array(
							'class'=>'CDbCacheDependency',
							'sql'=>'SELECT MAX(log_id) FROM cservice_aclog',  //根据管理员操作日志去检测缓存是否失效
					)
					
			)
		);
    }
    
	public function actionIndex(){
		$page=array();
		
		$brand=intval($this->get('brand'));
		$area=intval($this->get('area'));
		$order=intval($this->get('order'));
		
		$location_x=($this->get('location_x'));
		$location_y=($this->get('location_y'));
		
		$_GET['search_txt']=isset($_GET['search_txt'])?str_replace(array('"',"'"),'',strip_tags($_GET['search_txt'])):0;
		$key=$_GET['search_txt'];
		
		//搜索
		$params['where']='';
		$params['order']="  order by a.company_id      ";
	    $params['join']="left join company_user_list as b on b.uid=a.company_id ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['select']=" a.*";
		$params['smart_order']=1;
		$regionId=$area;
		
		if($brand){
			$params['where'].=" and (a.business_products like '%\"$brand\"%')";
		}
		if($location_x && $location_y){
			$squares=helper::returnSquarePoint($location_x,$location_y,1);
			$params['where'].="
			and location_y<>0 and location_y>".$squares['right-bottom']['lat']."
			and location_y<".$squares['left-top']['lat']."
			and location_x>".$squares['left-top']['lng']."
			and location_x<".$squares['right-bottom']['lng'];
			//$params['debug']=1;
		}
		
		//$params['debug']=1;
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
			$where="and area_id=".$page['areaId'];
			$params['join']="left join (select * from company_region_business group by area_id,uid) as e on e.uid=a.company_id and e.area_id=$regionId ";
			if(isset($page['communityId'])){
				$where=" and region_id=".$page['communityId'];
				$params['join']="left join (select * from company_region_business group by area_id,uid) as e on e.uid=a.company_id and e.region_id=$regionId ";
			}elseif(isset($page['streetId'])){
				$where="and street_id=".$page['streetId'];
				$params['join']="left join (select * from company_region_business group by area_id,uid) as e on e.uid=a.company_id and e.street_id=$regionId ";
			}
			
			$params['where'].=$where.$params['where'];
			
		
		}else{
			
			
		}
		$page['listdata']=Dtable::model(Company::model()->tableName())->listdata($params);//print_r($page['listdata']);die();
		$this->render('/companys',array('page'=>$page));
	}

	
	public function actionDetail(){
		$page=array();
		$id=$this->get('id');
		$m=CompanyUser::model()->findByPk($id);
		if(!$m){
			$this->msg(array('state'=>-1,'msgwords'=>'水站不存在'));
		}
		$m2=Company::model()->findByPk($id);
		if(!$m2){
			$this->msg(array('state'=>-1,'msgwords'=>'水站信息出错'));
		}
		$page['company']=Dtable::toArr($m2);
		
		//经营品牌
		$page['company']['business_product_data']=$page['company']['business_products']?json_decode($page['company']['business_products'],1):array();
		//送水范围
		$page['region_business_data']=CompanyRegionBusiness::model()->get_regions($page['company']['company_id'],1);
		
		
		$params['where']="and a.uid=$id  ";
		$params['order']="  order by a.create_time desc     ";
		$params['pagesize']=10;
		$params['join']="left join goods as b on b.info_id=a.info_id
				";
		$params['select']=" b.*,a.* ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$page['listdata']=Dtable::model('company_water')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$r['thumb']=Attachment::simg($r['info_img']);
			$r['url']=Cms::model()->set_info_url($r);
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		
		
		$this->render('/detail_companys',array('page'=>$page));
	}
	public function actionGetLbsCompanyList(){
		$page=array();
		
		$location_x=$this->get('location_x');
		$location_y=$this->get('location_y');
		$params['order']="  order by a.company_id desc     ";
		$params['pagesize']=10;
		$params['select']=" a.* ";
		$params['pagebar']=1;
		$squares=helper::returnSquarePoint($location_x,$location_y,$this->distance);
		$params['where']=" 
		location_y<>0 and location_y>".$squares['right-bottom']['lat']." 
		and location_y<".$squares['left-top']['lat']." 
		and location_x>".$squares['left-top']['lng']." 
		and location_x<".$squares['right-bottom']['lng'];
		
		$page['listdata']=Dtable::model('company_water')->listdata($params);
		
		$this->msg(array('state'=>1,'data'=>$page['listdata'],'type'=>'json'));
		
	}
	public function actionGetLbsCompanyTotals(){
		$page=array();
		$location_x=$this->get('location_x');
		$location_y=$this->get('location_y');
		$squares=helper::returnSquarePoint($location_x,$location_y,$this->distance);
		$sql="select count(*) as total from company 
		where location_y<>0 and location_y>".$squares['right-bottom']['lat']." 
		and location_y<".$squares['left-top']['lat']." 
		and location_x>".$squares['left-top']['lng']." 
		and location_x<".$squares['right-bottom']['lng'];//echo $sql;
		$a=Yii::app()->db->createCommand($sql)->queryAll();	
		$this->msg(array('state'=>1,'data'=>$a[0]['total'],'type'=>'json'));
	
	}
	public function actionGetMoreLbsCompanyTotals(){
		$page=array();
		$points_data=$this->get('points_data');//print_r( $points_data);die();
		if(!is_array($points_data)) {
			$this->msg(array('state'=>0,'msgwords'=>'data error','type'=>'json'));
		}
		$list=array();
		foreach($points_data as $r){
			$location_x=$r['location_x'];
			$location_y=$r['location_y'];
			$squares=helper::returnSquarePoint($location_x,$location_y,$this->distance);
			$sql="select count(*) as total from company
			where location_y<>0 and location_y>".$squares['right-bottom']['lat']."
			and location_y<".$squares['left-top']['lat']."
			and location_x>".$squares['left-top']['lng']."
			and location_x<".$squares['right-bottom']['lng'];//echo $sql;
			$a=Yii::app()->db->createCommand($sql)->queryAll();
			$list[]=$a[0]['total'];
		}
		$this->msg(array('state'=>1,'list'=>$list,'type'=>'json'));
	
	}
	
	
}