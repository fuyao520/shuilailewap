<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['group_id']='';
	$page['info']['group_name']='';
    $page['info']['group_level']='';
    $page['info']['group_rank']='';
}
?>


<div class="main mhead">
    <div class="snav">会员中心 »  
    会员组 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('userGroup/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['group_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['group_id']?'修改用户组':'添加用户组' ?></th>
    </tr> 
    
    <tr>
        <td  width="100">会员组名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="group_name"   name="group_name" value="<?php echo $page['info']['group_name']; ?>"/> 
        </td>      
    </tr>
    
    <tr>
        <td  width="100">权限值：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="group_rank"   name="group_rank" value="<?php echo $page['info']['group_rank']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('userGroup/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>

</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>
