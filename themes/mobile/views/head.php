<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="/static/mobile/images/favicon.ico?4">
<title><?php 
$sname='手机站_'.Yii::app()->params['basic']['sitename'];
if(isset($page['info']['title'])){ 
	echo $page['info']['title'].'_'.$sname;
}else if(isset($page['cate']['cname'])){
	echo ($this->get('p')>1?'第'.$this->get('p').'页_':'').$page['cate']['cname'].'_'.$sname;
}else{
	echo Yii::app()->params['basic']['seo_title'];
}
?>
</title>
<meta name="keywords" content="<?php 
if(isset($page['info']['title'])){
	echo $page['info']['info_tags'];
}else if(isset($page['cate']['cname'])){
	if($this->get('p')>1){
		echo '第'.$this->get('p').'页_'.$page['cate']['cname'].'_'.$sname;
	}else{
		echo $page['cate']['cname'].'_'.$sname;
	}
}else{
	echo Yii::app()->params['basic']['seo_keyword'].'_手机站';
}
?>" />
<meta name="description" content="<?php
if(isset($page['info']['title'])){
	echo trim($page['info']['info_desc']);
}else if(isset($page['cate']['cname'])){
	$page['cate']['cdesc'];
}else{
	echo Yii::app()->params['basic']['seo_description'];
}
	
?>" />
<meta name="keywords" content="<?php echo Yii::app()->params['basic']['seo_keyword']; ?>" />
<meta name="description" content="<?php echo isset($page['info']['info_desc'])?$page['info']['info_desc']:Yii::app()->params['basic']['seo_description'];?>">
<link href="/static/mobile/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="width element"><span onclick="window.location='/'">手机版-<?php echo Yii::app()->params['basic']['sitename'];?></span></div>