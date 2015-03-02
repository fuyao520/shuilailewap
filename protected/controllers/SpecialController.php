<?php
class SpecialController extends  HomeController{
	public function actionIndex(){
		$pagesize=40;
		$special_id=intval($this->get('id'));
		$special_py=isset($_SERVER['HTTP_HOST'])?($_SERVER['HTTP_HOST']):'';
		if($special_id>0){
			//查询当前专题
			$sql="select * from info_special where special_id=".$special_id;
		
		}
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($a['list'])==0){
			$this->msg(array('state'=>-2,'msgwords'=>'专题不存在..'));
		}
		$special_id=$a['list'][0]['special_id'];
		$page['special']=$a['list'][0];
		$page['special']['url']=$this->createUrl('special/index').'?id='.$a['list'][0]['special_id'];
		if($page['special']['audit']==0){
			$this->msg(array('state'=>-2,'msgwords'=>'专题审核中..'));
		}
		//print_r($page['special']);
		$page['special_scates_r']=helper::json_decode_cn($page['special']['typesetting'],1);
		$page['special_scates']=array();
		
		foreach($page['special_scates_r'] as $r){
			$r['list']=array();
			$page['special_scates'][$r['value']]=$r;
		}
		//print_r($page['special_scates']);	
		$page['listdata']=Special::special_info_list(array('special_id'=>$special_id,'pagesize'=>$pagesize,'p'=>$_GET['p']));
		$this->render('/special_info_list',array('page'=>$page));
	}
	
	public function actionList(){
			
		
	}
	
	function actionDetail(){
		global $dbm,$page,$config,$c,$special_id;
	
		//赋给 $page['special']
		$table='article';
		$sql="select * from info_special_relation where special_id=".$special_id;
		$a=$dbm->query($sql);
		foreach($a['list'] as $r){
			if(isset($page['special_scates'][$r['special_type']])){
				$sql="select model_table_name from model where model_id=".$r['model_id']." ";
				$a2=$dbm->query($sql);
				if(isset($a2['list'][0]['model_table_name'])&&$a2['list'][0]['model_table_name']){
					$page['special_scates'][$r['special_type']]['list'][]=$c->info_content($a2['list'][0]['model_table_name'],$r['info_id'],1);
				}
			}
	
		}
		if($page['special']['template']==''){
			$page['special']['template']='special.php';
		}
		//print_r($page['special_scates']);
		echo helper::cache_tpl($config['basic']['tpl'],$page['special']['template'],'special_detail');
	
	}

	
	
}