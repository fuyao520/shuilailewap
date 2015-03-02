<?php 
error_reporting(0); //报告所有错误，0为忽略所有错误
$p_cates=Linkage::model()->get_linkage_data(15);
$p_top_cate=Linkage::model()->get_linkage_data(15,1);
$p_cates_wson=Linkage::model()->get_linkage_child_catearr($p_cates,0);  


//$attr 是页面的位置  
function g_s_url($name='',$value='',$init=0,$attr=''){
	$re='';
	$selectcode='';
	$getarr=array('product_cate_id','price','search_txt','order');
	foreach($getarr as $r){
		if(!isset($_GET[$r])) $_GET[$r]='';
		//if($_GET[$r]=='') $_GET[$r]=0;
		$page['g'][$r]=preg_replace('~(")|(\')~','',strip_tags($_GET[$r]));
		if($name==$r){
			$page['g'][$r]=str_replace(array('"',"'"),'',strip_tags($value));
		}
	}	//echo '1'.$value.'1:::'.'1'.$_GET[$name].'1<br>';
	if(isset($_GET[$name])&& '1'.$value.'1'=='1'.$_GET[$name].'1'){
		$selectcode='" class="current';
	}
	if($init==1){
		foreach($getarr as $r){
			if($r==$name)continue;
			$page['g'][$r]='';
		}
		$page['g']['cname_py']=$c->categorys[5]['cname_py'];
		$selectcode='';
	}
	$link='';
	$re="/goods-".$page['g']['product_cate_id']."-".$page['g']['price']."-".$page['g']['search_txt']."-".$page['g']['order']."-1.html".$attr;
	echo $re.$selectcode;

}

//$attr 是页面的位置
function p_s_url($name='',$value='',$init=0,$attr=''){
	$re='';
	$selectcode='';
	$getarr=array('tag','uid','order');
	foreach($getarr as $r){
		if(!isset($_GET[$r])) $_GET[$r]='';
		//if($_GET[$r]=='') $_GET[$r]=0;
		$page['g'][$r]=preg_replace('~(")|(\')~','',strip_tags($_GET[$r]));
		if($name==$r){
			$page['g'][$r]=str_replace(array('"',"'"),'',strip_tags($value));
		}
	}	//echo '1'.$value.'1:::'.'1'.$_GET[$name].'1<br>';
	if(isset($_GET[$name])&& '1'.$value.'1'=='1'.$_GET[$name].'1'){
		$selectcode='" class="current';
	}
	if($init==1){
		foreach($getarr as $r){
			if($r==$name)continue;
			$page['g'][$r]='';
		}
		$page['g']['cname_py']=$c->categorys[5]['cname_py'];
	}
	$link='';
	$re="/photo-".$page['g']['tag']."-".$page['g']['uid']."-1.html".$attr;
	echo $re.$selectcode;

}

 ?>