<?php

/**
 * This is the model class for table "t_admin_user".
 *
 * The followings are the available columns in table 't_admin_user':
 * @property integer $id
 * @property string $user
 * @property string $password
 */
class AdminUser extends CActiveRecord
{
	public function tableName() {
		return '{{cservice}}';
	}
    public static function model($className=__CLASS__)
   	{
   		return parent::model($className);
   	}
   	public static function password($upass){
   		return md5(md5(md5($upass)));
   		
   	}
   	
   	public static function get_user_role($sno){
   		$sql="select  a.*,b.* from cservice_roles as a left join cservice_role as b on b.role_id=a.role_id where sno='$sno' ";
   		$data=Yii::app()->db->createCommand($sql)->queryAll();
   		return $data;
   	}
   	/** @params int $id 用户id
   	 *  @params array $roles 角色id的数组 
   	 * */
   	public function save_user_roles($id,$roles=array()){	
   		if(!is_array($roles)) return false;	
   		$arr001=Dtable::model('cservice_roles')->findAll("sno=$id");
   		$idarr=array();
   		foreach($arr001 as $r){
   			$idarr[]=$r['role_id'];
   		}   		 		
   		foreach($idarr as $idw){  //遍历 清除不存在的 数据
   			if(!in_array($idw,$roles)){ //老的数组 的信息ID 是否 在新的数组上
   				$mg=Dtable::model('cservice_roles')->findByAttributes(array('role_id'=>$idw,'sno'=>$id));
   				if(!$mg) continue;
   				$mg->delete(); 
   			}
   		}	
   		foreach($roles as $r){
   			$post=Dtable::model('cservice_roles')->findByAttributes(array('sno'=>$id,'role_id'=>$r));
   			if(!$post){
   				$post=new Dtable('cservice_roles');
   				$post->sno=$id;
   				$post->role_id=$r;
   				$post->save();
   			}
   		}	
   		return true;
   	}
   	

}