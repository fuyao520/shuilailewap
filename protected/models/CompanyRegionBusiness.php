<?php
class CompanyRegionBusiness extends CActiveRecord{
	public function tableName() {
		return '{{company_region_business}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	
	public  function get_regions($uid,$getname=0){
		//$tableid=self::get_table($tagid);
		//$table='ffgh_attachment_'.$tableid;
		$table=$this->tableName();
		if(!$uid) return false;
		$data=Yii::app()->db->createCommand()->from($table)->where("uid=$uid")->queryAll();
		$re=array();
		foreach($data as $r){
			$r['uid']=$r['uid'];
			$r['region_id']=$r['region_id'];
			if($getname==1){
				$r['name']=Linkage::model()->get_name($r['region_id']);
			}
			$re[]=$r;
		}
		return $re;
	}
	
	//保存送水范围
	public function save_region_data($uid,$region_data){
		$relation_data=array();
		$table=$this->tableName();
		if(is_array($region_data)){
			foreach($region_data as $region_id){
				if(!is_numeric($region_id)){
					continue;
				}
				$relation_data[]=array(
						'region_id'=>$region_id,
				);
			}
		}
		$oldarr=$this->get_regions($uid);
		foreach($oldarr as $r){  //遍历 清除不存在的 数据
			$in=0;//老的数组 的信息ID 是否 在新的数组上
			$fdata=array();
			foreach($relation_data as $r2){
				if($r2['region_id']==$r['region_id'] ){
					$in=1;
					$fdata=$r2;
					break;
				}
			}
			$post=Dtable::model($table)->findByAttributes(array('uid'=>$uid,'region_id'=>$r['region_id']));
			if($in==0){
				$post->delete();
			}else{
				//$post->uid=$uid;
				//$post->region_id=$fdata['region_id'];
				//$post->save();
			}
		}
		foreach($relation_data as $r){
			$post=Dtable::model($table)->findByAttributes(array('uid'=>$uid,'region_id'=>$r['region_id']));
			if(!$post){
				$post=new Dtable($table);
				$post->uid=$uid;
				$post->region_id=$r['region_id'];  //社区
				
				$street_row=Linkage::model()->findByPk($r['region_id']);
				if(!$street_row) continue;
				if($street_row->linkage_deep!=6) continue;
				$post->street_id=$street_row->parent_id;
				
				$area_row=Linkage::model()->findByPk($street_row->parent_id);
				if(!$area_row) continue;
				if($area_row->linkage_deep!=5) continue; 
				
				$post->area_id=$area_row->parent_id;
				
				
				$post->save();
			}
			//$post->region_id=$r['region_id'];
			//$post->save();
		}
		return true;
	}
	

}
