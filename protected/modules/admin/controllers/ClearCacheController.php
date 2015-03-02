<?php
class ClearCacheController extends AdminController{

	public function actionIndex(){
		Yii::app()->cache->flush();
		$this->msg(array('state'=>-1,'msgwords'=>'清理成功'));		
	}	
	
	

}
?>