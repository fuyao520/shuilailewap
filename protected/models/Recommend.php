<?php
class Recommend extends CActiveRecord{
	public function tableName() {
		return '{{recommend}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	//取得某条信息的推荐位
	public function get_info_recommends($table,$info_id){
		$recommends=array();
		$sql="select * from recommend where table_name='".$table."'";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($a as $r){
			$b=explode(',',$r['inid']);
			if(empty($r['inid'])) $b=array();
			if(in_array($info_id,$b)){
				$recommends[]=$r;
				continue;
			}
		}
		return $recommends;
	}
	public function RecommendList(){
		$sql="select * from recommend order by recommend_order,recommend_id desc";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a;
	}
	
	
}
