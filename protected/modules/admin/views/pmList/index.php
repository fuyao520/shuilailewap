<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">用户中心 »  站内信管理	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('pmList/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'pm_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加站内信" onclick="location=\''.$this->createUrl('pmList/update').'\'" />','auth_tag'=>'pm_add')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center' width="80">ID</th>
        <th width="400"  class="alignleft">[类型]标题</th>
        <th>已读人数</th>
        <th>发送时间</th>
        <th>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['pm_id']; ?>" /></td>
        <td><?php echo $r['pm_id']; ?></td>
        <td class="alignleft">
		[<?php echo $r['pm_type']==1?'<font color=red>系统</font>':'私信'; ?>]
		<?php echo $r['pm_title']; ?></td>
     	<td><?php echo $r['pm_reads']; ?></td>
        <td><?php echo date('Y-m-d H:i:s',$r['post_date']); ?></td>
        <td>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('pmList/update').'?id='.$r['pm_id'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'pm_edit')); ?></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
