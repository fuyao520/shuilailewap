<?php
class PostController extends CompanyController{

	//检查登录
	public function actionCheckLogin(){
		$jsoncallback=$this->get('jsoncallback');
		$uid=Yii::app()->company_user->uid;
		$re=array();
		if(Yii::app()->company_user->isGuest){
			$re['isGuest']=1;
		}else{
			$re['uname']=Yii::app()->company_user->uname;
			$re['company_name']=Yii::app()->company_user->company_name;
		}
		$re['points']=UserPoints::model()->get_total($uid);
		$re['last_login']=UserLogin::model()->get_last_login($uid);
		$re['last_login']['login_date']=date('Y-m-d H:i:s',$re['last_login']['login_date']);
		$re=json_encode($re);
		exit($jsoncallback.'('.$re.')');
	}
	
	
	public function  actionGetCateChildClass(){ //子栏目
		$parent_id=intval($this->get('parent_id'));
		$select_name=$this->get('select_name');
		$span_id=$this->get('span_id');
		$is_child=intval($this->get('is_child'));
		$selectnum=intval($this->get('selectnum'));
		$attr_extern=intval($this->get('attr_extern'));
		$linkage_type_id=intval($this->get('linkage_type_id'));
		$b=Linkage::model()->get_linkage($parent_id,$linkage_type_id);
		$re='';
		$extern_code='';
		foreach($b as $rs){
			if($attr_extern=='py'){
				$extern_code=' '.$attr_extern.'="'.$rs['linkage_name_py'].'" ';
			}
			$re .="<option value='".$rs['linkage_id']."' $extern_code>".$rs['linkage_name']."</option>";
	
		}
		if($re=='' && $is_child==0 ){
			die("<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."')\"><option value='".$parent_id."'>--选择--</option></select>");
		}
		if($re=='' && $is_child==1 ){
			die();
		}
		$re="<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."')\"><option value='".$parent_id."'>--选择--</option>".$re."</select>";
		echo $re;
		die();
	}
	public function  actionGetSelectClassForEdit(){
		$type=intval($this->get('linkage_id',0));
		$parent_id=intval($this->get('parent_id',0));
		$select_name=$this->get('select_name');
		$span_id=$this->get('span_id');
		$linkage_type_id=intval($this->get('linkage_type_id',0));
		$selectnum=$this->get('selectnum',0);
		$attr_extern=$this->get('attr_extern',0);
		$v_html='';
		$s_html='';
		if ($type==0){			
			$a['list']=Linkage::model()->get_linkage($parent_id,$linkage_type_id);
			foreach ($a['list'] as $r){
				$extern_code='';
				if($attr_extern=='py'){
					$extern_code=' '.$attr_extern.'="'.$r['linkage_name_py'].'" ';
				}
				$s_html .='<option value="'.$r['linkage_id'].'" '.$extern_code.'>'.$r['linkage_name'].'</option>';
			}
			$v_html ="<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."','".$attr_extern."')\"><option value='".$type."'>--选择--</option>".$s_html."</select>";
		}else{
			while ($type<>$parent_id){
				$s_html='';
				$m=Linkage::model()->findByAttributes(array('linkage_id'=>$type,'linkage_type_id'=>$linkage_type_id));
				$type=$m->parent_id;
				$a['list']=Linkage::model()->get_linkage($type,$linkage_type_id);					
				foreach ($a['list'] as $r){
					$extern_code='';
					if($attr_extern=='py'){
						$extern_code=' '.$attr_extern.'="'.$r['linkage_name_py'].'" ';
					}
					$s_html .='<option value="'.$r['linkage_id'].'" '.($r['linkage_id']==$m->linkage_id?'selected':'').' '.$extern_code.'>'.$r['linkage_name'].'</option>';
				}
				$v_html ="<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."','".$attr_extern."')\"><option value='".$type."'>--选择--</option>".$s_html."</select>".$v_html;
					
			}
		}
		die($v_html);
	}

	//反馈百科补充和纠正,0=百科,1=产品
	public function actionSaveInfoFeedback(){
		$uid=Yii::app()->company_user->uid;
		$info_id=intval($this->post('info_id'));
		$feed_type=intval($this->get('feed_type'));
		$info_table='info_wiki';
		if($feed_type==1){
			$info_table='info_product';
		}
		$feed_content=helper::escape($this->post('feed_content'),1);
		$back_img=helper::escape($this->post('back_img'),1);
		$m1=Dtable::model($info_table)->findByAttributes(array('info_id'=>$info_id));
		if(!$m1){
			$this->msg(array('state'=>0,'msgwords'=>'该信息不存在~','type'=>'json'));
		}
		$link_url=Cms::model()->set_info_url($this->toArr($m1));
		$m=Dtable::model("baike_feedback")->findByAttributes(array('company_id'=>$uid,'info_id'=>$info_id));
		if($m){
			//$this->msg(array('state'=>0,'msgwords'=>'您已经提交过，无须再次提交~','type'=>'json'));
		}
		$m=new Dtable('baike_feedback');
		$m->feed_type=$feed_type;
		$m->info_id=$info_id;
		$m->company_id=$uid;
		$m->company_name=Yii::app()->company_user->company_name;
		$m->create_time=time();
		$m->link_url=$link_url;
		$m->back_img=$back_img;
		$m->feed_content=$feed_content;
		$m->stone_cate_name=$m1->info_title;
		$m->corder=50;
		$m->save();
		$this->msg(array('state'=>1,'msgwords'=>'反馈成功，感谢您的支持！','type'=>'json'));
	}
	
	public function actionQqLogin(){
		$qc = new QC();
		$qc->qq_login();
	}
	public function actionQqLoginBack(){
		$page=array();
		if($this->get('state')==''){
			$this->msg(array('state'=>-2,'msgwords'=>'参数出错'));
		}
		$qc = new QC();
		$access_token=$qc->qq_callback();
		$qq_openid=$qc->get_openid();		 //只能调用一次，否则会client request's parameters are invalid, invalid openid的错误
		$arr=array('openid'=>$qq_openid,'access_token'=>$access_token);
		Yii::app()->session['connect_qq']=$arr;
		echo ('<script>setTimeout(\'window.location="'.$this->createUrl('post/qqLoginBackMain').'"\')</script>');
		die();
	
	}
	public function actionQqLoginBackMain(){
		$arr=Yii::app()->session['connect_qq'];
		$qc = new QC($arr['access_token'],$arr['openid']);
		$arr = $qc->get_user_info();
		$openid=Yii::app()->session['connect_qq']['openid'];
		$page['connect_data']=array('type'=>1,'name'=>'QQ','openid'=>$openid,'nickname'=>$arr['nickname'],'tou_img'=>$arr['figureurl_1']);
		//$this->render('/login',array('page'=>$page));
		$m=$this->oauthLogin($page['connect_data']['type'], $page['connect_data']['openid']);
		if($m){
			header("location:".$this->createUrl('site/index'));
		}else{
			header("location:".$this->createUrl('site/login').'?connect=1');
		}
		die();
	
	}
	/*微博登陆api
	 *
	* */
	public function actionWeiboLogin(){
		$backurl=Yii::app()->params['weibo']['redirect_uri'];
		$appkey=Yii::app()->params['weibo']['wb_akey'];
		$appsecret=Yii::app()->params['weibo']['wb_skey'];
		$o = new SaeTOAuthV2( $appkey , $appsecret );
		$code_url = $o->getAuthorizeURL($backurl);
		//die($code_url);
		header("location:$code_url");
		die();
	
	
	}
	public function actionWeiboLoginBack(){
		$backurl=Yii::app()->params['weibo']['redirect_uri'];
		$appkey=Yii::app()->params['weibo']['wb_akey'];
		$appsecret=Yii::app()->params['weibo']['wb_skey'];
		$o = new  SaeTOAuthV2( $appkey , $appsecret );
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = $backurl;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			}catch (Exception $e) {
			}
		}
	
		if (!$token) {
			$this->msg(array('state'=>-2,'msgwords'=>'授权失败'));
		}
		$arr['access_token']=$token['access_token'];
		$arr['openid']=$openid=$token['uid'];
		Yii::app()->session['connect_weibo']=$arr;
		$page['connect_data']=array('type'=>2,'name'=>'微博','openid'=>$openid,'nickname'=>'','tou_img'=>'');
		$m=$this->oauthLogin($page['connect_data']['type'], $page['connect_data']['openid']);
		if($m){
			header("location:".$this->createUrl('site/index'));
		}else{
			header("location:".$this->createUrl('site/login').'?connect=2');
		}
		die();
	
	}
	/*第三方登陆之后检测是否绑定本站账号，是的话直接登陆
	 * return bool
	* */
	private function oauthLogin($connect_type,$openid){
		$m=Dtable::model('user_thirdpassport')->findByAttributes(array('media_type'=>$connect_type,'openid'=>$openid));
		if($m){
			$mu=CompanyUser::model()->findByPk($m->uid);
			if(!$mu){
				$this->msg(array('state'=>-2,'msgwords'=>'该账号异常'));
			}
			$model = new CompanyLoginForm;
			$model->username=$mu->uname;
			if(!$model->login()){
				$this->msg(array('state'=>-2,'msgwords'=>'登陆程序错误'));
			}
			return 1;
		}
		return 0;
	
	}
	
	
	
}
?>