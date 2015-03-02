<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['tag_id']='';
	$page['info']['tag_txt']='';
	$page['info']['tag_cate_id']='';
	$page['info']['tag_order']=50;
}
?>

<div class="main mhead">
    <div class="snav">内容中心 »  
    标签管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('tag/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['tag_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['tag_id']?'修改标签':'添加标签' ?></th>
    </tr> 
    
    <tr>
        <td  width="100">标签分类：</td>
        <td  class="alignleft">
        <select name="tag_cate_id" id="tag_cate_id">
        <?php echo helper::get_option(array('table_name'=>'tag_cate','id_field_name'=>'tag_cate_id','txt_field_name'=>'tag_cate_name','select_value'=>$page['info']['tag_cate_id'])); ?>
        </select>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">标签名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="tag_txt"   name="tag_txt" value="<?php echo $page['info']['tag_txt']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">排序：</td>
        <td  class="alignleft">
        <input type="text" class="ipt" size="5"  id="tag_order"   name="tag_order" value="<?php echo $page['info']['tag_order']; ?>"/> 

        </td>      
    </tr>
   
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('tag/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>