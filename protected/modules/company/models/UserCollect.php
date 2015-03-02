<?php
class UserCollect extends CActiveRecord{
	public function tableName() {
		return '{{user_collect}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function get_list($uid){
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.add_time desc     ";
		$params['pagesize']=Yii::app()->params['company']['pagesize'];
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
			$r['url']=Cms::model()->set_info_url(Dtable::toArr($m2));
			$r['info_title']=$r['title']=$m2->info_title;
			$r['info_img']=$m2->info_img;
			$r['thumb']=Attachment::simg($m2->info_img);
			$r['type_name']=vars::get_field_str('collect_types', $r['table_name']);
			$list[]=$r;
		}
		return $list;
	}
}
