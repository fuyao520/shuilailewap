<?php
class UserCollect extends CActiveRecord{
	public function tableName() {
		return '{{user_collect}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	
	public static function get_total($uid){
		$sql="select count(*)  as total from user_collect where uid=$uid";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return intval($a[0]['total']);
	
	}
	public function get_list($uid,$pagesize=10){
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.add_time desc     ";
		$params['pagesize']=$pagesize;
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$listdata=Dtable::model('user_collect')->listdata($params);
		$list=array();
		foreach($listdata['list'] as $r){
			$real_table=vars::get_field_str('collect_types', $r['table_name'],'table');
			$m2=Dtable::model($real_table)->findByPk($r['info_id']);
			if(!$m2) continue;
			$info=Dtable::toArr($m2);
			$r['url']=Cms::model()->set_info_url($info);
			$r['info_title']=$r['title']=$m2->info_title;
			$r['info_img']=$m2->info_img;
			$r['thumb']=Attachment::simg($m2->info_img);
			$r['cate']['model_table_name']=$real_table;
			$r['type_name']=vars::get_field_str('collect_types', $r['table_name']);
			$r=array_merge($r,$info);
			$list[]=$r;
		}
		return $list;
	}
}
