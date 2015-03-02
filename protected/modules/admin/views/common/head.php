<?php $page['doctype']=isset($page['doctype'])?$page['doctype']:0; ?>
<?php $page['dialog_skin']=isset($page['dialog_skin'])?$page['dialog_skin']:'default'; ?>
<?php if($page['doctype']==0){ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php }else if($page['doctype']==1){?>
<html>
<?php }?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Yii::app()->params['basic']['sitename']; ?></title>
<link rel="stylesheet" media="screen" href="<?php echo Yii::app()->params['basic']['cssurl']; ?>admin/<?php echo $this->admin_style;?>/admin.css" />
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js" ></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.external.js" ></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/common.js" ></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/colorpicker.js" ></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>admin/js/common.js" ></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/My97DatePicker/WdatePicker.js" ></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>admin/js/linkage.js" ></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/xheditor/xheditor-1.1.14-zh-cn.min.js"></script>
<script  src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/xheditor/xheditor_plugins/coder.js"></script>
<script  src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/artDialog4.1.7/artDialog.js?skin=<?php echo $page['dialog_skin'];?>" ></script>
<script  src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/artDialog4.1.7/plugins/iframeTools.source.js" ></script>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/jquery_tree/jquery.treeview.css" />
<script  src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/jquery_tree/jquery.treeview.js" ></script>

</head>
<body  <?php echo isset($page['body_extern'])?$page['body_extern']:''; ?>>