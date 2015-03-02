<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['area_id']='';
	$page['info']['area_name']='';
	$page['info']['ad_area_url']='';

}
?>

<div class="main mhead">
    <div class="snav">内容中心 »  
    广告位置管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('adArea/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['area_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['area_id']?'修改广告位置':'添加广告位置' ?></th>
    </tr>
          
    <tr>
        <td  width="100">广告位置名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="area_name"   name="area_name" value="<?php echo $page['info']['area_name']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('adArea/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>