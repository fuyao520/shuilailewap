<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['id']='';
	$page['info']['mark']='';
	$page['info']['url']='';
	$page['info']['seo_title']='';
	$page['info']['seo_keyword']='';
	$page['info']['seo_description']='';
	$page['info']['displayorder']=50;
}
?>
<div class="main mhead">
    <div class="snav">内容中心 »  
    seo页面管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('siteSeo/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['id']?'修改seo页面':'添加seo页面' ?></th>
    </tr>   
    
    <tr>
        <td  width="100">备注：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="mark"   name="mark" value="<?php echo $page['info']['mark']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td  width="100">链接地址：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt" style="width:500px;"  id="url"   name="url" value="<?php echo $page['info']['url']; ?>"/> 

        </td>      
    </tr>
     <tr>
        <td  width="100">seo标题：</td>
        <td  class="alignleft">
        <textarea style="width:500px;height:60px;" name="seo_title"><?php echo $page['info']['seo_title']; ?></textarea>

        </td>      
    </tr>
    <tr>
        <td  width="100">seo关键词：</td>
        <td  class="alignleft">
        <textarea style="width:500px;height:60px;" name="seo_keyword"><?php echo $page['info']['seo_keyword']; ?></textarea>

        </td>      
    </tr>
    <tr>
        <td  width="100">seo描述：</td>
        <td  class="alignleft">
        <textarea style="width:500px;height:60px;" name="seo_description"><?php echo $page['info']['seo_description']; ?></textarea>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">排序：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="displayorder"   name="displayorder" value="<?php echo $page['info']['displayorder']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('siteSeo/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>