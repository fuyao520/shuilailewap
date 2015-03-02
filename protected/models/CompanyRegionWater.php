<?php
class CompanyRegionWater extends CActiveRecord{
	public function tableName() {
		return '{{company_region_water}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	//重新整理  company_region_water 区域索引表  
	public function reset_region_water($uid){
		$table=$this->tableName();
		//查找我的所有水
		$sql="select * from company_water where uid=$uid";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		$waters=$a;
		//查找company_region_business  送水范围表,得到所有社区
		$sql="select * from company_region_business where uid=$uid ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		
		$allid=array();
		//遍历我的送水范围, 
		foreach($a as $r){
			//社区id
			$communityId=$r['region_id'];
			$allid[]=$communityId;
			
			//获取街道
			$b=Linkage::model()->findByPk($r['region_id']);
			if(!$b) continue;
			
			$streetId=$b->parent_id;
			$allid[]=$streetId;
			//获取区域id
			$c=Linkage::model()->findByPk($streetId);
			if(!$c) continue;
			$areaId=$c->parent_id;
			$allid[]=$areaId;
			
			foreach($waters as $r2){
				$info_id=$r2['info_id'];
				$this->save_region_water($uid,$info_id,$communityId);  //保存社区
				$this->save_region_water($uid,$info_id,$streetId);  //保存街道
				$this->save_region_water($uid,$info_id,$areaId);  //保存区域
			}
			
			
		}
		
		//清除不存在的 区域
		foreach($allid as $region_id){
			$inid=implode(',',$allid);
			$sql="delete  from company_region_water where uid=$uid and region_id not in($inid) ";//echo $sql;
			Yii::app()->db->createCommand($sql)->execute();
		}
		
		$Gallid=array();
		//清除不存在的水
		foreach($waters as $r){
			$Gallid[]=$r['info_id'];
		}
		if(count($Gallid)>0){ //die(print_r($Gallid));
			$inid=implode(',',$Gallid);
		}else{
			$inid='9999999999999';
		}
		$sql="delete from company_region_water where uid=$uid and info_id not in($inid) ";//echo $sql;
		Yii::app()->db->createCommand($sql)->execute();
		
		
	}
	
	//保存某个区域的某种水
	public function save_region_water($uid,$info_id,$region_id){
		$b=CompanyRegionWater::model()->findByAttributes(array('region_id'=>$region_id,'info_id'=>$info_id,'uid'=>$uid));
		if($b){//echo $uid.'-'.$info_id.'-'.$region_id.',';
			return;
		}
		$b=new CompanyRegionWater();
		$b->uid=$uid;
		$b->info_id=$info_id;
		$b->region_id=$region_id;
		$a=$b->save();//die('hhh');
		//if(!$a) echo $region_id.'error';
		return true;
	}
	

}
