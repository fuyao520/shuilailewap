<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['special_id']='';
	$page['info']['cate_id_top']='';
	$page['info']['special_name']='';
	$page['info']['special_desc']='';
	$page['info']['special_banner']='';
	$page['info']['special_img']='';
	$page['info']['sorder']=50;
	$page['info']['create_date']='';
	$page['info']['typesetting']='';
	$page['info']['audit']=1;
	$page['info']['template']='';    	
}
?>
<script>
function attr_add(){
	try{
    	var nodecode=$("#attr_area_box tr").eq(0);	
		$("#attr_area_box").append('<tr>'+nodecode.html()+'</tr>');
		$("#attr_area_box tr").last().find(".ipt").val('');
		$("#attr_area_box tr").last().find("select").val('');
		$("#attr_area_box tr").last().find(".controltd").append('<a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a>');
	}catch(e){
		alert(e.message);
	}
}
</script>
<div class="main mhead">
    <div class="snav">内容中心 »  
    专题管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('special/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['special_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['special_id']?'修改专题':'添加专题'; ?></th>
    </tr>
    <tr>
        <td  width="100">所属内容分类：</td>
        <td  class="alignleft"><select id="cate_id_top" name="cate_id_top">
		<?php echo $page['categorys']; ?></select></td>      
    </tr>
    
    <tr>
        <td  width="100">所属专题分类：</td>
        <td  class="alignleft"><select id="special_parent_id" name="special_parent_id">
        <option value="0">--选择--</option>
		<?php echo $page['specials']; ?></select></td>      
    </tr>
    
    <tr>
        <td  width="100">专题名称：</td>
        <td  class="alignleft">
        <input type="text" size="50" class="ipt"  id="special_name"   name="special_name" value="<?php echo $page['info']['special_name']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td  width="100">专题分类：</td>
        <td  class="alignleft">
       <!--<textarea style="width:600px; height:100px;" name="typesetting" id="typesetting"><?php echo $page['info']['typesetting']; ?></textarea><span class="red"> *值与文本 用英文逗号隔开，第三个值是列表变量（0=文章列表,1=显示正文,2=图片，可自定义）， 分类与分类之间用 回车</span>
-->
          <table class="tb" style="width:400px;">
              <tbody> 
              <tr>
                  <th>ID标识</th>
                  <th>分类名称</th>
                  <th width="60"></th>
              </tr>
              </tbody>
              <tbody id="attr_area_box">
              <?php
			  $page['info']['typesetting']=isset($page['info']['typesetting'])?$page['info']['typesetting']:'[]';
			  $page['info']['typesetting']=helper::json_decode_cn($page['info']['typesetting'],1);
			  if(!is_array($page['info']['typesetting'])) $page['info']['typesetting']=array();
			  ?>
              <?php $i=0;foreach($page['info']['typesetting'] as $b){ $i++;?>
              <tr>		
                  <td><input type="text" class="ipt" name="typesetting[value][]" style="width:80px;min-width:80px;" value="<?php echo $b['value']; ?>"></td>		
                  <td><input type="text" class="ipt" name="typesetting[txt][]" style="width:80px;min-width:80px;" value="<?php echo $b['txt']; ?>"></td>		
                  <td class="controltd"><?php if($i!=1){ ?><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a><?php }?></td>	
              </tr>
              <?php }?>
              <?php if(count($page['info']['typesetting'])==0){ ?>
              <tr>		
                  <td><input type="text" class="ipt" name="typesetting[value][]" style="width:80px;min-width:80px;" value="0"></td>		
                  <td><input type="text" class="ipt" name="typesetting[txt][]" style="width:80px;min-width:80px;" value="默认分类"></td>		
                  <td class="controltd"></td>	
              </tr>
			  <?php }?>
              </tbody>
              <tbody>
              	   <tr><td colspan="3"><span class="l">&nbsp;&nbsp;<input type="button" class="but2" value="添加一个分类" onclick="attr_add();"></span></td></tr>
       		  </tbody>
          </table>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">排序：</td>
        <td  class="alignleft">
        <input type="text" size="10" class="ipt"  id="sorder"   name="sorder" value="<?php echo $page['info']['sorder']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td  width="100">封面：</td>
        <td  class="alignleft">
        <div class="l">
            <input type="text" class="ipt" id="special_img" name="special_img" value="<?php echo $page['info']['special_img']; ?>"/>
        </div>
        <div class="l" style="margin:0px 10px;" id="special_img_img">
        <?php echo $page['info']['special_img']?'<img src="'.$page['info']['special_img'].'" width=24 height=24>':'' ?>
        </div>
        <div class="l" >
           <script>create_upload_iframe('{"func":"callback_upload22","Eid":"special_img"}');</script>
        </div>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">banner横幅：</td>
        <td  class="alignleft">
        <div class="l">
            <input type="text" class="ipt" id="special_banner" name="special_banner" value="<?php echo $page['info']['special_banner']; ?>"/>
        </div>
        <div class="l" style="margin:0px 10px;" id="special_banner_img">
        <?php echo $page['info']['special_img']?'<img src="'.$page['info']['special_img'].'" width=24 height=24>':'' ?>
        </div>
        <div class="l" >
           <script>create_upload_iframe('{"func":"callback_upload","Eid":"special_banner"}');</script>
        </div>

        </td>      
    </tr>
	<tr>
        <td  width="100">模版：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="template"   name="template" value="<?php echo $page['info']['template']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td>专题介绍：</td>
        <td style="position:relative;">
        <div style="position:relative;">
        <textarea name="special_desc" id="special_desc" style="width:100%; height:300px;" ><?php echo htmlspecialchars($page['info']['special_desc']); ?></textarea>
          <script>$("#special_desc").xheditor({"skin":"nostyle"});</script>
        </div>
        </td>
    </tr>
    
    <tr>
        <td  width="100">审核状态：</td>
        <td  class="alignleft">
			<input id="audit" name="audit" type="radio" value="0"  <?php if($page['info']['audit']==0){echo 'checked';} ?>/>未审核
			<input id="audit" name="audit" type="radio" value="1"  <?php if($page['info']['audit']==1){echo 'checked';} ?>/>已审核
        </td>      
    </tr>
    
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('special/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/head.php"); ?>