<?php
class UserPayController extends AdminController{

	public function actionIndex(){
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.pay_id like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.pay_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.pay_id desc      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['join']="left join user_list as b on b.uid=a.uid ";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(UserPay::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Nlink_edit');			
				$info=$this->toArr(Nlink::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('Nlink_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			$m=Nlink::model()->findByPK($id);
			if(!$m){
				$m=new Nlink();
			}
			
			$m->nlink_txt=$this->post('nlink_txt');
			if($m->nlink_txt==''){
				$this->msg(array('state'=>0,'msgwords'=>'内链名称不能为空'));
			}
			$m->nlink_url=$this->post('nlink_url');
			$m->norder=intval($this->post('norder'));
			$dbresult=$m->save();
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Nlink_edit');
				$msgarr=array('state'=>1,'url'=>$this->createUrl('nlink/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了内链 ID:'.$id.''.$m->nlink_txt.' ';
			}else{	
				$this->auth_action('Nlink_add');				
				$id=$m->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了内链ID：$dbresult".$m->nlink_txt;
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
	public function actionDelete(){
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=UserPay::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了充值ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}

}
?>