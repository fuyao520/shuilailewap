<?php
class ModelFieldController extends AdminController{
	public $page=array();
	public function init(){
		parent::init();
		$page=array();
		$model_id=$this->get('model_id');
		$m=InfoModel::model()->findByPk($model_id);
		if(!$m){
			$this->msg(array('state'=>0,'msgwords'=>'模型不存在'));
		}
		$page['model_info']=$this->toArr($m);
		$this->page=$page;
	}
	public function actionIndex(){
		$page=$this->page;
		$this->auth_action('ModelField_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.field_txt like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.field_id=".intval($this->get('search_txt')).") ";
		}
		if($this->get('model_id')){
			$params['where'] .=" and a.model_id=".$this->get('model_id');
		}
		$params['order']="  order by a.field_order,a.field_id asc     ";
		$params['pagesize']=100;
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model(ModelField::tableName())->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=$this->page;
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('ModelField_edit');			
				$info=$this->toArr(ModelField::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				$page['info']['setting']=json_decode($page['info']['setting'],true);
				$page['info']['setting']['default_value']=isset($page['info']['setting']['default_value'])?urldecode($page['info']['setting']['default_value']):'';
				$page['info']['setting']['ini_value']=isset($page['info']['setting']['ini_value'])?urldecode($page['info']['setting']['ini_value']):'';
			}else{
				$this->auth_action('ModelField_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['field_name']=$this->post('field_name');
			$field['model_id']=$this->post('model_id');
			if(trim($field['field_name'])==''){
				$this->msg(array('state'=>0,'msgwords'=>'名称不能为空'));
			}
			$field['field_txt']=$this->post('field_txt');
			if(trim($field['field_txt'])==''){
				$this->msg(array('state'=>0,'msgwords'=>'字段不合法'));
			}
			$field['tips']=$this->post('tips');
			$field['form_type']=$this->post('form_type');
		    $field['length']=$this->post('length');
		    $field['field_order']=intval($this->post('field_order'));
			$field['linkage_type_id']=intval($this->post('linkage_type_id'));
			$field['linkage_select_parent_id']=intval($this->post('linkage_select_parent_id'));
			$field['linkage_select_selectnum']=intval($this->post('linkage_select_selectnum'));
		    $field['setting']=$this->post('setting');
		    if(is_array($field['setting'])){
				foreach($field['setting'] as $k=>$p){
				    $field['setting'][$k]=urlencode($p);	
				}
		    }
			$field['setting']=json_encode($field['setting']);
		    $field['is_system']=intval($this->post('is_system'));
			$field['list_show']=intval($this->post('list_show'));
			$transaction = Yii::app()->db->beginTransaction();
			try {
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('ModelField_edit');
				$m=ModelField::model()->findByPk($id);
				$old_field['field_name']=$m->field_name;
				$dbresult=ModelField::model()->updateAll($field,"field_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('modelField/index').'?model_id='.$_GET['model_id'].'&p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了模型字段 ID:'.$id.''.$field['field_txt'].' ';
				//修改字段
				$cs='';
				$table=$page['model_info']['model_table_name'];
				$field_name=$field['field_name'];
				$old_field_name=$old_field['field_name'];
				$length=$field['length'];
				$comment=$field['field_txt'];
				$w=vars::get_field_str('form_types',$field['form_type'],'type');
				if($w=='int' || $w=='decimal'){
					if($field_name=='info_id'){
						$cs=" alter table $table change  $old_field_name $field_name  int(11) not null auto_increment comment '$comment' ;";
					}else{
						$cs=" alter table $table change  $old_field_name $field_name $w($length) not null default 0 comment '$comment';";
					}
				}
				if($w=='varchar'||$w=='char'){
					$cs=" alter table $table change  $old_field_name $field_name $w($length) not null default '' comment '$comment' ;";
				}
				if($w=='text'){
					$cs=" alter table $table change  $old_field_name $field_name $w  not null default '' comment '$comment';";
				}//die($cs);
				Yii::app()->db->createCommand($cs)->execute();
				
			}else{	
				$this->auth_action('ModelField_add');
				$post=$this->data('ModelField',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了模型字段ID：$dbresult".$field['field_txt'];
				
				$cs='';
				$table=$page['model_info']['model_table_name'];
				$field_name=$field['field_name'];
				$length=$field['length'];
				$comment=$field['field_txt'];
				$w=vars::get_field_str('form_types',$field['form_type'],'type');
				if($w=='int' || $w=='decimal'){
					if($field_name=='info_id'){
						$cs=" alter table $table Add column $field_name int(11) not null auto_increment comment '$comment' ;";
					}else{
						$cs=" alter table $table Add column $field_name $w($length) not null default 0 comment '$comment';";
					}
				}
				if($w=='varchar'||$w=='char'){
					$cs=" alter table $table Add column $field_name $w($length) not null default '' comment '$comment' ;";
				}
				if($w=='text'){
					$cs=" alter table $table Add column $field_name $w  not null default '' comment '$comment';";
				}
				Yii::app()->db->createCommand($cs)->execute();
			}
			} catch (Exception $e) {print_r($e->getMessage());
			$transaction->rollback(); //如果操作失败, 数据回滚
			$this->msg(array('state'=>-1,'msgwords'=>'出现错误'));
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
		$this->auth_action('ModelField_del');
		$page=$this->page;
		$id=$this->get('id');
		$m=ModelField::model()->findByPk($id);
		if(!$m) continue;		
		$table=$page['model_info']['model_table_name'];
		$field_name=$m->field_name;
		$sql=" alter table $table drop column $field_name ;";
		$transaction = Yii::app()->db->beginTransaction();
		try {
			Yii::app()->db->createCommand($sql)->execute();
			$m->delete();
		} catch (Exception $e) {print_r($e->getMessage());
			$transaction->rollback(); //如果操作失败, 数据回滚
			$this->msg(array('state'=>-1,'msgwords'=>'出现错误'));
		}
		$this->logs('删除了模型字段ID（'.$id.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('ModelField_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=ModelField::model()->findByPk($id);
			if(!$m) continue;
			$m->field_order=$order;
			$m->save();		
		}
		$this->logs('修改了模型字段的排序');
		$this->msg(array('state'=>1));
	}
	public function actionGetLinkageType(){
		$page=$this->page;
		$linkage_type_id=intval($this->get('linkage_type_id'));
		$m=LinkageType::model()->findByPk($linkage_type_id);
		if(!$m){
			die('<font color=red>联动类型不存在！</font>');
		}
		die($m->linkage_type_name);	
	}

}
?>