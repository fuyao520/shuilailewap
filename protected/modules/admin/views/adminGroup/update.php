<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php
 
if(!isset($page['info'])){
	$page['info']['groupid']='';
	$page['info']['groupname']='';
}
?>
<script>
function checkgroup2(eobj,c){
	if(!$(eobj).attr("checked")){
		$('.wwwd_'+c).find('.chs').attr('checked',false);
	}else{
		$('.wwwd_'+c).find('.chs').attr('checked',true)
	}
}
</script>
<div class="main mhead">
    <div class="snav">管理组和客户 »  
    管理组 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('adminGroup/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['groupid']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['groupid']=='edit_admin_group'?'修改管理组':'添加管理组' ?></th>
    </tr>
    
    <tr>
        <td  width="100">管理组名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="group_name"   name="groupname" value="<?php echo $page['info']['groupname']; ?>"/> 
        </td>      
    </tr>
    <tr>
    	<td>管理角色：</td>
    	<td>
    	<?php foreach($page['roles'] as $r){?>
    	<label><input type="checkbox" name="roles[]" value="<?php echo $r['role_id'];?>" <?php echo $r['checked']?'checked':'';?> ><?php echo $r['role_name']; ?></label>
    	<?php }?>
    	</td>
    </tr>
    <tr>
    	<td></td>
    	<td><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('adminGroup/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>

</form>
</div>
