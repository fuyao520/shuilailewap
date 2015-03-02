<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['model_id']='';
	$page['info']['model_name']='';
	$page['info']['parent_model_id']='';
	$page['info']['model_type']=0;
	$page['info']['model_table_name']='';	
	$page['info']['cmodel_table_name']='';	
	$page['info']['cmodel_id']=0;
}	
?>


<div class="main mhead">
    <div class="snav">系统 »  
    模型管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('infoModel/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['model_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['model_id']?'修改模型':'添加模型' ?></th>
    </tr> 
   <?php if($page['info']['model_id']==0){ ?>
    <tr>
        <td  width="100">继承模型：</td>
        <td  class="alignleft"><select id="parent_model_id" name="parent_model_id">
        <option value="0">≡ 作为顶层模型 ≡</option>
		<?php echo $page['model_cates']; ?></select><font color="red">* 确定后禁止修改</font></td>      
    </tr> 
    <tr>
        <td  width="100">模型类型：</td>
        <td >
         <?php echo vars::input_str(array('node'=>'model_types','type'=>'radio','default'=>$page['info']['model_type'],'name'=>'model_type')); ?>
        <font color="red">* 确定后禁止修改</font>
        </td>      
    </tr>  
    <?php }?>
    <tr>
        <td  width="100">模型名称：</td>
        <td >
        <input type="text"  class="ipt"  id="model_name"   name="model_name" value="<?php echo $page['info']['model_name']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">数据表名称：</td>
        <td >
        <?php if($page['info']['model_table_name']==''){ ?>
        <input type="text"  class="ipt"  id="model_table_name"   name="model_table_name" value="<?php echo $page['info']['model_table_name']; ?>" /> 
        <?php }else{ ?>
        <?php echo $page['info']['model_table_name']; ?>
         <input type="hidden"  class="ipt"  id="model_table_name"   name="model_table_name" value="<?php echo $page['info']['model_table_name']; ?>" /> 
        <?php } ?>
         <font color="red">* 确定后禁止修改</font>
        </td>      
    </tr>     
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('infoModel/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>