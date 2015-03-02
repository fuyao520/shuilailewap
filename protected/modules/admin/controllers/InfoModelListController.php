<?php
class InfoModelListController extends AdminController{
	public $page=array();
	public function init(){
		parent::init();
		$page=array();
		//本页面的所有操作必须传入 get 的 model_id，否则无法进行操作
		if(!$this->get('model_id')){
		   	$this->msg(array('state'=>-1,'msgwords'=>'请选择模型'));
		}else{
			$sql="select * from model where model_id=".$this->get('model_id');
			$am['list']=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($am['list'])==0){
				$this->msg(array('state'=>-2,'msgwords'=>'模型错误'));
			}
			$page['model_info']=$am['list'][0];
			//模型字段用于在列表显示的
			$m=ModelField::model()->get_model_field($this->get('model_id'));
			$page['model_fields']=array();
			$page['mymodelfs']=$m;
			$del_fields=array('info_title','info_body','last_cate_id','info_id','info_attr_limits','info_attr_title','info_desc');
			foreach($m as $b){
				if(($b['list_show']==1) && (!in_array($b['field_name'],$del_fields)) ){
					$page['model_fields'][]=$b;
				}
			}
			//模型字段 用于在 添加和修改的时候显示
			$page['model_fields2']=array();
			$del_fields=array('info_title','last_cate_id','info_editor','info_id','create_time','info_attr_limits','info_attr_title','info_order','info_jump_url','info_visitors','info_tags','audit','flag_c','flag_h','flag_s','flag_a','flag_d','info_py','info_extern');
			foreach($m as $b){
				if((!in_array($b['field_name'],$del_fields)) ){
					$page['model_fields2'][]=$b;
				}
			}
			//print_r($model_feilds);
			$models=InfoModel::model()->models;
			$page['cmodel']=InfoModel::model()->get_child_model_cates($models,$page['model_info']['model_id']);
			//同类模型 的 分类
			$page['categorys_option']=InfoCategory::model()->category_model_tree($page['model_info']['model_id']);
			$this->page=$page;
		}
	}

	public function actionIndex(){	
		$page=$this->page;	
		//搜索
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.info_title like '%".$this->get('search_txt')."%' or a.info_py like '%".$this->get('search_txt')."%' or a.info_tags like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id' && $this->get('search_txt')){
			$params['where'] .=" and(a.info_id=".intval($this->get('search_txt')).") ";
		}
		if($this->get('audit')!=''){
			$params['where'] .=' and a.audit=0 ';
		}			
		
		/*********************** 支持联动菜单搜索********************/

		
		//搜索
		foreach($page['model_fields2'] as $f){if($f['form_type'] !='linkage')continue;
			$v=$this->get($f['field_name']);
			if(!is_array($v)) continue;
			$v2=form_type_code::get_html(array('m'=>'get_post_value','post_value'=>$v,'type'=>$f['form_type'],'linkage_type_id'=>$f['linkage_type_id']));
			if(is_numeric($v2)){
				$vdatas=Linkage::model()->get_linkage_data($f['linkage_type_id']);
				$inid=Linkage::model()->get_linkage_child_id_str($vdatas,$v2);
				$params['where'].=" and a.".$f['field_name']." in ($inid) ";
			}	
			$_GET[$f['field_name']]=$v[count($v)-1];
		}
		/**************************************/
		$params['select']="c.*,a.* ";
		$params['order']="  order by a.info_order,a.info_id desc    ";
		$params['join']=" left join  info_category as c on c.cate_id=a.last_cate_id ";
		$params['pagesize']=$this->get('pagesize')>0?intval($this->get('pagesize')):Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		//$params['debug']=1;
		$params['smart_order']=1;
		
		$page['listdata']=Dtable::model($page['model_info']['model_table_name'])->listdata($params);	
		
		$this->render('index',array('page'=>$page));
			
		
	}

	public function actionUpdate(){
		$page=$this->page;
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$sql="select b.*,a.* from ".$page['model_info']['model_table_name']." as a
		left join info_category as b on b.cate_id=a.last_cate_id
		where a.info_id=".$id;
				$info=Yii::app()->db->createCommand($sql)->queryAll();
				if(count($info)==0){
					$this->msg(array('state'=>0,'msgwords'=>'文档不存在'));
				}
				$page['info']=$info[0];
				//print_r($page['info']);
				$page['categorys_option']=InfoCategory::model()->category_model_tree($page['model_info']['model_id'],$page['info']['last_cate_id']);
				$page['resource_list']=Attachment::get_attachment($page['model_info']['model_table_name'].'-'.$id);
				$page['info']['info_attr_title']=json_decode($page['info']['info_attr_title'],true);
				$page['info_relation_infos']=InfoModel::model()->get_info_info_relation_infos($id,$page['model_info']['model_id'])	;
			}else{
			}
				
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field['last_cate_id']=$this->post('last_cate_id',0);
			$field['info_title']=$this->post('info_title');;
			$field['info_title']=htmlspecialchars(preg_replace('~\"~','"',$field['info_title']));
			if($field['info_title']==''){
				//msg(array('state'=>0,'msgwords'=>'标题不能为空'));
			}
			
			
			//模型的字段
			foreach($page['model_fields2'] as $f){
				$field[$f['field_name']]=$this->post($f['field_name']);
				$field[$f['field_name']]=form_type_code::get_html(array('m'=>'get_post_value','post_value'=>$field[$f['field_name']],'type'=>$f['form_type'],'linkage_type_id'=>$f['linkage_type_id']));
			
			}
			//print_r($field);die();
			
			/*
			//扩展属性
			$field['info_extern']=array();
			$page['model_info']['extern_content']=json_decode($page['model_info']['extern_content'],1);
			if(!is_array($page['model_info']['extern_content'])) $page['model_info']['extern_content']=array();
			//模型的字段
			foreach($page['model_info']['extern_content'] as $f){
				$_POST['extern__'.$f['name']]=$this->post('extern__'.$f['name']);
				$field['info_extern'][$f['name']]=form_type_code::get_html(array('m'=>'get_post_value','post_value'=>$_POST['extern__'.$f['name']],'type'=>$f['type']));
			}
			//print_r($field);die();
			$field['info_extern']=helper::json_encode_cn($field['info_extern']);
			*/
			
			$field['info_order']=$this->post('info_order',0);
			$field['info_jump_url']=$this->post('info_jump_url');
			$field['info_tags']=$this->post('info_tags');
			$field['create_time']=strtotime($this->post('create_time'));
			if($this->post('info_desc')){
				$field['info_desc']=$_POST['info_desc'];
			}else if($this->post('info_desc')==''){
				$field['info_desc']=mb_substr(str_replace("&nbsp;",'',strip_tags($field['info_body'])),0,100,'utf-8');
			}
			
			
			
			$field['info_attr_title']=json_encode($this->post('info_attr_title'));
			$field['audit']=$this->post('audit',0);
			$field['flag_c']=$this->post('flag_c',0);
			$field['flag_h']=$this->post('flag_h',0);
			$field['flag_s']=$this->post('flag_s',0);
			$field['flag_a']=$this->post('flag_a',0);
			$field['flag_d']=$this->post('flag_d',0);
			$field['info_py']=$this->post('info_py');
			
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$dbresult=Dtable::model($page['model_info']['model_table_name'])->updateAll($field,"info_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('infoModelList/index').'?model_id='.$_GET['model_id'].'&p='.$_GET['p'].''); //保存的话，跳转到之前的列表					
				$logs='修改了内容 ID:'.$id.''.$field['info_title'].' ';
			}else{
				$field['info_editor']=Yii::app()->admin_user->uname;
				$post=$this->data('Dtable',$field,$page['model_info']['model_table_name']);
				$dbresult=$post->save();  
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了内容ID：$dbresult".$field['info_title'];
			}					
			if($dbresult===false){
				//错误返回
				$this->msg(array('state'=>0));
			}else{
				//新增和修改之后的动作  
				
				$this->logs($logs);
				//信息-信息 关系表
				InfoModel::model()->save_info_relation_recommend($id,$page['model_info']['model_id'],$this->post('relation_recommend'));
				
				//保存资源图片
				$resource_data=isset($_POST['resource_data'])&&is_array($_POST['resource_data'])?$_POST['resource_data']:array();
				Attachment::model()->save_attachment($page['model_info']['model_table_name'].'-'.$id,$resource_data);
				
				
				//成功跳转提示
				$this->msg($msgarr);				
			}
			
		}
		$this->render('update',array('page'=>$page));
	}

	
	
	
	public function actionSaveOrder(){
		$page=$this->page;
		if(isset($_POST['listorders'] )){		
			foreach($_POST['listorders'] as $id=>$corder){
				$m=Dtable::model($page['model_info']['model_table_name'])->findByPk($id);	
				if(!$m) continue;
				$m->info_order=intval($corder);
				$m->save();
			}
		}
		$this->logs('修改了内容的排序');		
		$this->msg(array('state'=>1));
	}
	
	public function actionDelete(){
		$page=$this->page;
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		$info_table=$page['model_info']['model_table_name'];
		foreach($ids as $id){
			$id=intval($id);
			$info_table=$page['model_info']['model_table_name'];
			$sql=" delete a,r1,r2,resource_list  from $info_table as a ";
			$sql .=" left join info_info_relation as r1 on r1.info_id=a.info_id  "; // 关联资讯表
			$sql .=" left join info_info_relation as r2 on r2.info_id_related=a.info_id "; // 关联资讯表-被关联
			$sql .=" left join resource_list on resource_list.fromid=concat('".$page['model_info']['model_table_name']."','-',a.info_id) "; // 资源表
			$sql .=" where a.info_id=".$id."";  
			//echo $sql;die();
			Yii::app()->db->createCommand($sql)->execute();
			foreach($page['cmodel'] as $r){
				$sql2="delete from ".$r['model_table_name']." where info_id=$id ";
				Yii::app()->db->createCommand($sql2)->execute();
			}
		}
		$this->logs('删除了内容,ID：'.implode(',',$ids));	
		$this->msg(array('state'=>1));	
	}
	public function actionAuditInfo(){
		$page=$this->page;
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		$audit=isset($_GET['audit'])?intval($_GET['audit']):0;
		$info_table=$page['model_info']['model_table_name'];
		foreach($ids as $id){
			$id=intval($id);
			$sql=" update  $info_table  set  audit=$audit   where info_id=".$id." ";  
			//echo $sql;
			Yii::app()->db->createCommand($sql)->execute();
		}
		//die();
		$this->msg(array('state'=>1));	
	}
	public function actionSetFlag(){
		$page=$this->page;
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		$flag=isset($_GET['flag'])?helper::escape($_GET['flag']):0;
		$info_table=$page['model_info']['model_table_name'];
		foreach($ids as $id){
			$id=intval($id);
			if($flag=='none'){
			    $sql=" update  $info_table  set  flag_c=0,flag_h=0,flag_s=0,flag_a=0   where info_id=".$id." ";     	
			}else{
			    $sql=" update  $info_table  set  ".$flag."=1   where info_id=".$id." ";  
			}
			//echo $sql;
			Yii::app()->db->createCommand($sql)->execute();
		}
		$this->logs('设置了属性，影响ID：'.implode(',',$ids).' '.$flag);	
		die('1');
	}
	//转移分类
	function actionSetInfoCate(){
		$page=$this->page;
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		$set_cate_id=isset($_GET['set_cate_id'])?intval($_GET['set_cate_id']):0;
		if($set_cate_id==0){
		    die('0');    	
		}
		$info_table=$page['model_info']['model_table_name'];
		foreach($ids as $id){
			$id=intval($id);
			$sql=" update  $info_table  set  last_cate_id=$set_cate_id   where info_id=".$id." ";     	
			//echo $sql;
			Yii::app()->db->createCommand($sql)->execute();
		}
		$this->logs('转移到分类['.$page['model_info']['cname'].']，影响ID：'.implode(',',$ids).' ');	
		die('1');
	}
	//设置推荐位
	public function actionSetRecommend(){
		$page=$this->page;
		$ids=$this->get('ids');
		$model_table_name=$this->get('model_table_name');
		$ids=explode(',',$ids);
		$set_recommend_id=$this->get('set_recommend_id',0);
		if($set_recommend_id==0){
		    die('{"code":0,"statewords":"推荐位不能为空"}');    	
		}
		$a=$this->query("select * from recommend where recommend_id=$set_recommend_id");
		if(count($a)==0){
			die('{"code":0,"statewords":"推荐位不存在"}'); 
		}
		$recommend_data=$a[0];
		$inid=$a[0]['inid'];
		if($inid==''){
			$id_list=array();
		}else{
			$id_list=explode(',',$inid);
		}	
	    foreach($ids as $r) {
	        if (!in_array($r, $id_list)){
				$id_list[]=$r;	
			}
	    }
		$new_in_id=implode(',',$id_list);//print_r($new_id_list);
		$sql="update recommend set inid='".$new_in_id."' where recommend_id=".$set_recommend_id;
		$a=Yii::app()->db->createCommand($sql)->execute();
		$this->logs('新加入['.$page['model_info']['model_table_name'].']的ID：'.implode(',',$ids).'到推荐位['.$recommend_data['recommend_name'].']');
		die('{"code":1,"statewords":"操作成功"}'); 	
	
	}
	
	//加入专题
	public function actionSetSpecial(){
		$page=$this->page;
		$ids=isset($_GET['ids'])&&$_GET['ids']!=''?$_GET['ids']:'';
		$ids=explode(',',$ids);
		$set_special_id=isset($_GET['set_special_id'])?intval($_GET['set_special_id']):0;
		$small_cate=isset($_GET['small_cate'])?($_GET['small_cate']):'';
		if($set_special_id==0){
		    die('{"code":0,"statewords":"专题不能为空"}');    	
		}
		$a=$this->query("select * from info_special where special_id=$set_special_id");
		if(count($a)==0){
			die('{"code":0,"statewords":"专题不存在"}'); 
		}
		$special_data=$a[0];
		foreach($ids as $id){
			$a=$this->query("select * from ".$page['model_info']['model_table_name']." where info_id=".$id);
			if(count($a)==0) continue;
			$field=array();
			$field['special_id']=$set_special_id;
			$field['info_id']=$id;
			$field['model_id']=$page['model_info']['model_id'];
			$field['special_type']=$small_cate;
			$field['info_title']=$a[0]['info_title'];
			$field['i_s_order']=50;
			$sql=helper::get_sql('info_special_relation','insert',$field);	
			$post=$this->data('InfoSpecialRelation',$field,$page['model_info']['model_table_name']);
			$dbresult=$post->save();
		}		
		$this->logs('新加入['.$page['model_info']['model_table_name'].']的ID：'.implode(',',$ids).'到专题['.$special_data['special_name'].']');
		die('{"code":1,"statewords":"操作成功"}');
	}
	
	//设置推荐位
	public function actionDelRecommend(){
		$page=$this->page;
		$recommend_id=$this->get('recommend_id',0);
		$info_id=$this->get('info_id',0);
		$table=isset($_GET['table'])?$_GET['table']:'';
		if($recommend_id==0){
		    die('{"code":0,"statewords":"推荐位不能为空"}');    	
		}
		$a=$this->query("select * from recommend where recommend_id=$recommend_id and table_name='$table'");
		if(count($a)==0){
			die('{"code":0,"statewords":"推荐位不存在"}'); 
		}
		$recommend_data=$a[0];
		$inid=$a[0]['inid'];
		if($inid==''){
			$id_list=array();
		}else{
			$id_list=explode(',',$inid);
		}	
		$new_id_list=array();
	    foreach($id_list as $r) {
	        if ($r!=$info_id){
				$new_id_list[]=$r;	
			}
	    }
		$new_in_id=implode(',',$new_id_list);//print_r($new_id_list);
		$sql="update recommend set inid='".$new_in_id."' where recommend_id=".$recommend_id;//echo $sql;
		$a=Yii::app()->db->createCommand($sql)->execute();		
		$this->logs('['.$page['model_info']['model_table_name'].']的ID：'.implode(',',$id_list).'在推荐位['.$recommend_data['recommend_name'].']中删除');
		die('{"code":1,"statewords":"操作成功"}');
	}
	
	//取消专题的信息
	public function actionDelSpecial(){
		$page=$this->page;
		$special_id=isset($_GET['special_id'])?$_GET['special_id']:0;
		$info_id=isset($_GET['info_id'])?$_GET['info_id']:0;
		$model_id=isset($_GET['model_id'])?intval($_GET['model_id']):0;
		$sql="delete from info_special_relation where info_id=$info_id  and special_id=$special_id and model_id=$model_id ";
		$a=Yii::app()->db->createCommand($sql)->execute();		
		$this->logs('['.$page['model_info']['model_table_name'].']的ID：'.$info_id.'在专题ID:'.$special_id.'中删除');
		die('{"code":1,"statewords":"操作成功"}'); 	
		
	}
	//删除资源
	public function actionDelResource(){
		$page=$this->page;
		$_GET['resource_id']=isset($_GET['resource_id'])?intval($_GET['resource_id']):0;
		$sql="delete r from resource_list as r where resource_id=".$_GET['resource_id'];
		Yii::app()->db->createCommand($sql)->execute();
		die();
	}
	//取所有子模型
	function get_child_model_cates($model_cates,$parent_id){
		$bb=array();
		foreach($model_cates as $c){
			if($c['parent_model_id']==$parent_id){
				$bb[]=$c;	
				$son=get_child_model_cates($model_cates,$c['model_id']);
				$bb=array_merge($bb,$son);
			}
		}
		return $bb;
	}
}
?>