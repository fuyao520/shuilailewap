<?php
class UserProfileController extends  UserController{
	public function actionIndex(){
		$uid=Yii::app()->user->uid;
		$page=array();
		$m=UserProfile::model()->findByPk($uid);
		$page['info']=$this->toArr($m);
		$this->render('/user_profile_index',array('page'=>$page));
	}
	
	public function actionUpdate(){
		$page=array();
		$uid=Yii::app()->user->uid;
		if(!$_POST){
			$m=UserProfile::model()->findByPk($uid);	
			if($m){				
				$page['info']=$this->toArr($m);
			}else{
				
			}
		}else{					
			$m=UserProfile::model()->findByPk($uid);		
			//如果有post.id 为保存修改，否则为保存新增
			if(!$m){
				$m=new UserProfile();
			}
			$m->uid=$uid;
			$m->sex=intval($this->post('sex'));
			$m->tou_img=helper::escape($this->post('tou_img'),1);
			$m->birth_day=strtotime($this->post('birth_day'));
			$m->constellation=helper::escape($this->post('constellation'),1);
			$m->signature=helper::escape($this->post('signature'),1);
			$m->occupation=helper::escape($this->post('occupation'),1);
			$dbresult=$m->save();	
			$msgarr['type']='json';
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{						
				//成功跳转提示
				$this->msg($msgarr);
			}
		}
		$this->render('/user_profile_update',array('page'=>$page));
	}
	
}