<?php
class CompanyController extends AdminController{

	public function actionIndex(){
		$this->auth_action('Company_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.uname like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.uid=".intval($this->get('search_txt')).") ";
		}
		$params['select']="g.linkage_name as city_name,a.*";
		$params['order']="  order by a.uid      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['join']="left join linkage as g on g.linkage_id=a.city_id";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(Company::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));		
	}		
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Company_edit');			
				$info=$this->toArr(Company::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('Company_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['uname']=$this->post('uname');
			$upass=$this->post('upass');
			if(verify::check_username($field['uname'])==0){
				$this->msg(array('state'=>0,'msgwords'=>'会员帐号不合法'));
			}
			if($upass||!$id){
				if(verify::check_password($upass)==0){
					$this->msg(array('state'=>0,'msgwords'=>'密码格式不正确,6-20位'));
				}
				$field['upass']=Company::password_encryption($upass);
			}
			$andwhere=$id?" and uid!=$id":'';
			$sql=" select count(1) as total from company_user_list where uname='".$field['uname']."' $andwhere  ";
			$k001=Yii::app()->db->createCommand($sql)->queryAll();
			if($k001[0]['total']>0){
				$this->msg(array('state'=>0,'msgwords'=>'该帐号已存在！'));
			}
			$field['uemail']=$this->post('uemail');
			$field['uphone']=$this->post('uphone');
			$field['user_money']=$this->post('user_money');
			$field['uname_true']=$this->post('uname_true');
			$field['url_py']=$this->post('url_py');
			if(!isset($_POST['city_id'])) $_POST['city_id']=array();
			$field['city_id']=isset($_POST['city_id'][count($_POST['city_id'])-1])?intval($_POST['city_id'][count($_POST['city_id'])-1]):0;
			$field['audit']=$this->post('audit');
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Company_edit');
				$dbresult=Company::model()->updateAll($field,"uid=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('companyUser/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了会员 ID:'.$id.''.$field['uname'].' ';
			}else{	
				$field['reg_date']=time();
				$this->auth_action('Company_add');
				$post=$this->data('Company',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了会员ID：$dbresult".$field['uname'];
			}
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{
				//新增和修改之后的动作
	
				$this->logs($logs);
				//成功跳转提示
				$this->msg($msgarr);
			}
	
		}
		$this->render('update',array('page'=>$page));
	}
	public function actionChangeState(){
		$this->auth_action('Company_state');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		$ustate=intval($this->get('ustate'));
		foreach($ids as $id){
			$id=intval($id);		
			$m=Company::model()->findByPk($id);
			$m->ustate=$ustate;
			$m->save();
		}
		//die();
		$this->msg(array('state'=>1));
	}
	public function actionDelete(){
		$this->auth_action('Company_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Company::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			Dtable::model('companyUser_extern')->deleteAll("uid=$id");
			Dtable::model('companyUser_login')->deleteAll("uid=$id");		
		}
		$this->logs('删除了会员ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	

}
?>