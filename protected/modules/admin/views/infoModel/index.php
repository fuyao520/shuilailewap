<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">系统 »  模型管理	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value="添加模型" onclick="location='<?php echo $this->createUrl('infoModel/update');?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('infoModel/saveOrder');?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th align='center' width="100">	模型ID</th>
        <th  class="alignleft">模型名称</th>
        <th>表名称</th>
        <th>类型</th>
        <th>数据量</th>
        <th width=200>操作</th>
    </tr>
    
   <?php echo $page['listdata']; ?> 
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>