<?php
class TagController extends AdminController{

	public function actionIndex(){
		$this->auth_action('Tag_Index');
		//搜索
		$params['where']='';
		if($this->get('search_type')=='keys' && $this->get('search_txt')){
			$params['where'] .=" and(a.tag_txt like '%".$this->get('search_txt')."%') ";
		}else if($this->get('search_type')=='id'  && $this->get('search_txt')){ //网点ID
			$params['where'] .=" and(a.tag_id=".intval($this->get('search_txt')).") ";
		}
		
		$tag_cate_id=$this->get('tag_cate_id',0);
		if($tag_cate_id){
			$params['where'] .="  and a.tag_cate_id=".$tag_cate_id;
		}
		$params['join']="left join tag_cate as b on b.tag_cate_id=a.tag_cate_id";
		$params['order']="  order by a.tag_id      ";
		$params['pagesize']=Yii::app()->params['management']['pagesize'];
		$params['pagebar']=1;
		$params['smart_order']=1;
		$page['listdata']=Dtable::model('tag')->listdata($params);
		$this->render('index',array('page'=>$page));
		
	}	
	
	public function actionUpdate(){ 
		$page=array();
		$id=$this->get('id',0);
		//显示表单
		if(!isset($_POST['id'])){
			//如果有get.id为修改，否则判断为新增;
			if($id){
				$this->auth_action('Tag_edit');			
				$info=$this->toArr(Tag::model()->findByPk($id));
				if(!$info){
					$this->msg(array('state'=>0,'msgwords'=>'文档不存在'));
				}
				$page['info']=$info;
				//print_r($page['recommend']);
			}else{
				$this->auth_action('Tag_add');
			}
	
		}else{//判断为保存
			$id=$_POST['id']=intval($_POST['id']);
			//处理需要的字段
			$field=array();
			$field['tag_txt']=$this->post('tag_txt');
			if($field['tag_txt']==''){
				$this->msg(array('state'=>0,'msgwords'=>'标签名称不能为空'));
			}
			$field['tag_cate_id']=$this->post('tag_cate_id');
			$field['tag_order']=$this->post('tag_order',0);
			//如果有post.id 为保存修改，否则为保存新增
			if($id){
				$this->auth_action('Tag_edit');
				$dbresult=Tag::model()->updateAll($field,"tag_id=$id");  //修改记录
				$msgarr=array('state'=>1,'url'=>$this->createUrl('tag/index').'?p='.$_GET['p'].''); //保存的话，跳转到之前的列表
				$logs='修改了标签 ID:'.$id.''.$field['tag_txt'].' ';
			}else{	
				$this->auth_action('Tag_add');
				$post=$this->data('Tag',$field);
				$dbresult=$post->save();
				$id=$post->primaryKey;
				$msgarr=array('state'=>1);  //新增的话跳转会添加的页面
				$logs="添加了标签ID：$dbresult".$field['tag_txt'];
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
		$this->auth_action('Tag_del');
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Tag::model()->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('删除了标签ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	public function ActionSaveOrder(){
		$this->auth_action('Tag_edit');
		$listorders=$this->get('listorders',array());
		foreach($listorders as $id=>$order){
			$m=Tag::model()->findByPk($id);
			if(!$m) continue;
			$m->tag_order=$order;
			$m->save();		
		}
		$this->logs('修改了标签的排序');
		$this->msg(array('state'=>1));
	}

}
?>