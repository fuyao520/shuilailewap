<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  内链关键词管理	</div>
 	<div class="mt10">
 		<form action="<?php echo $this->createUrl('nlink/index'); ?>">
	    <select id="search_type" name="search_type">
	        <option value="keys" <?php echo $this->get('search_type')=='keys'?'selected':''; ?>>关键字</option>
	        <option value="id" <?php echo $this->get('search_type')=='id'?'selected':''; ?>>ID</option>
	    </select>&nbsp;
	    <input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" >
	    <input type="submit" class="but" value="查询"  >
    	</form>
    </div>
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />','auth_tag'=>'nlink_edit')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('nlink/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'nlink_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加内链关键词" onclick="location=\''.$this->createUrl('nlink/update').'\'" />','auth_tag'=>'nlink_add')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('nlink/saveOrder'); ?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th width="48">排序</th>
        <th width="80"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('nlink/index').'?p='.$_GET['p'].'','field_cn'=>'ID','field'=>'nlink_id')); ?>	</th>
        <th width="400"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('nlink/index').'?p='.$_GET['p'].'','field_cn'=>'名称','field'=>'nlink_txt')); ?></th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['nlink_id']; ?>" /></td>
        <td><input type="text" size="2" name="listorders[<?php echo $r['nlink_id']; ?>]" value="<?php echo $r['norder']; ?>" /></td>
        <td><?php echo $r['nlink_id']; ?></td>
        <td class="alignleft"><a href="<?php echo $r['nlink_url']; ?>" target="_blank"><?php echo $r['nlink_txt']; ?></a></td>
     	
        <td>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('nlink/update').'?id='.$r['nlink_id'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'flink_edit')); ?></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>