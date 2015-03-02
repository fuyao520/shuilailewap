<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>

<div class="regmain">
	<div class="main">
	     <div style="font-size:18px;color:green;padding:40px;" class="clearfix">
	     <span class="b-icon bok fl"></span>	
	     <p style="margin:20px 0 0 20px;" class="fl">
	      恭喜你，注册成功，正在跳转到会员中心..
	      </p>
	      </div>
	</div>
</div>
<script>
setTimeout("window.location='<?php echo $this->createUrl('site/login');?>'",1500)
</script>



<?php include(dirname(__FILE__)."/foot.php")?>

</body>
</html>