<?php
$brand_cates=Linkage::model()->get_linkage_data(17);


function g_s_url($name='',$value='',$init=0){
	$re='';
	$selectcode='';
	$getarr=array('cname_py','brand','area','guige','search_txt','order');
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
			$page['g'][$r]=0;
		}
		//$page['g']['cname_py']=$c->categorys[5]['cname_py'];
	}
	$re="/goods-water-".$page['g']['area']."-".$page['g']['brand']."-".$page['g']['guige']."-".$page['g']['order']."-0-1.html";
	echo $re.$selectcode;

}

function c_s_url($name='',$value='',$init=0){
	$re='';
	$selectcode='';
	$getarr=array('cname_py','brand','area','location_x','location_y','search_txt','order');
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
			$page['g'][$r]=0;
		}
		//$page['g']['cname_py']=$c->categorys[5]['cname_py'];
	}
	$re="/companys-".$page['g']['area']."-".$page['g']['brand']."---".$page['g']['order']."-0-1.html";
	echo $re.$selectcode;

}


 ?>