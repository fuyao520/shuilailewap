<?php
class PmListController extends CompanyController{
	public function actionIndex(){
		$page=array();
		$uid=Yii::app()->company_user->uid;
		$params['where']="and a.uid_recv=$uid  ";
		$params['order']="  order by a.post_date desc     ";
		$params['pagesize']=12;
		$params['join']="left join pm_read as b on b.pm_id=a.pm_id  and b.pm_id=a.pm_id ";
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['select']="b.*,a.* ";
		$page['listdata']=Dtable::model('pm_list')->listdata($params);
		$list=array();
		foreach($page['listdata']['list'] as $r){			
			$list[]=$r;
		}
		$page['listdata']['list']=$list;
		
		$this->render('/pm_index',array('page'=>$page));
	}
	public function actionDetail(){
		$page=array();
		$uid=Yii::app()->company_user->uid;
		$id=$this->get('id');
		$m=PmList::model()->findByPk($id);
		if(!$m){
			$this->msg(array('state'=>0,'msgwords'=>'id错误'));
		}
		$page['info']=Dtable::toArr($m);
		$m2=PmRead::model()->findByAttributes(array('pm_id'=>$id,'uid'=>$uid));
		if(!$m2){
			$m2=new PmRead();
			$m2->pm_id=$id;
			$m2->uid=$uid;
			$m2->read_date=time();
			$m2->save();
			$m->recv_date=time();
			$m->save();
		}
		$this->render('/pm_detail',array('page'=>$page));
	}
	
	
}