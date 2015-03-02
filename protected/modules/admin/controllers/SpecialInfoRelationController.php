<?php
class SpecialInfoRelationController extends AdminController{
	public $page=array();
	public function init(){
		//本页面的所有操作必须传入 get 的   cate_id，否则无法进行操作
		$page['cate_info']=array();
		if(!isset($_GET['special_id']) || $_GET['special_id']==''){
		   	$this->msg(array('state'=>-2,'msgwords'=>'请选择专题'));
		}else{
			$rsarrs=$this->query("select * from info_special where special_id=".$_GET['special_id']." ");
			if(count($rsarrs)==0){
			    $this->msg(array('state'=>-2,'msgwords'=>'专题不存在'));	
			}
			$page['special']=$rsarrs[0];
			$a=helper::json_decode_cn($page['special']['typesetting'],1);
			$page['special']['types']=$a;
			
		}
		$this->page=$page;
	}
	public function actionIndex(){
		$page=$this->page;
		$page['specials']=array();
		$pagesize=20;
		$andwhere='';
		if($this->get('special_type')!=''){
			$andwhere=" and a.special_type=".intval($this->get('special_type'));
		}
		$sql="select * from info_special_relation as a   where a.special_id=".$_GET['special_id']." $andwhere ";
		$csql="select count(*) as total from info_special_relation as a   where a.special_id=".$_GET['special_id']." $andwhere ";
	    $suffix=" order by a.i_s_order  asc,relation_id desc  limit ".($_GET['p']-1)*$pagesize.",".$pagesize;
	    $sql.=$suffix;
	    $rsarrs=$this->query($sql);
	    $crsarrs=$this->query($csql);
		//取出 info_title
		$list=array();
		$a=$this->query("select * from model"); 
		$m=array();
		foreach($a as $r){
		    $m[$r['model_id']]=$r;	
		}
		
		foreach($rsarrs as $r){
	        $c=$this->query("select info_id,info_title,last_cate_id,info_img from ".$m[$r['model_id']]['model_table_name']." where info_id=".$r['info_id']." limit 0,1");
			if(count($c)){
			    $r['info_title']=$c[0]['info_title'];	
			    $r['last_cate_id']=$c[0]['last_cate_id'];
			    $r['info_id']=$c[0]['info_id'];
			    $r['info_img']=$c[0]['info_img'];
			    $r['thumb']=Attachment::simg($c[0]['info_img']);
			}else{
				$r['info_title']='';
				$r['last_cate_id']='';
				$r['info_id']='';
				$r['info_img']='';
				$r['thumb']='';
			}
			$r['model_name']=$m[$r['model_id']]['model_name'];
			$r['table']=$m[$r['model_id']]['model_table_name'];
			$list[]=$r;
			
		}
		
		$page['i_s_rs']['list']=$list;//print_r($rsarrs);
	    $pagearr=helper::pagehtml(array('total'=>$crsarrs[0]['total'],"pagesize"=>$pagesize));
		$page['i_s_rs']['pagecode']=$pagearr['pagecode'];
		$this->render('index',array('page'=>$page));
	}
	
	function actionSaveAddSpecialInfoRelation(){
		$page=$this->page;
		$field=array();
		$field['special_id']=$this->get('special_id',0);
		$field['special_type']=$this->post('special_type',0);
		$infoid=$this->post('infoid',array());
		foreach($infoid as $k=>$r){
			$m=new Dtable('info_special_relation');
			$m->info_id=intval($r);
			$m->info_title=$_POST['infotitle'][$k];
			$m->model_id=intval($_POST['info_model_id'][$k]);
			$m->i_s_order=50;
			$m->save();
		}
		$this->msg(array('state'=>1,'url'=>$this->createUrl('SpecialInfoRelation/index').'?special_id='.$this->get('special_id')));
	 	
	}
	
	function actionSaveOrder(){
		$page=$this->page;
		if(isset($_POST['listorders'] )){		
			foreach($_POST['listorders'] as $id=>$corder){
				$m=Dtable::model('info_special_relation')->findByPk($id);
				if(!$m) continue;
				$m->i_s_order=intval($corder);
				$m->save();

				
			}
		}		
		$this->msg(array('state'=>1));
	}
	
	public function actionDelete(){
		$idstr=$this->get('ids');
		$ids=explode(',',$idstr);
		foreach($ids as $id){	
			$m=Dtable::model('info_special_relation')->findByPk($id);
			if(!$m) continue;
			$m->delete();
			
		}
		$this->logs('撤销了专题文档ID（'.$idstr.'）');
		$this->msg(array('state'=>1));	
	}
	
	public function actionUpdateType(){
		$idstr=$this->get('ids');
		$special_type=intval($this->get('special_type'));
		$ids=explode(',',$idstr);
		foreach($ids as $id){
			$m=Dtable::model('info_special_relation')->findByPk($id);
			if(!$m) continue;
			$m->special_type=$special_type;
			$m->save();
				
		}
		$this->logs('转移到了专题小分类'.$special_type.',ID（'.$idstr.'）');
		$this->msg(array('state'=>1));
	}
}
?>