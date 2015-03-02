<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['linkage_type_id']='';
	$page['info']['linkage_type_name']='';
}
?>

<div class="main mhead">
    <div class="snav">内容中心 »  
    联动分类管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('linkageType/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['linkage_type_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['linkage_type_id']?'修改联动分类':'添加联动分类' ?></th>
    </tr>
       
    <tr>
        <td  width="100">联动分类名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="linkage_type_name"   name="linkage_type_name" value="<?php echo $page['info']['linkage_type_name']; ?>"/> 

        </td>      
    </tr>   
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('linkageType/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
    
    
    
</table>
</form>
</div>

<?php require(dirname(__FILE__)."/../common/foot.php"); ?>