<?php
class AdController extends AdminController{

	public function actionIndex(){
		$this->auth_action('Ad_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.ad_title like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){
			$params['where'] .=" and(a.ad_id=".intval($this->get('search_txt')).") ";
		}else if($this->get('search_type')=='area_id'  && $this->get('search_txt')!=''){
	        $params['where'] .=" and(a.area_id=".intval($this->get('search_txt')).") ";	
		}else if($this->get('search_type')=='z_expire_date'){  //正常显示
	        $params['where'] .=" and(a.expire_date>'".(time()+3600*24*7)."')";
		}else if($this->get('search_type')=='k_expire_date'){ //快到期
	        $params['where'] .=" and(a.expire_date<'".(time()+3600*24*7)."' and a.expire_date>'".(time())."')";
		}else if($this->get('search_type')=='y_expire_date'){ //已到期
	        $params['where'] .=" and(a.expire_date<'".(time())."')";
		}
		$params['order']="  order by a.ad_order,ad_id desc      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['join']="left join ad_area as b on b.area_id=a.area_id ";
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(Ad::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Ad_edit');			
				$info=$this->toArr(Ad::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'文档不存在'));
				}
				$page['info']=$info;
				$catid=$page['info']['url_cate_id'];
				//print_r($page['recommend']);
			}else{
				$this->auth_action('Ad_add');
				$catid=0;
			}
			$page['categorys']=InfoCategory::model()->category_tree($catid);
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['ad_title']=$this->post('ad_title');
			if($field['ad_title']==''){
				$this->msg(array('state'=>0,'msgwords'=>'广告名称不能为空'));
			}
			$field['ad_words']=$this->post('ad_words');
			$field['ad_img']=$this->post('ad_img');
			$field['area_id']=$this->post('area_id');
			$field['city_id']=$this->post('city_id');
			$field['ad_url']=$this->post('ad_url');
			$field['url_cate_id']=$this->post('url_cate_id');
			$field['ad_code']=$this->post('ad_code');
			$field['start_date']=strtotime($this->post('start_date'));
			$field['expire_date']=strtotime($this->post('expire_date'));
			$field['show_type']=intval($this->post('show_type'));
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Ad_edit');
				$dbresult=Ad::model()->updateAll($field,"ad_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('ad/index').'?p='.$_GET['p'].'&search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').''); //保存的话，跳转到之前的列表
				$logs='修改了广告 ID:'.$id.''.$field['ad_title'].' ';
			}else{	
				$this->auth_action('Ad_add');
				$field['create_date']=time();
				$post=$this->data('Ad',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了广告ID：$dbresult".$field['ad_title'];
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
		$this->auth_action('Ad_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Ad::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了广告ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('Ad_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Ad::model()->findByPk($id);
			if(!$m) continue;
			$m->ad_order=$order;
			$m->save();		
		}
		$this->logs('修改了广告的排序');
		$this->msg(array('state'=>1));
	}

}
?>