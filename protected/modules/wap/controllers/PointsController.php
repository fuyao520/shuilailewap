<?php
class PointsController extends UserController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->user->uid;
		$params['where']="and a.uid=$uid  ";
		$params['order']="  order by a.create_date desc     ";
		$params['pagesize']=Yii::app()->params['basic']['pagesize'];
		//  $params['join']="left join info_order as b on b.info_id=a.info_order_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['pageshow']=$this->pageshow;
		$params['select']="a.* ";
		$page['listdata']=Dtable::model('user_points')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){			
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		$page['points_total']=UserPoints::model()->get_total($uid);
		
		$this->render('/points_index',array('page'=>$page));
	}
	
}