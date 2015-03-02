<?php
class AdminGroupRole extends CActiveRecord{
	public function tableName() {
		return '{{cservice_group_role}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public static function get_group_role($groupid){
		$sql="select * from cservice_group_role where groupid='$groupid' ";
		$data=Yii::app()->db->createCommand($sql)->queryAll();
		return $data;		
	}
	//将角色的查询结果转换成权限数组集
	public static function role_arr($data){
		$re=array();
		foreach($data as $r){
			$autharr=AdminRoleAuthority::get_role_auth($r['role_id']);
			foreach($autharr as $r2){
				$re[]=$r2['authority_id'];
			}
		}
		return $re;		
	}
	
}