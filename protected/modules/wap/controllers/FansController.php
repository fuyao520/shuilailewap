<?php
class FansController extends UserController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.create_time desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		$params['join']="left join user_list as b on b.uid=a.uid2
						left join user_extern as c on c.uid=a.uid2
				";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="c.*,b.*,a.* ";
		$page['listdata']=Dtable::model('user_fans')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){			
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		$this->render('/fans_index',array('page'=>$page));
	}	
	//删除信息
	public function actionDelete(){
		$uid=Yii::app()->user->uid;
		$id=intval($this->get('id'));
		$m=UserFans::model()->findByPk($id);
		if($m->uid!=$uid){
			$this->msg(array('state'=>0,'msgwords'=>'无权限','type'=>'json'));
		}
		$m->delete();
		$this->msg(array('state'=>1,'msgwords'=>'操作成功','type'=>'json'));
	}
	
	//点击关注某人
	public function actionSave(){
		$uid=Yii::app()->user->uid;
		$uid2=intval($this->post('uid2'));
		$mu=User::model()->findByPk($uid2);
		if(!$mu){
			$this->msg(array('state'=>0,'msgwords'=>'用户不存在','type'=>'json'));
		}
		$m=UserFans::model()->findByAttributes(array('uid'=>$uid,'uid2'=>$uid2));
		if($m){
			$this->msg(array('state'=>0,'msgwords'=>'已关注','type'=>'json'));
		}
		$m=new UserFans();
		$m->uid=$uid;
		$m->uid2=$uid2;
		$m->create_time=time();
		$m->save();
		$this->msg(array('state'=>1,'msgwords'=>'关注成功','type'=>'json'));
	}
	
	
}