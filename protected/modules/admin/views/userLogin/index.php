<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">用户中心 »  会员登录记录管理	</div>
 
    <div class="mt10 clearfix">
        <div class="l">        
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('userLogin/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'userLogin_del')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center' width="80">	记录ID</th>
        <th >会员帐号</th>
        <th >登录时间</th>
        <th >IP地址</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['logs_id']; ?>" /></td>
        <td><?php echo $r['logs_id']; ?></td>
        <td><?php echo $r['uname']; ?></td>
        <td><?php echo date('Y-m-d H:i:s',$r['login_date']); ?></td>
     	<td><?php echo $r['login_ip']; ?></td>
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>