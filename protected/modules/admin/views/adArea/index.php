<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  广告位置管理	</div>
 	<div class="mt10">
 		<form action="<?php echo $this->createUrl('adArea/index'); ?>">
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
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('adArea/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'adArea_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加广告位" onclick="location=\''.$this->createUrl('adArea/update').'\'" />','auth_tag'=>'adArea_add')); ?>
           
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
        <th width="80"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('adArea/index').'?p='.$_GET['p'].'','field_cn'=>'ID','field'=>'area_id')); ?>	</th>
        <th width="400"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('adArea/index').'?p='.$_GET['p'].'','field_cn'=>'广告位置名称','field'=>'adArea_txt')); ?></th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['area_id']; ?>" /></td>
        <td><?php echo $r['area_id']; ?></td>
        <td class="alignleft"><a href="<?php echo $this->createUrl('ad/index');?>?search_type=area_id&search_txt=<?php echo $r['area_id'];  ?>"><?php echo $r['area_name']; ?><font style="color:red">(<?php echo $r['totals'];?>)</font></a></td>
     	
        <td>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('ad/index').'?search_type=area_id&search_txt='.$r['area_id'].'">查看广告</a>','auth_tag'=>'ad_show')); ?>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('adArea/update').'?id='.$r['area_id'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'flink_edit')); ?></td>	
         </td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>

<?php require(dirname(__FILE__)."/../common/head.php"); ?>