<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  伪静态管理	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />','auth_tag'=>'rewrite_edit')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('rewrite/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'rewrite_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加伪静态" onclick="location=\''.$this->createUrl('rewrite/update').'\'" />','auth_tag'=>'rewrite_add')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="60"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th width="80">	排序</th>
        <th width="80"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('rewrite/index').'?p='.$_GET['p'].'','field_cn'=>'ID','field'=>'rewrite_id')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('rewrite/index').'?p='.$_GET['p'].'','field_cn'=>'调用标识','field'=>'rewrite_ident')); ?></th>
        <th width="200"   class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('rewrite/index').'?p='.$_GET['p'].'','field_cn'=>'类型','field'=>'rewrite_type')); ?>-<?php echo helper::field_paixu(array('url'=>''.$this->createUrl('rewrite/index').'?p='.$_GET['p'].'','field_cn'=>'伪静态名称','field'=>'rewrite_name')); ?></th>
        <th width="200"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('rewrite/index').'?p='.$_GET['p'].'','field_cn'=>'伪静态示例','field'=>'rewrite_example')); ?></th>
        <th width="300"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('rewrite/index').'?p='.$_GET['p'].'','field_cn'=>'规则','field'=>'rewrite_rule')); ?></th>
        <th width=80>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['rewrite_id']; ?>" /></td>
        <td><input type="text" size="2" name="listorders[<?php echo $r['rewrite_id']; ?>]" value="<?php echo $r['rewrite_order']; ?>" /></td>
        <td><?php echo $r['rewrite_id']; ?></td>
        <td><?php echo $r['rewrite_ident']?$r['rewrite_ident']:'-'; ?></td>
        <td class="alignleft"><font color="#999999">[<?php echo vars::get_field_str('rewrite_type',$r['rewrite_type']); ?>]</font><?php echo $r['rewrite_name']; ?></td>
        <td class="alignleft"><?php echo $r['rewrite_example']; ?></td>
        <td class="alignleft"><?php echo $r['rewrite_rule']; ?></td>
     	
        <td>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('rewrite/update').'?id='.$r['rewrite_id'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'flink_edit')); ?></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>