<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<style>
.b004 label{ width:200px; overflow:hidden; display:inline-block;}
</style>

<div class="main mhead">
    <div class="snav">内容中心 » <?php echo $page['model_info']['model_name']; ?> »   字段管理	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />
           <input type="button" class="but2" value="添加字段" onclick="location='<?php echo $this->createUrl('modelField/update') ?>?model_id=<?php echo $this->get('model_id');?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('modelField/saveOrder'); ?>?model_id=<?php echo $this->get('model_id');?>" name="form_order" method="post">
<table class="tb">
    <tr>
         <th align='center' width="80"> 排序</th>
        <th >字段注释</th>
        <th >字段名</th>
        <th>字段类型</th>
        <th>表单类型</th>
        <th>系统字段</th>
        <th>管理列表</th>
        <th width=200>操作</th>
    </tr> 
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="text" size="2" name="listorders[<?php echo $r['field_id']; ?>]" value="<?php echo $r['field_order']; ?>" /></td>
        <td><?php echo $r['field_txt']; ?></td>
        <td><?php echo $r['field_name']; ?></td>
        <td><?php 
		$ty=vars::get_field_str('form_types',$r['form_type'],'type'); 
		if($ty=='int' ||$ty=='decimal'||$ty=='varchar'||$ty=='char' ){
		    echo $ty.'('.$r['length'].')';	
		}else{
		    echo $ty;
		}
		?></td>
        <td><?php $t=vars::get_field_str('form_types',$r['form_type'],'txt'); echo preg_replace('~(\([^\)]*\))~','',$t); ?></td>
         <td><?php echo $r['is_system']?'<span class=red>系统</span>':'-'; ?></td>
         <td><?php echo $r['list_show']?'<span class=red>√</span>':'<span class=blue>×</span>'; ?></td>	
        <td>
       <a href="<?php echo $this->createUrl('modelField/update') ?>?model_id=<?php echo $this->get('model_id');  ?>&id=<?php echo $r['field_id'];  ?>&p=<?php echo $_GET['p'];  ?>">修改</a>
       <?php 
	   if($r['is_system']==0){
	   ?>
       <a href="<?php echo $this->createUrl('modelField/delete') ?>?model_id=<?php echo $this->get('model_id');  ?>&id=<?php echo $r['field_id'];  ?>&p=<?php echo $_GET['p'];  ?>"  onclick="return confirm('确定删除吗？')">删除</a>
       <?php 
	   }else{
		  echo '<span class="ccc">——</span>'; 
		 }
	   ?>
        </td>	
    </tr>
   <?php 
   } ?>    
</table>
  <div class="pagebar"><span>总数：<?php echo $page['listdata']['pagearr']['total']; ?></span></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>