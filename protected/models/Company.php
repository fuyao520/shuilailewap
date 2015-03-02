<?php
class Company extends CActiveRecord{
	public function tableName() {
		return '{{company}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	/*保存企业资料
	 * 
	 * */
	public function save_company_profile($cid,$relation_data){
		if(!is_array($relation_data)){
			return false;
		}
		$data=array();
		$field=array('company_name','company_type','company_tel','company_hide_name','not_true','company_banner','scale','year','reg_assets','company_about','company_fax','company_address','contact');
		foreach($field as $r){
			$data[$r]=isset($relation_data[$r])?$relation_data[$r]:'';
		}
		$m=Company::model()->findByPk($cid);
		if(!$m){
			$m=new Company();
				
		}
		foreach($data as $k=>$r){
			$m->$k=$r;
		}
		$m->company_id=$cid;
		$m->save();
		
	}


}
