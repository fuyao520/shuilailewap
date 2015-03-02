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
<style>
html{ overflow:hidden;}
body{ overflow:hidden;}
</style>
<table  cellpadding="0" width="100%" height="100%" border="0" align="center">
    <tr><td width="180" valign="top" class="menu">
    <iframe name="cateleft_main" id="cateleft_main"  width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;" src="<?php echo $this->createUrl('infoCategory/ShowCategoryLeftmenu');?>?select_mode=<?php echo $this->get('select_mode'); ?>"></iframe>
    
    </td>
    <td valign="top"><iframe name="info_content_main"  width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;" src="<?php echo $this->createUrl('info/index');?>?cate_id=<?php echo (isset($_GET['cate_id'])?$_GET['cate_id']:''); ?>"></iframe></td></tr>
</table>
