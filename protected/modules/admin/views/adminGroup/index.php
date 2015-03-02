<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">系统 »  管理组	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value="添加管理组" onclick="location='<?php echo $this->createUrl('adminGroup/update');?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th align='center'>	组ID</th>
        <th  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('adminGroup/index').'?p='.$_GET['p'].'','field_cn'=>'管理组名称','field'=>'groupname')); ?>	</th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
	    //$r['group_level']=json_decode($r['group_level'],true);
   ?>
    <tr>   
        <td><?php echo $r['groupid']; ?></td>
        <td class="alignleft"><?php echo $r['groupname']; ?></td>
        	
        <td>
        <?php if($r['groupid']!=Yii::app()->params['management']['super_group_id']){ ?>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('adminGroup/update').'?id='.$r['groupid'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'admin_group_edit')); ?>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('adminGroup/delete').'?id='.$r['groupid'].'&p='.$_GET['p'].'" onclick="return confirm(\'确定删除吗？\')">删除</a>','auth_tag'=>'admin_group_del')); ?>
        
        <?php }else{?>
           -
		<?php }?>
        </td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>
<?php 
