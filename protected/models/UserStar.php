<?php
class UserStar extends CActiveRecord{
	public function tableName() {
		return '{{user_star}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	//获取最新的一个达人
	public function get_new_one(){
		$sql="select * from user_star as a 
				left join user_list as b on b.uid=a.uid
				left join user_extern as c on c.uid=a.uid
				order by a.create_time desc limit 0,1 ";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		return $a;
	}

}
