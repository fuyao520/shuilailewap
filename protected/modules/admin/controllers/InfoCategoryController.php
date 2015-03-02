<?php
class InfoCategoryController extends AdminController{
	public function actionIndex(){
		$categorys=array();
		$catearr=InfoCategory::model()->categorys;
		$page['idarr']=array();
		foreach($catearr as $r){
			$new_r=$r;
			$page['idarr'][]=$r['cate_id'];
			$new_r['id']=$r['cate_id'];
			$new_r['parentid']=$r['parent_id'];
			$new_r['cname']=$r['cname'];
			$new_r['corder']=$r['corder'];
			$new_r['totals']=$r['totals'];
			$new_r['str_manage'] ='
					<a href="'.$this->createUrl('infoCategory/update',array('cate_id'=>$r['cate_id'],'model_id'=>$r['model_id'])).'">添加子栏目</a> 
					<a href="'.$this->createUrl('infoCategory/resetNamePy',array('cate_id'=>$r['cate_id'],'model_id'=>$r['model_id'],'parent_id'=>$r['cate_id'])).'" onclick="return confirm(\'确定\');">重置子栏目拼音</a> 
				    <a href="'.$this->createUrl('infoCategory/update',array('id'=>$r['cate_id'],'model_id'=>$r['model_id'])).'">修改</a>  
				    <a href="'.$this->createUrl('infoCategory/delete',array('id'=>$r['cate_id'],'model_id'=>$r['model_id'])).'" onclick="return confirm(\'确定删除吗\')">删除</a>';
			$new_r['is_nav_show']=$r['nav_show']?'<font color=red>√</font>':'<font color="#cccccc">×</font>';
			$new_r['is_single']=$r['single']?'<font>单篇介绍</font>':'<font color="#cccccc"></font>';
			$categorys[]=$new_r;
		}
		$str  = "<tr>
						<td><input name='listorders[\$id]' type='text' size='3' value='\$corder' class='input-text-c'></td>
						<td>\$id</td>
						<td class='alignleft'>\$spacer\$cname</td>
						<td >\$is_nav_show</td>
						<td>\$is_single</td>
						<td>\$model_name</td>
						<td id='fei_\$id'>\$totals</td>
						<td>\$str_manage</td>
					</tr>";
		$tree=new tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		$tree->init($categorys);
		$category_code = $tree->get_tree(0, $str);
		$page['categorys']=$category_code;
		$this->render('index',array('page'=>$page));
	}
	public function actionUpdate(){
		$id=$_GET['id']=isset($_GET['id'])?intval($_GET['id']):0;
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$cate=InfoCategory::model()->categorys[$id];	
				$page['info']=$cate;
				$cate_id=$cate['parent_id'];
				$cate_id2=$cate['relation_cate_id'];
				$model_id=$cate['model_id'];
				//$page['info']['csetting']=helper::json_decode_cn($page['info']['csetting'],true);			
			}else{		
				$_GET['cate_id']=intval($this->get('cate_id'));
				$model_id=$_GET['model_id']=isset($_GET['model_id'])?intval($_GET['model_id']):0;
				$cate_id=$_GET['cate_id'];
				$cate_id2=$_GET['cate_id'];
				if($_GET['cate_id']){
					$page['parentcate']=$this->toArr(InfoCategory::model()->findByPk($_GET['cate_id']));
					$page['parentcate']['csetting']=helper::json_decode_cn($page['parentcate']['csetting'],true);
				}
				
			}		
			$page['categorys']=InfoCategory::model()->category_tree($cate_id);
			$page['categorys2']=InfoCategory::model()->category_tree($cate_id2);
			$page['model_field']=ModelField::model()->get_model_field($model_id);
			
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field['parent_id']=$this->post('parent_id',0);
			$field['relation_cate_id']=$this->post('relation_cate_id',0);
			$field['model_id']=$this->post('model_id',0);
			$field['cname']=$this->post('cname');
			if($field['cname']==''){
				$this->msg(array('state'=>0,'msgwords'=>'分类名称不能为空'));
			}	
			$field['csetting']=$this->post('csetting',array());
			foreach($field['csetting'] as $k=>$p){
				$field['csetting'][$k]=urlencode($p);
			}
			$field['csetting']=json_encode($field['csetting']);		
			$field['field_setting']=$this->post('field_setting',array());
			foreach($field['field_setting'] as $k=>$p){
				$field['field_setting'][$k]=urlencode($p);
			}
			$field['field_setting']=json_encode($field['field_setting']);
			
			
			//扩展属性
			$extern_content_arr=array();
			$extern_content=$this->post('extern_content',array());
			if(isset($extern_content['name'][0])){
				$i=0;foreach($extern_content['name'] as $k=>$p){
					if(isset($extern_content['label'][$i])&&$extern_content['label'][$i]&&isset($extern_content['name'][$i])&&$extern_content['name'][$i]){
						$extern_content_arr[$i]['label']=$extern_content['label'][$k];
						$extern_content_arr[$i]['name']=$extern_content['name'][$k];
						$extern_content_arr[$i]['type']=$extern_content['type'][$k];
						$extern_content_arr[$i]['value']=$extern_content['value'][$k];
						$i++;
					}
				}
			}//print_r($extern_content);
			$field['extern_content']=json_encode($extern_content_arr);
			//die($field['extern_content']);
			
			$field['cname_py']=$this->post('cname_py');
			$field['cname_en']=$this->post('cname_en');
			$field['single']=$this->post('single',0);
			$sql="select count(1) as total from info_category where cname_py='".$field['cname_py']."' and cate_id!=".$id." and cname_py!='' ";
			$k2=Yii::app()->db->createCommand($sql)->queryAll();
			if(count($k2)>0&&$k2[0]['total']>0){
				//$this->msg(array('state'=>0,'msgwords'=>'url目录已经存在'));
			}	
			$field['corder']=$this->post('corder',0);
			$field['cimg']=$this->post('cimg');
			$field['ctitle']=$this->post('ctitle');
			$field['ckey']=$this->post('ckey');
			$field['cdesc']=$this->post('cdesc');
			$field['cbody']=$this->post('cbody');
			$field['getcateids']=$this->post('getcateids');
			$field['cate_host']=$this->post('cate_host');
			$field['host_is_top']=$this->post('host_is_top',0);
			$field['cjump_url']=$this->post('cjump_url');
			$field['jump_first_cate']=$this->post('jump_first_cate',0);
			$field['ad_area_id']=$this->post('ad_area_id',0);
			$field['nav_show']=$this->post('nav_show',0);
			$field['highlight']=$this->post('highlight',0);
			$field['recommend']=$this->post('recommend',0);;
			
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				//查询本分类
				$sql="select * from info_category as c left join model m on m.model_id=c.model_id where cate_id=$id ";
				$bkk2=Yii::app()->db->createCommand($sql)->queryAll();
				if(count($bkk2)==0){
					$this->msg(array('state'=>0,'msgwords'=>'分类已删除或不存在'));
				}
				if($bkk2[0]['model_table_name']  && $bkk2[0]['model_id']!=$field['model_id']){
					$sql44=" select count(1) total from ".$bkk2[0]['model_table_name']." where last_cate_id=$id ";
					$bkk=Yii::app()->db->createCommand($sql44)->queryAll();
					if($bkk[0]['total']>0){
						$this->msg(array('state'=>0,'msgwords'=>'请先删除本分类下的信息'));
					}
				}
				$dbresult=InfoCategory::model()->updateAll($field,"cate_id=$id");  //修改记录
				$sonidarr=InfoCategory::model()->cate_son_idarr($id);
				$sonidstr=implode(',',$sonidarr);
				if(!$sonidstr) $sonidstr=0;
				if($this->post('for_child_templates_same')==1){
					InfoCategory::model()->updateAll(array('csetting'=>$field['csetting']),"parent_id=$id");
				}
				if($this->post('for_all_child_templates_same')==1){
					InfoCategory::model()->updateAll(array('csetting'=>$field['csetting']),"cate_id in($sonidstr)");
				}

				if($this->post('for_child_relation_cate_id')){
					InfoCategory::model()->updateAll(array('relation_cate_id'=>$field['relation_cate_id']),"parent_id=$id");
				}
				if($this->post('for_all_child_relation_cate_id')){
					InfoCategory::model()->updateAll(array('relation_cate_id'=>$field['relation_cate_id']),"cate_id in($sonidstr)");
				}
				
				
				if($this->post('for_child_ad_area_id')){
					InfoCategory::model()->updateAll(array('ad_area_id'=>$field['ad_area_id']),"parent_id=$id");
				}
				
				
				if($this->post('for_child_cate_host')){
					InfoCategory::model()->updateAll(array('cate_host'=>$field['cate_host']),"parent_id=$id");
				}
				if($this->post('for_all_child_cate_host')){
					InfoCategory::model()->updateAll(array('cate_host'=>$field['cate_host']),"cate_id in($sonidstr)");
				}
				
				
				if($this->post('for_child_field_setting_same')){
					InfoCategory::model()->updateAll(array('field_setting'=>$field['field_setting']),"parent_id=$id");
				}
				if($this->post('for_all_child_field_setting_same')){
					InfoCategory::model()->updateAll(array('field_setting'=>$field['field_setting']),"cate_id in($sonidstr)");
				}
				
				
				if($this->post('for_child_extern_content_same')){
					InfoCategory::model()->updateAll(array('extern_content'=>$field['extern_content']),"parent_id=$id");
				}
				if($this->post('for_all_child_extern_content_same')){
					InfoCategory::model()->updateAll(array('extern_content'=>$field['extern_content']),"cate_id in($sonidstr)");
				}
				
				if($this->post('for_all_child_single')){
					InfoCategory::model()->updateAll(array('single'=>$field['single']),"cate_id in($sonidstr)");
				}
				if($dbresult===false){
					$this->msg(array('state'=>0));
				}else{
					$this->logs('修改内容分类ID'.$id.'['.$field['cname'].']成功');
					$this->msg(array('state'=>1,'url'=>$this->createUrl('infoCategory/index')));
				}
							
			}else{
				$post=$this->data('InfoCategory',$field);
				$dbresult=$post->save();
				//die($post->primaryKey.'::a');
				if(!$dbresult){
					$this->logs('添加内容分类ID'.$dbresult.'['.$field['cname'].']成功');
					$this->msg(array('state'=>0));
				}else{
					$this->logs('添加内容分类ID'.$dbresult.'['.$field['cname'].']成功');
					$this->msg(array('state'=>1));	
				}
			}
			
			
			
		}
		
		//新增和修改共用部分
		$add=array(
			array('field_name'=>'set_flag','field_txt'=>'设置属性（批量按钮）'),
			array('field_name'=>'set_audit','field_txt'=>'设置是否审核（批量按钮）'),
			array('field_name'=>'set_recommend','field_txt'=>'加入推荐（批量按钮）'),
			array('field_name'=>'set_special','field_txt'=>'加入专题（批量按钮）'),
			array('field_name'=>'info_resource','field_txt'=>'资源和图片（选项卡）'),
			array('field_name'=>'info_advance','field_txt'=>'高级信息（选项卡）'),
			array('field_name'=>'info_relation','field_txt'=>'相关推荐（选项卡）'),
			array('field_name'=>'info_comment','field_txt'=>'评论（操作按钮）'),
			array('field_name'=>'info_preview','field_txt'=>'预览（操作按钮）'),
		);
		foreach($add as $r){
			$page['model_field'][]=$r;	
		}
		$this->render('update',array('page'=>$page));
		
	}
	
	//批量添加
	public function actionAddMore(){
		if(!$_POST){
			$page=array();
			$page['categorys']=InfoCategory::model()->category_tree(0);
			$this->render('addMore',array('page'=>$page));
		}else{
			$cnames=$this->post('cnames');
			$arr=explode(' ',$cnames);
			$py=new cn2pinyin();
			foreach($arr as $v){
				if(trim($v)=='') continue;
				$m=new InfoCategory();
				$m->parent_id=$this->post('parent_id');
				$m->model_id=intval($this->post('model_id'));
				$m->corder=50;
				$m->cname=$v;
				$m->cname_py=$py->get($v);
				$m->relation_cate_id=$m->parent_id;
				$m->save();
			}
			$this->logs('批量添加了内容分类'.$this->post('cnames'));
			$this->msg(array('state'=>1,'msgwords'=>'批量添加成功'));
		}
		
	}
	
	public function actionGetPinyin(){
		$py=new cn2pinyin();
		$str=isset($_GET['str'])?trim($_GET['str']):'';
		$my_py=$py->get($str);
		$my_py=strtolower($my_py);
		echo '{"str":"'.$str.'","str_py":"'.$my_py.'"}';
		exit();
	}
	public function ActionSaveCorder(){
		global $page;
		foreach($_POST['listorders'] as $id=>$corder){
			InfoCategory::model()->updateAll(array('corder'=>intval($corder)),"cate_id=".intval($id)."");  //修改记录
		}
		$this->logs('修改了内容分类的排序');
		$this->msg(array('state'=>1));
	}
	public function actionResetNamePy(){
		global $page;
		$py=new cn2pinyin();
		$parent_id=isset($_GET['parent_id'])?intval($_GET['parent_id']):0;
		$where='';
		if($parent_id!=0) $where=" and parent_id=".$parent_id;
		$sql="select cate_id,cname from info_category where 1  $where";
		$a=Yii::app()->db->createCommand($sql)->queryAll();	
		foreach($a as $r){
			$cname_py=$py->get($r['cname']);
			InfoCategory::model()->updateAll(array('cname_py'=>$cname_py)," cate_id=".$r['cate_id']);  //修改记录
		}
		$this->msg(array('state'=>1));
	}
	public function actionDelete(){
		global $page;
		$id=$_GET['id']=isset($_GET['id']) && $_GET['id']!='' ? intval($_GET['id']):0;
		$sql="select count(*) total from info_category where  parent_id=".$id." ";
		$r2=Yii::app()->db->createCommand($sql)->queryAll();
		if($r2[0]['total']){
			$this->msg(array('state'=>0,'msgwords'=>'请先删除子分类'.$r2[0]['total']));
		}
		$sql="select * from info_category as a left join model b  on b.model_id=a.model_id where cate_id=$id";
		$rs001=Yii::app()->db->createCommand($sql)->queryAll();
		if($rs001[0]['model_table_name']==''){
			$this->msg(array('state'=>0,'msgwords'=>'模型出错！'));
		}
		$sql="select count(1) as total from ".$rs001[0]['model_table_name']." as a  where last_cate_id=".$id."";
		$d002=Yii::app()->db->createCommand($sql)->queryAll();
		if($d002[0]['total']>0){
			$this->msg(array('state'=>0,'msgwords'=>'请先删除分类下的文档！'));
		}
		$sql="delete from info_category where cate_id=".$id." ";
		$rsarrs=Yii::app()->db->createCommand($sql)->execute();
		if($rsarrs===false){
			$this->msg(array('state'=>0));
		}else{
			$this->logs('删除了ID：'.$id.'的内容分类');
			$this->msg(array('state'=>1));
		}
	
	}
	public function actionGetCateTotalInfo(){
		$_GET['cate_id']=isset($_GET['cate_id'])?intval($_GET['cate_id']):0;
		$categorys=InfoCategory::model()->get_category();
		$childidarr=InfoCategory::model()->cate_son_idarr($_GET['cate_id']);
		$childidarr[]=$_GET['cate_id'];
		if(count($childidarr)){
			$inid=implode(',',$childidarr);
		}
	
		$table=$categorys[$_GET['cate_id']]['model_table_name'];
		$sql="select count(1) total from $table where last_cate_id in($inid)  ";
		$d=$this->query($sql);
		$total=isset($d[0]['total'])?$d[0]['total']:0;
		/*重新统计数量*/
		$sql="update info_category set totals=$total where cate_id=".$_GET['cate_id'];
		Yii::app()->db->createCommand($sql)->execute();
		
		exit('{"cate_id":'.$_GET['cate_id'].',"totals":'.$total.',"inid":"'.$inid.'"}');
	}
	
	function actionShowCategoryLeftmenu(){
		$sql="select b.*,a.* from info_category as a left join model as b on b.model_id=a.model_id  order by a.corder,a.cate_id";
		$rsarrs=Yii::app()->db->createCommand($sql)->queryAll();
		$catearr=$rsarrs;
		$categorys=array();
		$page['idarr']=array();
	
		// 判断分类的权限
		if(Yii::app()->admin_user->cate_id){
			$idarr=$this->cate_son_idarr($catearr,Yii::app()->admin_user->cate_id);
			$idarr[]=Yii::app()->admin_user->cate_id;
		}
		foreach($catearr as $r){
			if(isset($idarr)&&!in_array($r['cate_id'],$idarr)) continue;
				
			$page['idarr'][]=$r['cate_id'];
			//$d=$dbm->query("select count(1) as total from ".$r['model_table_name']." where last_cate_id=".$r['cate_id']." ");
			//$new_r['infototals']=isset($d['list'][0]['total'])?$d['list'][0]['total']:0;
			$new_r['id']=$r['cate_id'];
			$new_r['totals']=$r['totals'];
			$new_r['parentid']=$r['parent_id'];
			$new_r['name']=$r['cname'];
			$categorys[]=$new_r;
		}
	
		$str="
		<span class='file'><a href='".$this->createUrl('Info/index')."?cate_id=\$id&select_mode=".($this->get('select_mode'))."' target='info_content_main'>\$name(<span id=fei_\$id class=ff>\$totals</span>)</a></span>
		";
		$strf="
		<span class='folder'>\$name(<span id=fei_\$id class=ff>\$totals</span>)</span>
		";
		$tree=new tree();
		$tree->init($categorys);
		$category_code = $tree->get_treeview(0,'',$str,$strf);
		$page['categorys']=$category_code;
		$this->render('infoCategoryLeftmenu',array('page'=>$page));
	}
	
	
}