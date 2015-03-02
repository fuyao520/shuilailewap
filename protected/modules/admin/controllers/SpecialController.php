<?php
class SpecialController extends AdminController{

	public function actionIndex(){
		$catearr=Special::model()->specials;
		$categorys=array();
		foreach($catearr as $r){
			$new_r=$r;
			$new_r['id']=$r['special_id'];
			$new_r['parentid']=$r['special_parent_id'];
			$new_r['special_name']=$r['special_name'];
			$new_r['sorder']=$r['sorder'];
			$new_r['cname']=$r['cname'];
			$new_r['auditcode']=($r['audit']==0?"<span class=red>未审核</span>":"<span class=green>已审核</span>");
			$new_r['info_totals']=$r['info_totals'];
			$new_r['create_date']=date('Y-m-d',$r['create_date']);
			$new_r['special_img']=$r['special_img']?'<img src="'.$r['special_img'].'" height=30>':'';
			$new_r['special_banner']=$r['special_banner']?'<img src="'.$r['special_banner'].'" height=30>':'';
		    $new_r['str_manage'] =' <a href="/index.php/admin/specialInfoRelation/index/?special_id='.$r['special_id'].'">关联文档</a>  
		    		<a href="/index.php/admin/special/update/?id='.$r['special_id'].'">修改</a>  
		    				<a href="/index.php/admin/special/delete/?ids='.$r['special_id'].'" onclick="return confirm(\'确定删除吗\')">删除</a>';
			$categorys[]=$new_r;
		}
		$str  = "<tr>
	                    <td><input type='checkbox' class='cklist' value='\$id' /></td>
						<td><input name='listorders[\$id]' type='text' size='3' value='\$sorder' class='input-text-c'></td>
						<td>\$id</td>
						<td class='alignleft'>\$spacer\$special_name(\$info_totals)</td>
						<td>\$cname</td>
				<td>\$special_img</td>	
				<td>\$special_banner</td>		
				<td>\$create_date</td>
						<td>\$auditcode</td>
						<td>\$str_manage</td>
					</tr>";
		$tree=new tree();	
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';		
		$tree->init($categorys);
		$category_code = $tree->get_tree(0, $str);
		$page['categorys']=$category_code;
		$page['total']=Special::model()->count();
		$this->render('index',array('page'=>$page));
		
	}
	public function actionUpdate(){
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Special_edit');
				$info=$this->toArr(Special::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'专题不存在'));
				}
				$page['info']=$info;
				$special_parent_id=$page['info']['special_parent_id'];
				$cate_id=$page['info']['cate_id_top'];
			}else{
				$this->auth_action('Special_add');
				$special_parent_id=0;
				$cate_id=0;
			}
			$page['specials']=Special::model()->special_cate_tree($special_parent_id);
			$page['categorys']=InfoCategory::model()->category_tree($cate_id);
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['special_name']=$this->post('special_name');
			if($field['special_name']==''){
				$this->msg(array('state'=>0,'msgwords'=>'专题名称不能为空'));
			}
			$field['cate_id_top']=$this->post('cate_id_top',0);
			$field['special_img']=$this->post('special_img');
			
			$field['special_banner']=$this->post('special_banner');
			$field['template']=$this->post('template');
			//$field['typesetting']=$this->post('typesetting');
			//扩展属性
			$typesetting_arr=array();
			$typesetting=$this->post('typesetting',array());//print_r($page['post']['typesetting']);
			if(isset($typesetting['txt'][0])){
				$i=0;foreach($typesetting['txt'] as $k=>$p){
					if(isset($typesetting['txt'][$i])&&$typesetting['txt'][$i]&&isset($typesetting['value'][$i])&&$typesetting['value'][$i]!=''){
						$typesetting_arr[$i]['txt']=$typesetting['txt'][$k];
						$typesetting_arr[$i]['value']=$typesetting['value'][$k];	
					    $i++;
					}
				}
			}//print_r($typesetting);
			$field['typesetting']=helper::json_encode_cn($typesetting_arr);
			//die($field['typesetting']);
			
			$field['special_desc']=$this->post('special_desc');
			$field['sorder']=$this->post('sorder',0);
			$field['special_parent_id']=$this->post('special_parent_id',0);
			
			$field['audit']=$this->post('audit',0);
			$field['create_date']=time();
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Special_edit');
				$dbresult=Special::model()->updateAll($field,"special_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('special/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了专题 ID:'.$id.''.$field['special_name'].' ';
			}else{
				$this->auth_action('Special_add');
				$post=$this->data('Special',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了专题ID：$dbresult".$field['special_name'];
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

	public function ActionSaveOrder(){
		$this->auth_action('Special_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Special::model()->findByPk($id);
			if(!$m) continue;
			$m->sorder=$order;
			$m->save;
		}
		$this->logs('修改了专题的排序');
		$this->msg(array('state'=>1));
	}
	
	
	
	
	public function actionDelete(){
		$ids=$this->get('ids');
		$ids=explode(',',$ids);
		foreach($ids as $id){
			$id=intval($id);
			$sql=" delete info_special,info_special_relation from info_special";
			$sql .=" left join info_special_relation on info_special_relation.special_id=info_special.special_id ";
			$sql .=" where info_special.special_id=".$id." ";  
			//echo $sql;
			$rsarrs=Yii::app()->db->createCommand($sql)->execute();
		}
		//die();
		$this->logs('删除了专题id:'.implode(',',$ids));
		$this->msg(array('state'=>1));	
	}
	public function actionGetSpecialList(){
		/*
		$sql="select * from info_special order by sorder,special_id desc";
		$a=Yii::app()->db->createCommand($sql)->queryAll();
		$re['list']=$a;
		*/
		$re['data']=Special::model()->special_cate_tree(0);
		die(json_encode($re));
	}
	

}
?>