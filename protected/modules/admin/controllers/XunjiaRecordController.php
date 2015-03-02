<?php
class XunjiaRecordController extends AdminController{

	public function actionIndex(){
		$this->auth_action('XunjiaRecord_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.order_no like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.id=".intval($this->get('search_txt')).") ";
		}else if($this->get('search_type')=='company_name'  && $this->get('search_txt')){ //工厂ID
			$params['where'] .=" and(c.company_name='".trim($this->get('search_txt'),'')."') ";
		}else if($this->get('search_type')=='info_order_id'  && $this->get('search_txt')){ //订单ID
			$params['where'] .=" and(a.info_order_id=".intval($this->get('search_txt')).") ";
		}
		$params['order']="  order by a.create_time      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['join']="left join company_user_list as b on b.uid=a.uid 
						left join company as c on c.company_id=b.uid
				";
		$params['select']="a.*,b.uname,c.company_name";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(XunjiaRecord::model()->tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionDetails(){
		$page=array();
		$id=isset($_GET['id'])?intval($_GET['id']):0;
		$p=isset($_GET['p'])?intval($_GET['p']):1;
		if($id==0){
			$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
		}else{
			$params['where']=' and id='.$id.'';
			$params['order']="  order by a.create_time      ";
			$params['join']="left join company_user_list as b on b.uid=a.uid 
						left join company as c on c.company_id=b.uid
				";
			$params['select']="a.*,b.uname,c.company_name";
			$page['listdata']=Dtable::model(XunjiaRecord::model()->tableName())->listdata($params);
		}

		$this->render('details',array('page'=>$page));		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('XunjiaRecord_edit');			
				$info=$this->toArr(XunjiaRecord::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('XunjiaRecord_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['order_no']=$this->post('order_no');
			if($field['order_no']==''){
				$this->msg(array('state'=>0,'msgwords'=>'内链名称不能为空'));
			}
			$field['orderGet_url']=$this->post('orderGet_url');
			$field['norder']=$this->post('norder',0);
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('XunjiaRecord_edit');
				$dbresult=XunjiaRecord::model()->updateAll($field,"orderGet_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('orderGet/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了内链 ID:'.$id.''.$field['order_no'].' ';
			}else{	
				$this->auth_action('XunjiaRecord_add');
				$post=$this->data('XunjiaRecord',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了内链ID：$dbresult".$field['order_no'];
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
		$this->auth_action('XunjiaRecord_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=XunjiaRecord::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了内链ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('XunjiaRecord_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=XunjiaRecord::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了内链的排序');
		$this->msg(array('state'=>1));
	}

}
?>