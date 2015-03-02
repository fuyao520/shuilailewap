<?php
class CompanyProfileController extends  CompanyController{
	public function actionIndex(){
		$uid=Yii::app()->company_user->uid;
		$page=array();
		$m=Company::model()->findByPk($uid);
		$page['company']=$this->toArr($m);
		$page['region_business']=CompanyRegionBusiness::model()->get_regions($uid,1);
		$this->render('/company_profile_index',array('page'=>$page));
	}
	
	public function actionUpdate(){
		$uid=Yii::app()->company_user->uid;
		$page=array();
		$m=Company::model()->findByPk($uid);	
		if(!$m) {
			$this->msg(array('state'=>0,'msgwords'=>'数据出错'));
		}

		if(!$_POST){
			$page['region_business']=CompanyRegionBusiness::model()->get_regions($uid,1);
		}
		if($_POST){
			$field=array();
			$m=Company::model()->findByPk($uid);
			$m->contact=urldecode($this->post('contact'));
			$m->company_tel=urldecode($this->post('company_tel'));
			$m->company_logo=urldecode($this->post('company_logo'));
			$m->erweima=urldecode($this->post('erweima'));
			$m->weibo=urldecode($this->post('weibo'));
			$m->qq=urldecode($this->post('qq'));
			$m->company_banner=urldecode($this->post('company_banner'));
			$m->company_fax=urldecode($this->post('company_fax'));
			$m->company_address=urldecode($this->post('company_address'));
			$m->company_about=urldecode($this->post('company_about'));
			$m->url=urldecode($this->post('url'));
			$m->location_x=$this->post('location_x');
			$m->location_y=$this->post('location_y');
			$m->year=urldecode($this->post('year'));
			$m->email=urldecode($this->post('email'));
			
			$business_products=array();
			foreach($this->post('business_products') as $r){
				$business_products[]=$r;
			}
			
			$m->business_products=json_encode($business_products);
			$m->year=urldecode($this->post('year'));
			$m->scale=urldecode($this->post('scale'));
			$m->company_type=urldecode($this->post('company_type'));
			$m->reg_assets=urldecode($this->post('reg_assets'));
			$r=$m->save();
			if($r){
				//送水范围
				$region_data=$this->post('region_data');
				//保存送水范围
				CompanyRegionBusiness::model()->save_region_data($uid,$region_data);
				
				//重新整理 区域 对应的水
				CompanyRegionWater::model()->reset_region_water($uid);
				
				$this->msg(array('state'=>1,'msgwords'=>'修改成功','type'=>'json'));
			}else{
				$this->msg(array('state'=>0,'msgwords'=>'数据出错，修改失败','type'=>'json'));
			}
		}
		$page['company']=$this->toArr($m);
		$this->render('/company_profile_update',array('page'=>$page));
	}
	
}