<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">系统 »  会员组	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value="添加会员组" onclick="location='<?php echo $this->createUrl('userGroup/update');?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th align='center'>	<?php echo helper::field_paixu(array('url'=>''.$this->createUrl('userGroup/index').'?p='.$_GET['p'].'','field_cn'=>'ID','field'=>'group_id')); ?></th>
        <th  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('userGroup/index').'?p='.$_GET['p'].'','field_cn'=>'会员组名称','field'=>'group_name')); ?></th>
        <th width=200>操作</th>
    </tr>   
   <?php 
   foreach($page['listdata']['list'] as $r){
	    $r['group_level']=json_decode($r['group_level'],true);
   ?>
    <tr>   
        <td><?php echo $r['group_id']; ?></td>
        <td class="alignleft"><?php echo $r['group_name']; ?></td>
        	
        <td>
        <?php if($r['is_system']==0){ ?>
        <a href="<?php echo $this->createUrl('userGroup/update');?>?id=<?php echo $r['group_id'];  ?>&p=<?php echo $_GET['p'];  ?>">修改</a>
        <a href="<?php echo $this->createUrl('userGroup/delete');?>?id=<?php echo $r['group_id'];  ?>&p=<?php echo $_GET['p'];  ?>" onclick="return confirm('确定删除吗？')">删除</a>
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
</div><?php require(dirname(__FILE__)."/../common/head.php"); ?>