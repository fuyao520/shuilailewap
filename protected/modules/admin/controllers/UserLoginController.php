<?php
class UserLoginController extends AdminController{

	public function actionIndex(){
		$this->auth_action('UserLogin_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.login_ip like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.logs_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.logs_id      ";	
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['join']="left join user_list as u on u.uid=a.uid";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(UserLogin::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionDelete(){
		$this->auth_action('UserLogin_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=UserLogin::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了登陆记录ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}

}
?>