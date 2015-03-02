<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['nlink_id']='';
	$page['info']['nlink_txt']='';
	$page['info']['nlink_url']='';
	$page['info']['norder']=50;
}
?>
<div class="main mhead">
    <div class="snav">内容中心 »  
    内链关键词管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('nlink/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['nlink_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['nlink_id']?'修改内链关键词':'添加内链关键词' ?></th>
    </tr>   
    
    <tr>
        <td  width="100">内链关键词名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="nlink_txt"   name="nlink_txt" value="<?php echo $page['info']['nlink_txt']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td  width="100">链接地址：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="nlink_url"   name="nlink_url" value="<?php echo $page['info']['nlink_url']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td  width="100">排序：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="norder"   name="norder" value="<?php echo $page['info']['norder']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('nlink/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>