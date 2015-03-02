<?php
class CommentController extends AdminController{
	public function actionIndex(){
		$this->auth_action('comment_index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.comment like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='fromid'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.fromid='".$this->get('search_txt')."') ";
		}
		$params['select']="u.*,a.* ";
		$params['order']="  order by create_date desc     ";
		$params['join']="left join user_list u on u.uid=a.uid";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model('comment_list')->listdata($params);
		$this->render('index',array('page'=>$page));
	}
	
	public function actionDelete(){
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		foreach($ids as $id){
			$id=intval($id);
			$m=Comment::model()->findByPk($id);
			if($m) continue;
			$m->delete();
			
		}
		//die();
		$this->msg(array('state'=>1));	
	}
	public function actionAudit(){
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ischeck=isset($_GET['ischeck'])&&$_GET['ischeck']!=''?intval($_GET['ischeck']):0;
		$ids=explode(',',$ids);
		foreach($ids as $id){
			$id=intval($id);
			$m=Comment::model()->findByPk($id);
			if(!$m) continue;
			$m->ischeck=$ischeck;		
		}
		//die();
		$this->msg(array('state'=>1));	
	}
	
	public function actionSaveReply(){
		$id=isset($_POST['comment_id'])?intval($_POST['comment_id']):0;
		$reply_content=isset($_POST['reply_content'])?helper::escape($_POST['reply_content'],1):'';
		$sql="update comment_list set reply='$reply_content' where comment_id=".$id;
		Yii::app()->db->createCommand($sql)->execute();
		die('{"code":1,"statewords":"操作成功"}');	
		
	}

}
?>