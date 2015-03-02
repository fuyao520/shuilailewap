<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  标签管理	</div>
    <div class="mt10 clearfix">
       <select onchange="if(this.value){location='<?php echo $this->createUrl('tag/index'); ?>?tag_cate_id='+this.value;}">
       <option value="">--快速选择分类--</option>
        <?php echo helper::get_option(array('table_name'=>'tag_cate','id_field_name'=>'tag_cate_id','txt_field_name'=>'tag_cate_name','select_value'=>$this->get('tag_cate_id'))); ?>
        </select>
    </div>
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />','auth_tag'=>'tag_edit')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('tag/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'tag_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="标签分类管理" onclick="location=\''.$this->createUrl('tagCate/index').'\'" />','auth_tag'=>'tag_edit')); ?>
		   <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加标签" onclick="location=\''.$this->createUrl('tag/update').'\'" />','auth_tag'=>'tag_add')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('tag/saveOrder'); ?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('Tag/index').'?p='.$_GET['p'],'field_cn'=>'排序','field'=>'a.tag_order')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('Tag/index').'?p='.$_GET['p'],'field_cn'=>'标签ID','field'=>'a.tag_id')); ?></th>
        <th  width="400"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('Tag/index').'?p='.$_GET['p'],'field_cn'=>'标签名称','field'=>'a.tag_txt')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('Tag/index').'?p='.$_GET['p'],'field_cn'=>'分类','field'=>'a.tag_cate_id')); ?></th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['tag_id']; ?>" /></td>
        <td><input type="text" size="2" name="listorders[<?php echo $r['tag_id']; ?>]" value="<?php echo $r['tag_order']; ?>" /></td>
        <td><?php echo $r['tag_id']; ?></td>
        
        <td class="alignleft"><?php echo $r['tag_txt']; ?></td>
     	<td><?php echo $r['tag_cate_name']; ?></td>
        <td>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('tag/update').'?id='.$r['tag_id'].'&p='.$_GET['p'].'">修改</a>','auth_tag'=>'tag_edit')); ?></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>