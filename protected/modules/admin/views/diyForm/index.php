<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">用户表单 »  
    <?php foreach($page['parent_cate_arr'] as $cate){?>
             <?php echo $cate['model_name']; ?> »
    <?php }?>
    表单管理 </div>
    
    <div class="mt10 clearfix">
        <div class="l">
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('diyForm/delete').'?cate_id='.$_GET['cate_id'].'&ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'form_del')); ?>
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="已审核" onclick="set_some(\''.$this->createUrl('diyForm/audit').'?cate_id='.$_GET['cate_id'].'&ids=[@]&audit=1\',\'确定设置为已审核吗？\');" />','auth_tag'=>'form_audit')); ?>
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="未审核" onclick="set_some(\''.$this->createUrl('diyForm/audit').'?cate_id='.$_GET['cate_id'].'&ids=[@]&audit=0\',\'确定设置为未审核吗？\');" />','auth_tag'=>'form_audit')); ?>
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加" onclick="location=\''.$this->createUrl('diyForm/update').'?cate_id='.$_GET['cate_id'].'\'" />','auth_tag'=>'form_add')); ?>
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('diyForm/saveOrder'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>" name="form_order" method="post" >
<table class="tb" >
    <tr>
        <th width="40"><a href="javascript:void(0);" onclick="check_all('.cklist');">反选</a></th>
        <th align='center' width="70">ID</th>
        <?php foreach($page['model_fields'] as $f){?>
        <th title="<?php echo $f['field_txt']; ?>"><div style=" height:20px;line-height:20px;overflow:hidden;">
		<?php echo helper::field_paixu(array('url'=>'?cate_id='.$_GET['cate_id'].'&p='.$_GET['p'].'','field_cn'=>$f['field_txt'],'field'=>$f['field_name'])); ?>
        </div></th>
       <?php } ?>
        <th width=90>操作 </th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['id']?$r['id']:$r['i_id']; ?>" /></td>
        <td><?php echo $r['id']; ?></td>
        <?php foreach($page['model_fields'] as $f){?>
        <td style="max-width:200px;"><div style=" height:20px; overflow:hidden; line-height:20px;"><?php  echo form_type_code::get_html(array('m'=>'list_show_value','field_value'=>$r[$f['field_name']],'type'=>$f['form_type'],'ini_value'=>$f['setting']['ini_value'])) ?></div></td>
       <?php } ?>
        <td>
         <?php foreach($page['cmodel'] as $r2){ ?>
        <a onclick="return dialog_frame(this);" href="<?php echo $this->createUrl('childTable/index') ?>?id=<?php echo $r['info_id'];?>&id_model_id=<?php echo $r['model_id'];?>&cmodel_id=<?php echo $r2['model_id'];?>"><?php echo $r2['model_name'];?></a>
		<?php }?>
         <a href="<?php echo $this->createUrl('diyForm/update');?>?cate_id=<?php echo $_GET['cate_id'];  ?>&p=<?php echo $_GET['p'];  ?>&id=<?php echo $r['id']; ?>">修改</a> 
          </td>
    </tr>
   <?php } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>