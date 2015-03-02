<!doctype html>
<html>
<head>
    <title><?php echo Cms::model()->seo_title($page); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="zh-CN"/>
    <meta name="keywords" content="<?php echo Cms::model()->seo_keyword($page); ?>" />
<meta name="description" content="<?php echo Cms::model()->seo_description($page); ?>">
<meta name="robots" content="index,follow" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/style/base.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/style/mall.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/style/default.css?2" />
    <script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/js/linkage.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/common.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.external.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/js/common.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/js/mall.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>user/js/user.js"></script>
    <script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/artDialog4.1.7/artDialog.js?skin=idialog"></script>
    <script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.rotate.min.js"></script>
</head>