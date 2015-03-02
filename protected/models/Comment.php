<?php
class Comment extends CActiveRecord{
	public function tableName() {
		return '{{comment_list}}';
	}
	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function get_comment_total($info_id){
		$total=0;
		$sql="select count(*) total from comment_list where info_id=".intval($info_id)." ";
		$rsarrs['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rsarrs['list'])>0){
			$rearr=	$rsarrs['list'][0]['total'];
		}
		return $rearr;
	}
	//读取某个info_id的所有评论
	public function get_comments($from_id,$pagesize=0,$order=''){
		if($order==''){
			$order='a.create_date';
		}
		if($pagesize){
			$limit=" limit 0,$pagesize";
		}else{
			$limit='';
		}
	
		$sql="select a.*,c.tou_img from comment_list a left join user_list b on a.uid=b.uid left join user_extern as c on c.uid=b.uid where a.fromid='".$from_id."' and ischeck=1 order by $order desc $limit  ";//echo $sql;
		//$sql="select a.*,c.tou_img from comment_list a left join user_list b on a.uid=b.uid left join user_extern as c on c.uid=b.uid where a.fromid='".$from_id."' and ischeck=1 order by a.create_date desc ";//echo $sql;
	
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$b=$a['list'];
	
		return $b;
	}
	public function  get_hot_comments($pagesize = 0, $order = ''){
		global  $dbm,$c;
		if($order==''){
			$order='create_date';
		}
		if($pagesize){
			$limit=" limit 0,$pagesize";
		}else{
			$limit='';
		}
		$sql = "SELECT  comment,uname,fromid  FROM  comment_list  WHERE  ischeck=1 order by $order desc $limit  ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$b=$a['list'];
		foreach($b  as  $k=>$r){
			$id_list = explode('-',$r['fromid']);
			$info = $c->info_content($id_list[0],$id_list[1]);
			$b[$k]['title'] = $info['title'];
			$b[$k]['url'] = $info['url'];
			$new_t = helper::utf8_substr($r['comment'],0,20);
			$b[$k]['sub_comment'] = $new_t;
		}
		return $b;
	}
	
	
	//嵌套显示评论，$comments来自于get_comments返回的数组
	public function list_comments($comments,$pid){
		$a=array();
		$i=0;
		foreach($comments as $comment){
			if($comment['pid']==$pid){
				$a[$i]=$comment;
				$son=$this->list_comments($comments,$comment['comment_id']);
				$a[$i]['son']=$son;
				$i++;
			}
		}
		return $a;
	}
	/*显示，$new_comments，list_comments返回的数组
	 $a=get_comments(10000);
	$b=list_comments($a,0);
	$c=show_comments($b);
	<style>
	ul{margin:0;padding:0;list-style:none;}
	ul li{margin:10px;padding:0;list-style:none;border:1px solid #888;}
	ul li .tit{margin:10px;}
	ul li .content{margin:10px;}
	</style>
	*/
	public function show_comments($new_comments,$top=1){
		global $config;
		$html='<ul>';
		foreach($new_comments as $a){
			$city=helper::convertip($a['ipaddr']);
			$city=$city?$city:'未知地区';
			$html.='
		<li class="fix">
			'.'<div class="fl replythis"><a href="javascript:void(0);"><img src="'.($a['tou_img']?$a['tou_img']:Yii::app()->params['basic']['cssurl'].Yii::app()->params['basic']['tpl'].'/images/nophoto.gif').'"  width="60" height="40"></a>
			</div>
			'.'
			<div class="reply_infor">
				<p><span class="uname">'.($a['uname']?$a['uname']:'匿名').'</span> '.helper::timeop($a['create_date']).'
				</p>
				<p>'.$a['comment'].'</p>
		        '.($a['reply']?'<p class="manage_reply_box">管理员回复：'.stripslashes($a['reply']):'').'</p>
				<p class="reply_meta"> <span></span> <a href="javascript:void(0);" onclick="good_plus('.$a['comment_id'].',this)" class="goodtop">顶（<span class="goodnum">'.$a['good'].'</span>）</a> <a href="javascript:void(0);" onclick="bad_plus('.$a['comment_id'].',this)" class="badtop">踩（<span class="badnum">'.$a['bad'].'</span>）</a> <a href="javascript:ready_reply('.$a['comment_id'].');" class="replythis">回复</a> </p>
			</div>
		
			<div id="replay_frame_'.$a['comment_id'].'">
			</div>
			'.(count($a['son'])>0?$this->show_comments_reply($a['son'],2):'').'
		</li>';
				
	
	
			 
		}
		$html.='</ul>';
		return $html;
	}
	public function show_comments_reply($new_comments){
		global $config;
		$html='';
		foreach($new_comments as $a){
			$city=helper::convertip($a['ipaddr']);
			$city=$city?$city:'未知地区';
			$html.='
		<div class="reply_box">
			'.'<div class="fl reply_avatar"><a href="javascript:void(0);"><img src="'.($a['tou_img']?$a['tou_img']:Yii::app()->params['basic']['cssurl'].Yii::app()->params['basic']['tpl'].'/images/nophoto.gif').'"  width="40" height="40"></a>
			</div>
			'.'
			<p><span class="uname">'.($a['uname']?$a['uname']:'匿名').'</span>  '.helper::timeop($a['create_date']).'</p>
			<p>'.$a['comment'].'</p>
		    '.($a['reply']?'<p class="manage_reply_box">管理员回复：'.stripslashes($a['reply']):'').'</p>
			<p class="reply_meta"><a href="javascript:void(0);" onclick="good_plus('.$a['comment_id'].',this)" class="goodtop">顶（<span class="goodnum">'.$a['good'].'</span>）</a> <a href="javascript:void(0);" onclick="bad_plus('.$a['comment_id'].',this)" class="badtop">踩（<span class="badnum">'.$a['bad'].'</span>）</a> <a href="javascript:ready_reply('.$a['comment_id'].');" class="replythis">回复</a></p>
			<div id="replay_frame_'.$a['comment_id'].'">
			</div>
			'.(count($a['son'])>0?$this->show_comments_reply($a['son']):'').'
		</div>';
	
			 
		}
		return $html;
	}

}
