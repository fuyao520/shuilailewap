<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['tag_cate_id']='';
	$page['info']['tag_cate_name']='';
	$page['info']['tag_cate_order']=50;
	$page['info']['info_cate_id']='';
}
?>


<div class="main mhead">
    <div class="snav">内容中心 »  
    标签分类管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('tagCate/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['tag_cate_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['tag_cate_id']?'修改标签':'添加标签' ?></th>
    </tr> 
    
    
    <tr>
        <td  width="100">分类名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="tag_cate_name"   name="tag_cate_name" value="<?php echo $page['info']['tag_cate_name']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">信息分类id：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="info_cate_id"   name="info_cate_id" value="<?php echo $page['info']['info_cate_id']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">排序：</td>
        <td  class="alignleft">
        <input type="text" class="ipt" size="5"  id="tag_cate_order"   name="tag_cate_order" value="<?php echo $page['info']['tag_cate_order']; ?>"/> 

        </td>      
    </tr> 
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('tagCate/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>