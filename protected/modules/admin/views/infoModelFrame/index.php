<?php $page['doctype']=1; ?>
<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
$(document).ready(function(){
	$("#content_left_menu").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black"
	});

});
</script>
</head>
<style>
html{ overflow:hidden;}
</style>
<body style="overflow:hidden;">
<table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0" align="center">
    <tr><td width="180" valign="top" class="menu">
    <iframe name="cateleft_main" frameborder="0" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;" src="<?php echo $this->createUrl('infoModelFrame/leftMenu'); ?>?is_select_mode=<?php echo $this->get('is_select_mode'); ?>"></iframe>
    
    </td>
    <td valign="top"><iframe name="info_content_main" frameborder="0" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;" src="<?php echo $this->createUrl('infoModelList/index'); ?>?model_id=<?php echo $this->get('model_id'); ?>"></iframe></td></tr>
</table>
</body>
</html>
