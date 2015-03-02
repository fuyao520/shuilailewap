<?php require(dirname(__FILE__)."/../common/head.php"); ?>


<div class="main mhead">
    <div class="snav">内容中心 »  专题管理	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />
           <input type="button" class="but2" value="删除选中" onclick="set_some('<?php echo $this->createUrl('special/delete');?>?ids=[@]','确定删除吗？');" />
           <input type="button" class="but2" value="添加专题" onclick="location='<?php echo $this->createUrl('special/update');?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th  width="80"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center' width="80"> 排序</th>
        <th align='center' width="80">	专题ID</th>
        <th width="300"  class="alignleft">专题名称</th>
        <th>资讯分类</th>
        <th>封面</th>
        <th>banner</th>
        <th>创建时间</th>
		<th>审核状态</th>
        <th width=240>操作</th>
    </tr>
     <?php echo $page['categorys']; ?>
    
</table>
  <div class="pagebar">共 <?php echo $page['total']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>