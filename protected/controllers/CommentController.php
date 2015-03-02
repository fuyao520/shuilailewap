<?php
class CommentController extends HomeController{
	//取得评论
	public function actionGetComment(){
		$pagesize=10;
		$fromid=$_GET['fromid']=isset($_GET['fromid'])?helper::escape($_GET['fromid']):'';
		$_GET['p2']=isset($_GET['p2'])?intval($_GET['p2']):1;
		$_GET['p']=$_GET['p2'];
		if(!$fromid){
			exit('{code:"-39","statewords":"缺少参数"}');	
		}
		$a=Comment::model()->get_comments($fromid);
		$b=Comment::model()->list_comments($a,0);
		
		$pagearr=helper::pagehtml(array('total'=>count($b),"pagesize"=>$pagesize,'page_name'=>'p'));
		
		$pagecode=preg_replace('~href="[^>]*&p=(\d+)~','href="javascript:show_comment($1);',$pagearr['pagecode']);
		$pagecode='<div class="c-page fix">'.$pagecode.'</div>';
	
		
		$offset=($_GET['p2']-1)*$pagesize;
		$data=array();
		foreach($b as  $k=>$s){
			if($k >= $offset && $k<$offset+$pagesize ){
				$data[]=$s;
			}
		}
		$list=Comment::model()->show_comments($data);
		$re['total']=count($b);
		$re['data']=$list;
		$re['pagecode']=$pagecode;
		if(count($b)==0){
			$re['pagecode']='<div class="nocomments">还没有评论喔~</div>';	
		}
		
		
		$jsoncallback=isset($_GET['jsoncallback'])?$_GET['jsoncallback']:0;
		die($jsoncallback.'('.json_encode($re).')');
	}
	//获取前几个精彩评论
	function actionGetGoodComment(){		
		$a=Comment::model()->get_hot_comments(10,' good ');
		$re['list']=$a;
		$jsoncallback=isset($_GET['jsoncallback'])?$_GET['jsoncallback']:0;
		die($jsoncallback.'('.json_encode($re).')');
				
	}
	
	//发表评论
	public function actionSaveComment(){
		$jsoncallback=isset($_GET['jsoncallback'])?$_GET['jsoncallback']:0;	
		$_GET['uname']=isset($_GET['uname'])?trim($_GET['uname']):'';
		$_GET['comment_rancode']=isset($_GET['comment_rancode'])?trim($_GET['comment_rancode']):'';	
		$field['ipaddr']=helper::getip();
		
		if(Yii::app()->user->isGuest && $_GET['uname']==''){
			die($jsoncallback.'({"code":-12,"statewords":"昵称不能为空"})');	
		}
		
		if(Yii::app()->params['comment']['open']==0){
			die($jsoncallback.'({"code":-9,"statewords":"评论已关闭"})');
		}
		if(Yii::app()->user->isGuest && Yii::app()->params['comment']['visitor_allow']==0){
			die($jsoncallback.'({"code":-8,"statewords":"评论需要登录"})');
		}
		//print_r($_SESSION);
		if((!isset($_SESSION['comment_rancode']))||($_GET['comment_rancode']!=$_SESSION['comment_rancode'])){
				die($jsoncallback.'({"code":-23,"statewords":"验证码不正确"})');	
		}
		//检测评论时间间隔
		$sql="select max(create_date) as create_date from comment_list where ipaddr='".$field['ipaddr']."' " ;
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])>0){
			$limit_time=intval(Yii::app()->params['comment']['limit_time']);
			if($limit_time && time()-$limit_time<$a['list'][0]['create_date']){
				die($jsoncallback.'({"code":-8,"statewords":"评论太频繁，请'.($a['list'][0]['create_date']-time()+$limit_time).'秒后再试"})');	
			}
		}
		
		$_GET['fromid']=isset($_GET['fromid'])?($_GET['fromid']):'';
		$field['pid']=isset($_GET['pid'])?intval($_GET['pid']):0;
		$field['comment']=isset($_GET['comment'])?helper::escape(str_replace("'",'"',strip_tags($_GET['comment']))):0;
		$field['comment']=urldecode($field['comment']);
		$field['ipaddr']=$_SERVER['REMOTE_ADDR'];
		$field['uid']=Yii::app()->user->isGuest==0?Yii::app()->user->uid:'';
		$field['uname']=Yii::app()->user->isGuest==0?Yii::app()->user->uname:'';
		if($field['uname']==''){
			$field['uname']=$_GET['uname'];
		}
		$field['ischeck']=1;
		$field['create_date']=time();
		$field['fromid']=$_GET['fromid'];
		$sql=helper::get_sql('comment_list','insert',$field);
		Yii::app()->db->createCommand($sql)->execute();
		
		die($jsoncallback.'({"code":1,"statewords":"发布成功"})');
			
	}
	
	//评论 顶
	public function actionGoodPlus(){
		$jsoncallback=isset($_GET['jsoncallback'])?$_GET['jsoncallback']:0;	
		$comment_id=isset($_GET['comment_id'])?intval($_GET['comment_id']):0;
		$sql="update comment_list set good=good+1   where comment_id=$comment_id";
		Yii::app()->db->createCommand($sql)->execute();
		die($jsoncallback.'({"code":1,"statewords":"成功"})');
		die();
	}
	
	//评论 顶
	public function actionBadPlus(){
		$jsoncallback=isset($_GET['jsoncallback'])?$_GET['jsoncallback']:0;	
		$comment_id=isset($_GET['comment_id'])?intval($_GET['comment_id']):0;
		$sql="update comment_list set bad=bad+1   where comment_id=$comment_id";
		Yii::app()->db->createCommand($sql)->execute();
		die($jsoncallback.'({"code":1,"statewords":"成功"})');
		die();
	}
}
?>