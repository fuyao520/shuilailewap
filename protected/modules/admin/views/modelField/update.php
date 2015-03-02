<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['field_id']=0;
	$page['info']['is_system']=0;
	$page['info']['field_name']='';
	$page['info']['field_txt']='';
	$page['info']['form_type']='';
	$page['info']['tips']='';
	$page['info']['length']='255';
	$page['info']['list_show']=1;
	$page['info']['field_order']=50;
	$page['info']['linkage_type_id']=0;
	$page['info']['linkage_select_parent_id']=0;
	$page['info']['linkage_select_selectnum']=0;
	$page['info']['setting']=array();
	$page['info']['setting']['default_value']='';
	$page['info']['setting']['ini_value']='';

}
?>

<script>
function get_select_branch(jsonstr){
   //alert(jsonstr);
   try{
	   var data=$.evalJSON(jsonstr);
	   $("#forcity").html(data.branch_province+'-'+data.branch_city); 
	   $("#branch_id").val(data.branch_id); 
	   $("#branch_name").html(data.branch_name);   
   }catch(e){alert(e.message);}
}
function change_form_type(){
    var r=$("#form_type").val();
	var b=$("#length");	
    if(r=='varchar_single_line'||r=='char_single_line'){
	    b.val('255');   
    }
	if(r=='int_' || r=='sjc' || r=='linkage'){
	    b.val('11');	
	}
} 
function get_linkage_type_txt(id){
    if(id==''){
	    return false;	
	}
	$.get("<?php echo $this->createUrl('modelField/getLinkageType'); ?>?model_id=<?php echo $this->get('model_id');?>&linkage_type_id="+id,function(data){
		$("#bbdd01").html(data);
	     //alert(data);	
	})	
}
</script>
<style>
.b004 label{ width:200px; overflow:hidden; display:inline-block;}
</style>

<div class="main mhead">
    <div class="snav">内容中心 » <?php echo $page['model_info']['model_name']; ?> »   字段管理	</div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('modelField/update'); ?>?model_id=<?php echo $this->get('model_id'); ?>&p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['field_id']; ?>" />
<input type="hidden" id="model_id" name="model_id" value="<?php echo $this->get('model_id'); ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['field_id']?'修改字段':'添加字段'; ?></th>
    </tr>
    <?php if($page['info']['is_system']==0){ ?>
    <tr>
        <td  width="100">是否为系统字段：</td>
        <td  class="alignleft">
        
        <label><input type="radio" name="is_system" value="0" <?php echo $page['info']['is_system']==0?'checked':''; ?> /> 不是</label>
        <label><input type="radio" name="is_system" value="1" <?php echo $page['info']['is_system']==1?'checked':''; ?> /> 是</label>
        <span class="red"> * 是的话，添加了就不可以对字段名进行修改</span>
       
        </td>      
    </tr>
     <?php }else{ ?>
              <input type="hidden" name="is_system" value="1" />
     <?php } ?>
    <tr>
        <td  width="100">字段注释：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="field_txt"    name="field_txt" value="<?php echo $page['info']['field_txt']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">字段：</td>
        <td  class="alignleft">
        <?php if($page['info']['is_system']==0){ ?>
        <input type="text"  class="ipt"  id="field_name"     name="field_name" value="<?php echo $page['info']['field_name']; ?>"/>  <span class="red">*</span>
        <?php }else{ ?>
            <input type="hidden"  class="ipt"  id="field_name"     name="field_name" value="<?php echo $page['info']['field_name']; ?>"/> 
            <?php echo $page['info']['field_name']; ?> <span class="red">（系统字段，不能更改）</span>
		<?php } ?>
        
        </td>      
    </tr>
    <tr>
        <td  width="100">提示文字：</td>
        <td  class="alignleft">
        <textarea id="tips"    name="tips" style="width:500px; height:80px;"><?php echo htmlspecialchars($page['info']['tips']); ?></textarea>
        </td>      
    </tr>
    <tr>
        <td  width="100">表单类型：</td>
        <td  class="alignleft">
            <div class="b004">
            <select id="form_type" name="form_type" onchange="change_form_type()"> 
            <?php echo vars::input_str(array('node'=>'form_types','type'=>'select','default'=>$page['info']['form_type'],'name'=>'form_type')); ?>
            </select>
            <input type="text"  class="ipt" size="8"  id="length"     name="length" value="<?php echo $page['info']['length']; ?>"/>  <span > * 相对于字段类型，数字，小数，文本 不一样</span>
            </div>
        </td>      
    </tr>
    <tr>
        <td  width="100">联动分类的ID：</td>
        <td  class="alignleft">
        <input type="text" size="5"  class="ipt"  id="linkage_type_id"    name="linkage_type_id" value="<?php echo $page['info']['linkage_type_id']; ?>" onkeyup="get_linkage_type_txt(this.value);"/>  <span id="bbdd01" style="color:green;"></span>
         <span > * 如果定义数据类型为select、radio、checkbox，如分类数量庞大或需要便捷管理，则此处可设定，联动菜单则必须填写</span>
        </td>      
    </tr>
    <tr>
        <td  width="100">联动下拉设置：</td>
        <td  class="alignleft">
            <input type="text" size="5"  class="ipt"  id="linkage_select_parent_id"    name="linkage_select_parent_id" value="<?php echo $page['info']['linkage_select_parent_id']; ?>" />
         <span > * 从哪个类别id开始</span><br />
          <div class="mt10"> <input type="text" size="5"  class="ipt"  id="linkage_select_selectnum"    name="linkage_select_selectnum" value="<?php echo $page['info']['linkage_select_selectnum']; ?>" />
         <span > * 限制select的数量</span>
         </div>
             
        </td>      
    </tr>
    
    <tr>
        <td  width="100">初始值：</td>
        <td  class="alignleft">
           <textarea name="setting[ini_value]" style="width:200px; height:100px;"><?php echo $page['info']['setting']['ini_value']; ?></textarea><span>初始值,如果定义数据类型为select、radio、checkbox，如需快速设置，比如（性别, 男，女 ， 是否 ）没必要在联动菜单那里管理，则设定此项，值与文字逗号隔开，每个之间换行</span>
        </td>      
    </tr>
    <tr>
        <td  width="100">默认选中：</td>
        <td  class="alignleft">
           <input type="text" class="ipt" name="setting[default_value]" value="<?php echo $page['info']['setting']['default_value']; ?>" />
           <span> 复选框的话 ，多个用逗号隔开</span>
        </td>      
    </tr> 
    
    
    <tr>
        <td  width="100">排序：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt" size="8"  id="field_order"  name="field_order"     value="<?php echo $page['info']['field_order']; ?>"/>
        </td>      
    </tr>
    <tr>
        <td  width="100">是否在管理列表显示：</td>
        <td  class="alignleft">
        
        <label><input type="radio" name="list_show" value="0" <?php echo $page['info']['list_show']==0?'checked':''; ?> /> 不显示</label>
        <label><input type="radio" name="list_show" value="1" <?php echo $page['info']['list_show']==1?'checked':''; ?> /> 显示</label>
        <span class="red"> * 是的话，添加了就不可以对字段名进行修改</span>
       
        </td>      
    </tr>
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('modelField/index'); ?>?model_id=<?php echo $this->get('model_id'); ?>&p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
    
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>