<?php require(dirname(__FILE__)."/../common/head.php"); ?>

<div class="main mhead">
    <div class="snav">用户中心 »  会员积分管理	</div>
 	<div class="mt10">
 		<form action="<?php echo $this->createUrl('nlink/index'); ?>">
	    <select id="search_type" name="search_type">
	        <option value="keys" <?php echo $this->get('search_type')=='keys'?'selected':''; ?>>关键字</option>
	        <option value="uid" <?php echo $this->get('search_type')=='uid'?'selected':''; ?>>UID</option>
	    </select>&nbsp;
	    <input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" >
	    <input type="submit" class="but" value="查询"  >
    	</form>
    </div>
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('userPoints/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'nlink_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加积分" onclick="location=\''.$this->createUrl('userPoints/update').'\'" />','auth_tag'=>'nlink_add')); ?>
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
        <th align='center' width="80">	积分编号</th>
        <th align='center' width="80">	会员帐号</th>
        <th align='center' width="80">	积分</th>
        <th width="400"  class="alignleft">积分原因</th>
        <th>产生时间</th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['points_id']; ?>" /></td>
        <td><?php echo $r['points_id']; ?></td>
        <td><?php echo $r['uname']; ?></td>
        <td><?php echo $r['points']; ?></td>
        <td class="alignleft"><a href="user_points.php?m=edit_user_point&points_id=<?php echo $r['points_id'];  ?>&p=<?php echo $_GET['p'];  ?>"><?php echo $r['points_reason']; ?></a></td>
     	<td><?php echo date('Y-m-d H:i:s',$r['create_date']); ?></td>
        <td><a href="<?php echo $this->createUrl('userPoints/update');?>?id=<?php echo $r['points_id'];  ?>&p=<?php echo $_GET['p'];  ?>">修改</a></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>