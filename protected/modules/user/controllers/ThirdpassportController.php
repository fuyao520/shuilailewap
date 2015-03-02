<?php
class ThirdpassportController extends  UserController{
	public function actionIndex(){
		$uid=Yii::app()->user->uid;
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.id desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="a.* ";
		$page['listdata']=Dtable::model('user_thirdpassport')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		$this->render('/thirdpassport_index',array('page'=>$page));
	}
	
	//删除信息
	public function actionDelete(){
		$uid=Yii::app()->user->uid;
		$id=intval($this->get('id'));
		$m=Thirdpassport::model()->findByPk($id);
		if($m->uid!=$uid){
			$this->msg(array('state'=>0,'msgwords'=>'无权限','type'=>'json'));
		}
		$m->delete();
		$this->msg(array('state'=>1,'msgwords'=>'操作成功','type'=>'json'));
	}
	
	
}