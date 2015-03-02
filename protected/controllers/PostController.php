<?php
class PostController extends HomeController{
	public function  actionGetCateChildClass(){ //子栏目
		$jsoncallback=$this->get('jsoncallback');
		$parent_id=intval($this->get('parent_id'));
		$select_name=$this->get('select_name');
		$span_id=$this->get('span_id');
		$is_child=intval($this->get('is_child'));
		$selectnum=intval($this->get('selectnum'));
		$attr_extern=intval($this->get('attr_extern'));
		$linkage_type_id=intval($this->get('linkage_type_id'));
		$b=Linkage::model()->get_linkage($parent_id,$linkage_type_id);
		$a=array('data'=>'');
		$extern_code='';
		foreach($b as $rs){
			if($attr_extern=='py'){
				$extern_code=' '.$attr_extern.'="'.$rs['linkage_name_py'].'" ';
			}
			$a['data'] .="<option value='".$rs['linkage_id']."' $extern_code>".$rs['linkage_name']."</option>";
			
		}
		if($a['data']=='' && $is_child==0 ){
			$a['data']="<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."')\"><option value='".$parent_id."'>--选择--</option></select>";
			die($jsoncallback.'('.json_encode($a).')');
		}
		if($a['data']=='' && $is_child==1 ){
			$a['data']='';
			die($jsoncallback.'('.json_encode($a).')');
		}
		$a['data']="<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."')\"><option value='".$parent_id."'>--选择--</option>".$a['data']."</select>";
		die($jsoncallback.'('.json_encode($a).')');
	}
	public function  actionGetSelectClassForEdit(){
		$jsoncallback=$this->get('jsoncallback');
		$type=intval($this->get('linkage_id',0));
		$parent_id=intval($this->get('parent_id',0));
		$select_name=$this->get('select_name');
		$span_id=$this->get('span_id');
		$linkage_type_id=intval($this->get('linkage_type_id',0));
		$selectnum=$this->get('selectnum',0);
		$attr_extern=$this->get('attr_extern',0);
		$v_html='';
		$s_html='';
		if ($type==0){
			$a['list']=Linkage::model()->get_linkage($parent_id,$linkage_type_id);
			foreach ($a['list'] as $r){
				$extern_code='';
				if($attr_extern=='py'){
					$extern_code=' '.$attr_extern.'="'.$r['linkage_name_py'].'" ';
				}
				$s_html .='<option value="'.$r['linkage_id'].'" '.$extern_code.'>'.$r['linkage_name'].'</option>';
			}
			$v_html ="<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."','".$attr_extern."')\"><option value='".$type."'>--选择--</option>".$s_html."</select>";
		}else{
			while ($type<>$parent_id){
				$s_html='';
				$m=Linkage::model()->findByAttributes(array('linkage_id'=>$type,'linkage_type_id'=>$linkage_type_id));
				$type=$m->parent_id;
				$a['list']=Linkage::model()->get_linkage($type,$linkage_type_id);
				foreach ($a['list'] as $r){
					$extern_code='';
					if($attr_extern=='py'){
						$extern_code=' '.$attr_extern.'="'.$r['linkage_name_py'].'" ';
					}
					$s_html .='<option value="'.$r['linkage_id'].'" '.($r['linkage_id']==$m->linkage_id?'selected':'').' '.$extern_code.'>'.$r['linkage_name'].'</option>';
				}
				$v_html ="<select name='".$select_name."'  onchange=\"cg_sele_cc(this.value,this,'".$select_name."','".$span_id."','".$linkage_type_id."','".$selectnum."','".$attr_extern."')\"><option value='".$type."'>--选择--</option>".$s_html."</select>".$v_html;
					
			}
		}
		$re['data']=$v_html;
		die($jsoncallback.'('.json_encode($re).')');
	}
	
	
	
	public function actionPurchase(){
		$m=new Dtable('message');
		$m->is_check=0;
		$m->username=$this->post('lnkman');
		$m->corder=50;
		$m->content=helper::escape_html($this->post('content'));
		$m->mobile=$this->post('lnktel');
		$m->company_name=$this->post('company');
		$m->create_time=time();
		$m->ipaddr=helper::getip();
		if($m->username==''){
			$this->msg(array('state'=>-1,'msgwords'=>'请填写称呼','type'=>'json'));
		}
		if($m->mobile==''){
			$this->msg(array('state'=>-1,'msgwords'=>'请留下联系电话，方便我们与你联系','type'=>'json'));
		}
		if($m->company_name==''){
			$this->msg(array('state'=>-1,'msgwords'=>'请填写公司名称','type'=>'json'));
		}
		$m->save();
		$this->msg(array('state'=>1,'msgwords'=>'留言成功，感谢您的支持！','type'=>'json'));
	
	}
	
	public function actionTbkJump(){
		$page=array();
		$this->renderPartial('/tbk_jump',array('page'=>$page));
		
	}
	public function actionTest01(){
		echo helper::get_curl_contents('http://www.baidu.com');
	}
}