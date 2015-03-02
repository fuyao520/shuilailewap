<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  系统用户管理	</div>
 	<div class="mt10">
	    <select id="search_type">
	        <option value="keys" <?php echo $this->get('search_type')=='keys'?'selected':''; ?>>关键字</option>
	        <option value="id" <?php echo $this->get('search_type')=='id'?'selected':''; ?>>ID</option>
	    </select>&nbsp;
	    <input type="text" id="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" onkeyup="if(event.keyCode==13){window.location='<?php echo $this->createUrl('adminUser/index');?>?search_txt='+$('#search_txt').val()+'&search_type='+$('#search_type').val();}"  >&nbsp;<input type="button" class="but" value="查询" onclick="window.location='<?php echo $this->createUrl('adminUser/index');?>?search_txt='+$('#search_txt').val()+'&search_type='+$('#search_type').val();" >&nbsp;
    </div>
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('adminUser/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'admin_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加系统用户" onclick="location=\''.$this->createUrl('adminUser/update').'\'" />','auth_tag'=>'admin_add')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('adminUser/saveOrder'); ?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center' width="80"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('adminUser/index').'?p='.$_GET['p'].'','field_cn'=>'ID','field'=>'csno')); ?>	</th>
        <th width="400"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('adminUser/index').'?p='.$_GET['p'].'','field_cn'=>'账号','field'=>'csname')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('adminUser/index').'?p='.$_GET['p'].'','field_cn'=>'分组','field'=>'groupid')); ?></th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['csno']; ?>" /></td>
        <td><?php echo $r['csno']; ?></td>
        <td class="alignleft"><?php echo $r['csname']; ?></td>
     	<td><?php echo $r['groupname']; ?></td>
        <td>
         <?php if($r['csno']!=Yii::app()->params['management']['super_admin_id']){ ?>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('adminUser/update').'?id='.$r['csno'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'flink_edit')); ?></td>	
    	<?php }else{?>
    	-
    	<?php }?>
    
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>