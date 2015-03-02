<?php
class InfoModelFrameController extends AdminController {
    public function actionIndex(){			
		$this->render('index');
	}
	public function actionLeftMenu(){
		$sql="select * from  model where model_type=0 and parent_model_id=0 ";
		$a['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$page['models']=$a['list'];
		$this->render('leftMenu',array('page'=>$page));
	}
	function actionGetCateTotalInfo(){
		$cate_id=$this->get('cate_id');
		$categorys=Cms::model()->categorys;
		$childidarr=InfoCategory::model()->cate_son_idarr($cate_id);
		$childidarr[]=$cate_id;
		if(count($childidarr)){
			$inid=implode(',',$childidarr);
		}
		$table=$categorys[$cate_id]['model_table_name'];
		$sql="select count(1) as total from $table where last_cate_id in($inid) ";
		$d['list']=Yii::app()->db->createCommand($sql)->queryAll();
		$total=isset($d['list'][0]['total'])?$d['list'][0]['total']:0;
		exit('{"cate_id":'.$cate_id.',"totals":'.$total.',"inid":"'.$inid.'"}');
	}
}

?>