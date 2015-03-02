<?php
class AdminController extends CController{
	//public $layout=false;
	public $admin_style='default';
	public $layout=2;
	public $page_time_start=0; //页面执行时间
	
	public $AdminStyleArray=array();
	public function init(){
		$this->page_time_start=helper::getmicrotime();
		$this->AdminStyleArray=array(
			array(
					'style_name'=>'默认',
					'style_folder'=>'default',
					'style_color'=>'gray'
			),
			array(
					'style_name'=>'蓝色',
					'style_folder'=>'blue',
					'style_color'=>'blue'
			),
			array(
					'style_name'=>'土豪金',
					'style_folder'=>'orange',
					'style_color'=>'orange'
			),
			array(
					'style_name'=>'绿色',
					'style_folder'=>'green',
					'style_color'=>'green'
			),
				
		);
		if(isset($_COOKIE['admin_style'])){
			foreach($this->AdminStyleArray as $r){
				if($r['style_folder']==$_COOKIE['admin_style']){
					$this->admin_style=$_COOKIE['admin_style'];
					break;
				}
			}
					
		}	


		//menu_left 增加自定义表单
		$sql="select * from model where model_type=1 and parent_model_id=0";
		$diy_typeaarr['list']=Yii::app()->db->createCommand($sql)->queryAll();
		foreach($diy_typeaarr['list'] as $r){
			$r['title']=$r['model_name'];
			$r['url']=$this->createUrl('diyForm/index').'?cate_id='.$r['model_id'];
			$r['auth_tag']='form_'.$r['model_id'];
			$r['auth_func']=array(
					array('name'=>'查看'.$r['model_name'],'auth_tag'=>'form_'.$r['model_id'].'_show'),
					array('name'=>'新增'.$r['model_name'],'auth_tag'=>'form_'.$r['model_id'].'_add'),
					array('name'=>'修改'.$r['model_name'],'auth_tag'=>'form_'.$r['model_id'].'_edit'),
					array('name'=>'审核'.$r['model_name'],'auth_tag'=>'form_'.$r['model_id'].'_audit'),
					array('name'=>'删除'.$r['model_name'],'auth_tag'=>'form_'.$r['model_id'].'_del'),
			);
		    struct::$menu_left[6]['smenu'][]=$r;
		}
		
		
	}

    public function actionError(){
    	$msg['icon']='error';
    	$msg['msgwords']='出现错误';
    	$this->render('msg',array(
    		'msg'=>$msg,		
    	));
    
    }  
    /**提示界面
     * @params $params['state'] 0=失败，并且浏览器后退一步,1=成功，并且跳转到上一页,-1=不进行页面跳转，只显示 msgwords,-2=错误，停止
     * @params $params['url']  强制跳转的url
     * @params $params['msgwords'] 显示的文字
     * @params $params['jscode']  自定义js行为  
     * @params $params['type']   类型，默认页面,可选 json,xml';
     * @atention 如果制定了url话跳转到 url
     * 如果 msgwords 提示文字有的话，则显示提示文字
     * 如果
     */
    public function msg($params=array()){
    	
    	$params['state']=isset($params['state'])?$params['state']:1;
    	$params['url']=isset($params['url'])?$params['url']:(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'');
    	$params['msgwords']=isset($params['msgwords'])?$params['msgwords']:'';  	
    	$params['jscode']=isset($params['jscode'])?$params['jscode']:'';
    	$params['type']=isset($params['type'])?$params['type']:'';
    	$msgwords_bak=$params['msgwords'];
    	$jscode='';
    	if($params['state']==0){
    		$params['msgwords']=$params['msgwords']?$params['msgwords']:'操作失败';
    		$params['icon']='error';
    		$jscode='<script>setTimeout(function (){history.go(-1);},1000)</script>';
    	}else if($params['state']==1){
    		$params['msgwords']=$params['msgwords']?$params['msgwords']:'操作成功';
    		$params['icon']='succeed';
    		$jscode='<script>setTimeout(function (){window.location="'.$params['url'].'";},1000)</script>';
    	}else if($params['state']==-1){
    		$jscode='';
    		$params['msgwords']=$msgwords_bak?$msgwords_bak:'操作停止';
    		$params['icon']='question';
    	}else if($params['state']==-2){
    		$jscode='';
    		$params['msgwords']=$msgwords_bak?$msgwords_bak:'操作停止';
    		$params['icon']='error';
    	}
    	if(!$params['jscode']){
    		$params['jscode']=$jscode;
    	}
    	if($params['type']=='json'){
    		die(json_encode($params));
    	}
    	
    	$this->renderPartial('/site/msg',array(
    		'msg'=>$params,		
    	));
    	exit();
    }
	
    //返回json数据
    public function echoJson($state,$msgwords='',$data=array()){
    	
    	if($state<1){
    		$msgwords=$msgwords?$msgwords:'error';
    	}else if($state>=1){
    		$msgwords=$msgwords?$msgwords:'ok';
    	}
    	$params['state']=$state;
    	$params['msgwords']=$msgwords;
    	$params['data']=$data;
    	die(json_encode($params));
    }
    
    
    //返回后台组权限和用户权限
    //$$auth_tag 权限标识
    public function auth_action($auth_tag){
    	//判断功能权限
    	if(!$this->check_u_menu(array('auth_tag'=>$auth_tag,'echo'=>0)))
    	{
    		$this->msg(array('state'=>-2,'msgwords'=>'无权限'));
    		return false;
    	}
    }
    //判断我的权限，是否显示 按钮 之类的代码
    public function check_u_menu($params){
    	$group_id=Yii::app()->admin_user->groupid;
    	$uid=Yii::app()->admin_user->uid;
    	$code=isset($params['code'])?$params['code']:'';
    	$auth_tag=$params['auth_tag'];
    	$echo=isset($params['echo'])?$params['echo']:1;
    	
    	if($uid==Yii::app()->params['management']['super_admin_id'] 
    		|| $group_id==Yii::app()->params['management']['super_group_id'] 
    		){
    		if($echo==1){
    			echo $code;
    		}
    		return true;
    	}
    	
    	foreach(struct::$public_user_auth as $r){
    		if(stripos($r,'*')){
    			if(preg_match('~'.$r.'~i',$auth_tag)){
    				if($echo==1){
		    			echo $code;
		    		}
		    		return true;
    			}
    		}else{
	    		if(preg_match('~'.$r.'~i',$auth_tag)){
	    			if($echo==1){
		    			echo $code;
		    		}
		    		return true;
	    		}
    		}
    	}
    	
    	
    	$levels=Yii::app()->admin_user->mylevel;
    	$levels=is_array($levels)?$levels:array();
    	if(in_array($auth_tag,$levels)){
    		if($echo==1){
    			echo $code;
    		}
    		return true;
    	}else{
    		return false;
    	}
    }	
    //取得某张表数据 返回 option	
    public  function get_option($params){
    	$options='';
    	$id_field_name=isset($params['id_field_name'])&&$params['id_field_name']!=''?$params['id_field_name']:'';
    	$txt_field_name=isset($params['txt_field_name'])&&$params['txt_field_name']!=''?$params['txt_field_name']:'';
    	$txt_field_name2=isset($params['txt_field_name2'])&&$params['txt_field_name2']!=''?$params['txt_field_name2']:'';
    	$table_name=isset($params['table_name'])&&$params['table_name']!=''?$params['table_name']:'';
    	$select_value=isset($params['select_value'])&&$params['select_value']!=''?$params['select_value']:'';
    	$wheresql=isset($params['wheresql'])&&$params['wheresql']!=''?$params['wheresql']:'';
    	$ordersql=isset($params['ordersql'])&&$params['ordersql']!=''?$params['ordersql']:'';
    
    	$sql="select * from ".$table_name." ".$wheresql." ".$ordersql;
    	$rsarrs=Yii::app()->db->createCommand($sql)->queryAll();
    	if(count($rsarrs)){
    		foreach ($rsarrs as $rs){
    			$options .='<option title="'.$rs[$txt_field_name].'" value="'.$rs[$id_field_name].'"  '.($select_value==$rs[$id_field_name]?'selected':'').' >'.$rs[$txt_field_name].''.($txt_field_name2?'-'.$rs[$txt_field_name2]:'').'</option>';
    		}
    	}
    	return $options;
    }
    /**修改和新增的时候 对象赋值
     * @params $model 模型名称
     * @params $data  要保存或修改的数据
     * @params $Dtable 没有模型的表(动态表支持)
     * */
    public function data($model,$field=array(),$Dtable=''){
    	if($Dtable==''){
    		$post=new $model();
    	}else{
    		$post=new $model($Dtable);
    	}
    	foreach($field as $k=>$r){
    		$post->$k=$r;
    	}
    	return $post;
    }
    
    //将  findAll 的结果集 取出记录，转为数组
    public function toArr($result){
    	if(!$result){
    		return array();
    	}
    	$re=array();
    	if(isset($result->attributes)){
    		$re=$result->attributes;
    	}else{
	    	foreach($result as $r){
	    		$re[]=$r->attributes;
	    	}
    	}
    	return $re;
    	
    }
	//插入后台操作日志
	function logs($logs_content){
	    $post=new AdminAclog();
	    $post->sno=Yii::app()->admin_user->uid;
	    $post->accode=Yii::app()->controller->id.'->'.$this->getAction()->getId();
	    $post->log_time=time();
	    $post->log_ip=helper::getip();
	    $post->log_details=$logs_content;
	    $post->save();
	    
	}
	/**************/
	//数据读取
	public function query($sql){
		return Yii::app()->db->createCommand($sql)->queryAll();
	}
	//获取get
	public function get($key, $default = null){
		return Yii::app()->request->getParam($key, $default);
	}
	//获取post
	public function post($key, $default = null){
		return Yii::app()->request->getPost($key, $default);
	}
	public function getRunTime(){
		$data_fill_time=helper::getmicrotime()-$this->page_time_start;
		return substr($data_fill_time/1000,0,6).'s';
	}
    
}