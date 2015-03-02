<?php
class InfoWaterController extends CompanyController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->company_user->uid;
		$params['where']="and a.uid=$uid  ";
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
		$this->render('/infoWater_index',array('page'=>$page));
	}
	
	public function actionUpdate(){
		$page=array();
		$uid=Yii::app()->company_user->uid;
		if($_POST){
			$info_id=$this->post('info_id');
			$type=$this->post('type');
			$companyWaterRow=CompanyWater::model()->findByAttributes(array('info_id'=>$info_id,'uid'=>$uid));
			if($type==1){	
				if(!$companyWaterRow){
					$companyWaterModel=new CompanyWater();
					$companyWaterModel->info_id=$info_id;
					$companyWaterModel->uid=$uid;
					$companyWaterModel->create_time=time();
					$companyWaterModel->save();
				}
			}else{
				if($companyWaterRow){
					$companyWaterRow->delete();
				}
			}
			CompanyRegionWater::model()->reset_region_water($uid);
			
			$this->msg(array('state'=>1,'type'=>'json'));
			
		}
		$this->render('/infoWater_update',array('page'=>$page));
	}
	
	
}