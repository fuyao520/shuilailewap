<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	foreach($page['model_fields2'] as $f){
		$page['info'][$f['field_name']]=$f['setting']['default_value'];
	}
	$page['info']['id']='';
	$page['info']['username']='';
	$page['info']['ip']='';
	
}
?>


<div class="main mhead">
    <div class="snav">用户表单 »  
    <?php foreach($page['parent_cate_arr'] as $cate){?>
             <?php echo $cate['model_name']; ?> »
    <?php }?>
    表单管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('diyForm/update'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&p=<?php echo $_GET['p'];?>">
<input type="hidden" id="cate_id" name="cate_id" value="<?php echo $_GET['cate_id']; ?>" />
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['id']; ?>" />
<script>
$(document).ready(function(){
	C.tabs(
	{"style":{		//选项卡样式
	"sclass":"current"	//选中
	},
	"params":[{"nav":"#tabbtn01","con":"#tab001"},{"nav":"#tabbtn02","con":"#tab002"},{"nav":"#tabbtn03","con":"#tab003"}]}
	)
})
</script>
<div class="tab_table">
   <div class="title01"><?php echo $page['info']['id']?'修改表单':'添加表单' ?></div>
   <div class="btn_box">
        <a href="javascript:void(0);" class="current" id="tabbtn01">基本信息</a>
   </div>
</div>
<table class="tb3"  id="tab001">
    
    
    <?php foreach($page['model_fields2'] as $f){?>
    <tr>
        <td  width="100"><?php echo $f['field_txt']; ?>：</td>
        <td style="position:relative;">
        <div style="position:relative;">
         <?php echo form_type_code::get_html(array('type'=>$f['form_type'],'default_value'=>$page['info'][$f['field_name']],'form_name'=>$f['field_name'],'ini_value'=>$f['setting']['ini_value'],'linkage_type_id'=>$f['linkage_type_id'])); ?>
         <?php echo $f['tips']; ?>
        </div>
        </td>
    </tr>
    <?php }?>
    
</table>

<table class="tb3">
    <tr>
       <td width="100"></td>
       <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onClick="window.location='<?php echo $this->createUrl('diyForm/index'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>