<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  推荐达人管理	</div>
 	<div class="mt10">
 		<form action="<?php echo $this->createUrl('userStar/index'); ?>">
	    <select id="search_type" name="search_type">
	        <option value="keys" <?php echo $this->get('search_type')=='keys'?'selected':''; ?>>用户名称</option>
	        <option value="id" <?php echo $this->get('search_type')=='id'?'selected':''; ?>>ID</option>
	    </select>&nbsp;
	    <input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" >
	    <input type="submit" class="but" value="查询"  >
    	</form>
    </div>
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('userStar/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'userStar_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加达人" onclick="location=\''.$this->createUrl('userStar/update').'\'" />','auth_tag'=>'userStar_add')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('userStar/saveOrder'); ?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th ><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('userStar/index').'?p='.$_GET['p'].'','field_cn'=>'日期','field'=>'a.create_time')); ?></th>
        <th ><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('userStar/index').'?p='.$_GET['p'].'','field_cn'=>'用户ID','field'=>'a.uid')); ?></th>
        <th ><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('userStar/index').'?p='.$_GET['p'].'','field_cn'=>'用户','field'=>'uname')); ?></th>
        <th ><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('userStar/index').'?p='.$_GET['p'].'','field_cn'=>'图片','field'=>'cover')); ?></th>
        <th width="400"  class="alignleft">推荐理由</th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['id']; ?>" /></td>
       	<td><?php echo date('Y-m-d',$r['create_time']); ?></td>
        <td><?php echo $r['uid']; ?></td>
        <td><?php echo $r['uname']; ?></td>
        <td>
        <?php if( $r['cover']){ ?>
        <img src="<?php echo $r['cover']; ?>" style="margin:2px;max-width:100px; min-height:20px;_width:100px;height:20px;" />
        <?php }?>
        </td>
        <td class="alignleft"><?php echo $r['reason']; ?></td>
     	
        <td>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('userStar/update').'?id='.$r['id'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'flink_edit')); ?></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>