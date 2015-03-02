<?php
class InfoModelController extends AdminController{

	public function actionIndex(){
		$this->auth_action('InfoModel_Index');
		$model_cates=InfoModel::model()->get_model();
		$re_model_cates=array();
		foreach($model_cates as $r){
			$new_r=$r;
			$new_r['id']=$r['model_id'];
			$new_r['parentid']=$r['parent_model_id'];
			$new_r['model_name']=$r['model_name'];
			$new_r['model_type_name']=vars::get_field_str('model_types',$r['model_type'],'txt'); 
			$new_r['model_table_name']=$r['model_table_name'];
		    $new_r['str_manage'] ='<a href="'.$this->createUrl('modelField/index').'?model_id='.$r['model_id'].'">字段管理</a> 
	        <a href="'.$this->createUrl('infoModel/update').'?id='.$r['model_id'].'&p='.$_GET['p'].'">修改</a>
	        <a href="'.$this->createUrl('infoModel/delete').'?id='.$r['model_id'].'&p='.$_GET['p'].'"  onclick="return confirm(\'确定删除吗？\')">删除</a>';
			$new_r['info_totals']=InfoModel::model()->get_info_total($r['model_table_name']);
			$re_model_cates[]=$new_r;
		}
		$str  = "<tr>
					<td>\$id</td>
					<td class='alignleft'>\$spacer\$model_name</td>
					<td>\$model_table_name</td>
					<td>\$model_type_name</td>
					<td>\$info_totals</td>
					<td>\$str_manage</td>
				</tr>";
		$tree=new tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$tree->init($re_model_cates);
		$page['listdata'] = $tree->get_tree(0, $str);
		$this->render('index',array('page'=>$page));
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('InfoModel_edit');			
				$info=$this->toArr(InfoModel::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'数据不存在'));
				}
				$page['info']=$info;
				$parent_model_id=$page['info']['parent_model_id'];
			}else{
				$this->auth_action('InfoModel_add');
				$parent_model_id=0;
			}
			$page['model_cates']=InfoModel::model()->get_model_option_tree($parent_model_id);
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['model_name']=$this->post('model_name');
			if($field['model_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'模型名称不能为空'));
			}
			$field['model_table_name']=$this->post('model_table_name');	
			if($field['model_table_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'表名需规范'));
			}
			$field['cmodel_id']=intval($this->post('cmodel_id'));							
			$sql22="select count(1) total from model where model_table_name='".$field['model_table_name']."' and model_id!=".$id." ";
			$rsdd=Yii::app()->db->createCommand($sql22)->queryAll();
			if($rsdd[0]['total']>0){
			    $this->msg(array('state'=>0,'msgwords'=>'表名重复'));	
			}			
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('InfoModel_edit');
				$dbresult=InfoModel::model()->updateAll($field,"model_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('infoModel/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了模型 ID:'.$id.''.$field['model_name'].' ';
			}else{	
				$field['model_type']=$this->post('model_type');
				$field['parent_model_id']=$this->post('parent_model_id');
				$this->auth_action('InfoModel_add');
				$post=$this->data('InfoModel',$field);
				$transaction = Yii::app()->db->beginTransaction();			
				try {
					$dbresult=$post->save();
					$id=$post->primaryKey;
					$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
					$logs="添加了模型ID：$dbresult".$field['model_name'];
					if($id){
						InfoModel::model()->create_table($field['model_type'],$field['parent_model_id'],$id,$field['model_table_name']);
					}
				} catch (Exception $e) {print_r($e->getMessage());
					$transaction->rollback(); //如果操作失败, 数据回滚
					$this->msg(array('state'=>-1,'msgwords'=>'出现错误'));
				}
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
		$this->auth_action('InfoModel_del');
		$id=intval($this->get('id'));
		$m=InfoModel::model()->findByPk($id);
		if(!$m){
			$this->msg(array('state'=>0,'msgwords'=>'模型不存在'));
		}
		$transaction = Yii::app()->db->beginTransaction();
		try {
			//die($a['list'][0]['model_table_name']);
			$table=$m->model_table_name;
		    $sql=" drop table if exists `".$table."` ";
			Yii::app()->db->createCommand($sql)->execute();	
			$m->delete();
			ModelField::model()->deleteAll("model_id=$id");
		} catch (Exception $e) {
			$transaction->rollback(); //如果操作失败, 数据回滚
			$this->msg(array('state'=>0,'msgwords'=>'出现错误'));
		}
	
		$this->logs('删除了模型ID（'.$id.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('InfoModel_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=InfoModel::model()->findByPk($id);
			if(!$m) continue;
			$m->norder=$order;
			$m->save();		
		}
		$this->logs('修改了模型的排序');
		$this->msg(array('state'=>1));
	}

}
?>