<?php require(dirname(__FILE__)."/../common/head.php"); ?>

<?php 
if(!isset($page['info'])){
	foreach($page['model_fields2'] as $f){
		$page['info'][$f['field_name']]=isset($f['setting']['default_value'])?$f['setting']['default_value']:'';
		
	}
	
	$page['info']['info_title']='';
	$page['info']['info_id']='';
	$page['info']['info_img']='';
	$page['info']['info_img']='';
	$page['info']['info_attr_title']=array();
	$page['info']['info_attr_title']['color']='';
	$page['info']['info_attr_title']['bold']='';
	$page['info']['info_attr_limits']='';
	$page['info']['info_desc']='';
	$page['info']['info_jump_url']='';
	$page['info']['info_tags']='';
	$page['info']['create_time']=time();
	$page['info']['info_editor']=Yii::app()->admin_user->uname;
	$page['info']['info_from']='';
	$page['info']['info_comments']='';
	$page['info']['info_visitors']='';
	$page['info']['info_order']=50;
	$page['info']['info_type_game']='';
	$page['info']['audit']=1;
	$page['info']['flag_c']=0;
	$page['info']['flag_h']=0;
	$page['info']['flag_s']=0;
	$page['info']['flag_a']=0;
	$page['info']['flag_d']=0;
	$page['info']['info_py']='';
	$page['info']['info_extern']='{}';
	$page['info_relation_infos']=array();
	$page['resource_list']=array();

  
}
$select_mode=$this->get('select_mode');
$page['info']['info_extern']=helper::json_decode_cn($page['info']['info_extern'],1);
?>
<script>
//编辑器增加 nextpage 按钮
var allplugin={
	"nextpage":{c:'xheIcon nextpage22',t:'分页',s:'',e:function(){
		this.pasteHTML('<p class="pagebreak"></p>');
	}}
};

//预览
function preview(){
	var formpost=$("#formpost");
	var bakaction=formpost.attr("action");
	var newaction="/details/index?cate_id=<?php echo $page['cate_info']['cate_id']; ?>&info_id=88888888&preview=1";
	formpost.attr("action",newaction);
	formpost.attr("target","_blank");
	formpost.submit();
	formpost.attr("action",bakaction);
	formpost.attr("target","");
	return false;
}

//编辑器增加 nextpage 按钮
var allplugin={
	"nextpage":{c:'xheIcon nextpage22',t:'分页',s:'',e:function(){
		this.pasteHTML('<p class="pagebreak"></p>');
	}},
	"coder":coderPlugin.highlight
};

function get_pinyin(){
    var cname_py=$("#info_py");
	$.get("index.php?m=admin&c=info_category&a=get_pinyin&str="+encodeURI($("#info_title").val()),function(jsondata){
	    try{
		    var  data=$.evalJSON(jsondata);
			cname_py.val(data.str_py);
		}catch(e){
		    alert(e);	
		}
	})	
	
}
function del_resource(resource_id){
	try{
	$.get("index.php?m=admin&c=info_list&a=del_resource&cate_id=<?php echo $_GET['cate_id']; ?>&resource_id="+resource_id,function(data){
		//alert(data);
		C.alert.opacty({"title":"温馨提示","content":"文件已被删除"});
		setTimeout(function(){C.alert.opacty_close('')},1000);	   	
	})
	}catch(e){alert(e.message)}
}

function colorback(a){
	//alert(a);
	$("#title_color").val(a);
	$('#title_color').css({'background':a});
}
function ck_title_bold(){
    if($('#title_bold').val()==0){
		$('#title_bold').val(1);
		$('#info_title').css({'font-weight':'bold'});
	}else{
		$('#info_title').css({'font-weight':'100'});
		$('#title_bold').val(0);
	}	
}

function create_mode_relation(id,title,model_id){
	var repeat=0;
	$("#mode_relation_box>div").each(function(){
		if($(this).attr('data-id')==id && $(this).attr("data-model")==model_id){
			repeat=1;
			return;
		}
	})
	if(repeat==1){
		return false;
	}else{
		var code='<div class="mode_up" style="position:relative;padding:2px;" data-rid="'+rid+'" data-rtype="'+rtype+'">'+
			         '<input type=button class="but2" onclick="$(this).parent().remove();" style="position:absolute;left:450px;top:5px; cursor:pointer;" value="移除">'+	
					 '<li>'+
					 	'<div class=l>'+
					 		'排序：<input type="text" size="5"  name="relation_recommend[displayorder][]" value="50"> <span class=ccc>(类型：'+(rtype==1?'事件':'资讯')+'-ID'+rid+') </span>'+title+'<input type="hidden"   name="relation_recommend[rid][]" value="'+rid+'"  />'+
					 		'<input type="hidden"   name="relation_recommend[rtype][]" value="'+rtype+'"  />'+
						'</div>'+
					    '<div class=clear>'+
					    '</div>'+
					  '</li>'+
					 '</div>';		
		$('#mode_relation_box').append(code);
		return true;
	}
}


var modes=1;  //默认显示几条
var name_id=1;
function create_mode_up_resource(w,is_add_modes,resource_url,addcode,resource_order,resource_id){
	var framecode='';
	if(!resource_url) resource_url='';
	if(!addcode) addcode='';
	if(!resource_order)resource_order=50;
	//alert(framecode);
	var code='<li class="clearfix">'+
		     '    <div class="mode_up_r" style="position:relative;margin:5px;">'+
    		 '        <input type=button class="but2" onclick="'+addcode+'if(modes>0){$(this).parent().parent().remove();modes--;}" style="position:absolute;left:450px;top:5px; cursor:pointer;" value="移除">'+
			 '        <div class="l">'+
			 '            <div class=l>'+
			 '               <input type="text" size=5 class="ipt"  name="resource_data[resource_order][]" "  value="'+resource_order+'" />'+ 
			 '               <input type="hidden"  name="resource_data[resource_id][]"   value="'+resource_id+'" />'+ 
			 '               <input type="text"  name="resource_data[resource_url][]" id="resource_url'+name_id+'" class=ipt value="'+resource_url+'" />'+ 
			 '		      </div>'+
			 '        <div class=l id="ff'+name_id+'">'+
						framecode+
			 '        </div>'+
			 '        <div class=l> '+ 
			 '		      <span style="margin:10px;" id="ssimg'+name_id+'">'+
			              (resource_url?'<a href="'+resource_url+'" target=_blank><img src="'+resource_url+'" width=24 height=24/></a>':'')+
			 '			  </span>'+
			 '	      </div> '+
		     '        <div class=clear>'+
			 '        </div>'+
			 '    </div>'+
			 '</li>';
	if(w=='add'){
		if(is_add_modes=='no'){
		}else{
		modes++;
		}
		$('#mode_up_box_r').append(code);
		try{
		//alert('{"inner_box":"#ff'+name_id+'","func":"callback_upload22","id":"'+name_id+'","thumb":{"width":"300","height":"300"}}');
		//if(!resource_url){
			create_upload_iframe('{"inner_box":"#ff'+name_id+'","func":"callback_upload33","id":"'+name_id+'","thumb":{"width":"300","height":"300"},"water":1}');
		//}
		}catch(e){alert(e.message);}
		name_id++;
	}
}

function callback_upload33(ret){
	try{
		//alert(ret);
		var json=$.evalJSON(ret);
		var id=json.params.id;
		//alert(id);
		if(json.files.length<=0) {
			alert('上传失败');
			return false;
		}
		$("#resource_url"+id).val(json.files[0].original);
	    $("#ssimg"+id).html('<img src="'+json.files[0].original+'" width=24 height=24 />');
	}catch(e){
		alert('err:'+e.message);
	}
}

function get_select_info(id,title,model_id,model_name,cate_id){
	var repeat=0;
	$("#mode_relation_box>div").each(function(){
		if($(this).attr('data-id')==id && $(this).attr("data-model")==model_id){
			repeat=1;
			return;
		}
	})
	if(repeat==1){
		return false;
	}else{
		var code=''+
		'<div class="mode_up" style="position:relative;padding:2px;" data-id="'+id+'" data-model="'+model_id+'">'+
	    '<input type="button" class="but2" onclick="$(this).parent().remove();" style="position:absolute;left:450px;top:5px; cursor:pointer;" value="移除">'+
		'<li>'+
		' 	<div class=l>'+
		'		<input type="hidden"   name="relation_recommend[relation_id][]" value=""  />'+
		' 		排序：<input type="text" size="5"  name="relation_recommend[displayorder][]" value="50"> '+
		'		<select name="relation_recommend[type][]">'+
		'		<option value=0>相关推荐</option>'+
		' 			<option value=1 >相关搭配</option>'+
		' 		</select>  '+		
		'		<span class=ccc>(模型：'+model_name+')</span>'+
		' 		'+title+
		' 		<input type="hidden"   name="relation_recommend[info_id_related][]" value="'+id+'"  />'+
		'		<input type="hidden"   name="relation_recommend[model_id_related][]" value="'+model_id+'"  />'+
		'	</div>'+
		'    <div class=clear>'+
		'    </div>'+
		'  </li>'+
		' </div>'+
			'';
		 $('#mode_relation_box').append(code);
		 return true;
	}
}

function send_gettotal(cate_id){
    $.ajax({url:"index.php?m=admin&c=info_category&a=get_cate_total_info&cate_id="+cate_id,success: function(data){
			var json=$.evalJSON(data);
			$("#fei_"+json.cate_id,parent.cateleft_main.document).html(json.totals);
	}});	
}
<?php foreach($page['parent_cate_arr'] as $cate){?>
send_gettotal(<?php echo $cate['cate_id']; ?>);
<?php }?>
</script>


<div class="main mhead">
    <div class="snav">内容中心 »  
    <?php foreach($page['parent_cate_arr'] as $cate){?>
             <?php echo $cate['cname']; ?> »
    <?php }?>
    <?php echo $page['cate_info']['model_name']; ?>管理 </div>
</div>
<div class="main mbody">
<form id="formpost" method="post" action="<?php echo $this->createUrl('info/update'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&p=<?php echo $_GET['p'];?>">
<input type="hidden" id="cate_id" name="cate_id" value="<?php echo $page['cate_info']['cate_id']; ?>" />
<input type="hidden" id="info_id" name="id" value="<?php echo $page['info']['info_id']; ?>" />
<script>
$(document).ready(function(){
	C.tabs(
	{"style":{		//选项卡样式
	"sclass":"current"	//选中
	},
	"params":[{"nav":"#tabbtn01","con":"#tab001"},{"nav":"#tabbtn02","con":"#tab002"},{"nav":"#tabbtn03","con":"#tab003"}
	,{"nav":"#tabbtn04","con":"#tab004"}
	]}
	)
})
</script>
<div class="tab_table">
   <div class="title01"><?php echo $page['info']['info_id']?'修改'.$page['cate_info']['model_name']:'添加'.$page['cate_info']['model_name']; ?></div>
   <div class="btn_box">
        <a href="javascript:void(0);" class="current" id="tabbtn01">基本信息</a>
        <a href="javascript:void(0);"  id="tabbtn02" <?php if(isset($page['cate_info']['field_setting']['info_advance'])&&$page['cate_info']['field_setting']['info_advance']==1){ echo 'style="display:none;"';}?>>高级信息</a>
        <a href="javascript:void(0);"  id="tabbtn04" <?php if(isset($page['cate_info']['field_setting']['info_relation'])&&$page['cate_info']['field_setting']['info_relation']==1){ echo 'style="display:none;"';}?>>相关推荐</a>
        <a href="javascript:void(0);"  id="tabbtn03" <?php if(isset($page['cate_info']['field_setting']['info_resource'])&&$page['cate_info']['field_setting']['info_resource']==1){ echo 'style="display:none;"';}?>>资源和图片</a>
   </div>
</div>
<table class="tb3"  id="tab001">
    
    <tr <?php if(isset($page['cate_info']['field_setting']['info_title'])&&$page['cate_info']['field_setting']['info_title']==1){ echo 'style="display:none;"';}?>>
        <td  width="100">标题：</td>
        <td  class="alignleft" style="position:relative;"><input type="text"  style="width:400px;<?php if($page['info']['info_attr_title']['bold']==1){echo 'font-weight:bold;';} ?>" class="ipt"  id="info_title"   name="info_title" value="<?php echo htmlspecialchars(stripslashes($page['info']['info_title'])); ?>"/> 
        <span <?php if(isset($page['cate_info']['field_setting']['info_attr_title'])&&$page['cate_info']['field_setting']['info_attr_title']==1){ echo 'style="display:none;"';}?>>
        <img style="display:none;" src="<?php echo(Yii::app()->params['basic']['cssurl']); ?>admin/img/colour.png" onclick="colorpicker('title_colorpanel','colorback');" />
        <span id="title_colorpanel" style="position:absolute; top:30px;" class="colorpanel"></span>
        <select onchange="this.style.background=this.value;" id="title_color" name="info_attr_title[color]" style="background:<?php echo $page['info']['info_attr_title']['color']; ?>">
            <option value="" style="background:white">字体颜色</option>
            <option value="red" <?php if($page['info']['info_attr_title']['color']=='red')echo 'selected'; ?> style="background:red">红色</option>
            <option value="blue" <?php if($page['info']['info_attr_title']['color']=='blue')echo 'selected'; ?> style="background:blue">蓝色</option>
            <option value="green" <?php if($page['info']['info_attr_title']['color']=='green')echo 'selected'; ?> style="background:green">绿色</option>
            <option value="deeppink" <?php if($page['info']['info_attr_title']['color']=='deeppink')echo 'selected'; ?> style="background:deeppink">深粉色</option>
        </select>
        <input type="hidden"  size="5" id="title_bold" name="info_attr_title[bold]" value="<?php echo $page['info']['info_attr_title']['bold']; ?>"/>
        <img src="<?php echo(Yii::app()->params['basic']['cssurl']); ?>admin/img/bold.png" onclick="ck_title_bold()" />
        </span>
        <span>
        <label <?php if(isset($page['cate_info']['field_setting']['flag_c'])&&$page['cate_info']['field_setting']['flag_c']==1) echo 'style="display:none;"';?>><input type="checkbox"  id="flag_c"  name="flag_c"   value="1" <?php if($page['info']['flag_c']==1)echo 'checked'; ?> /> 推荐 </label>
        <label <?php if(isset($page['cate_info']['field_setting']['flag_h'])&&$page['cate_info']['field_setting']['flag_h']==1) echo 'style="display:none;"';?>><input type="checkbox"  id="flag_h"  name="flag_h"   value="1" <?php if($page['info']['flag_h']==1)echo 'checked'; ?> /> 头条 </label>
        <label <?php if(isset($page['cate_info']['field_setting']['flag_s'])&&$page['cate_info']['field_setting']['flag_s']==1) echo 'style="display:none;"';?>><input type="checkbox"  id="flag_s"  name="flag_s"   value="1" <?php if($page['info']['flag_s']==1)echo 'checked'; ?> /> 滚动 </label>
        <label <?php if(isset($page['cate_info']['field_setting']['flag_a'])&&$page['cate_info']['field_setting']['flag_a']==1) echo 'style="display:none;"';?>><input type="checkbox"  id="flag_a"  name="flag_a"   value="1" <?php if($page['info']['flag_a']==1)echo 'checked'; ?> /> 特推 </label>
        <label <?php if(isset($page['cate_info']['field_setting']['flag_d'])&&$page['cate_info']['field_setting']['flag_d']==1) echo 'style="display:none;"';?>><input type="checkbox"  id="flag_d"  name="flag_d"   value="1" <?php if($page['info']['flag_d']==1)echo 'checked'; ?> /> 幻灯 </label>
        </span>
        </td>      
    </tr>
    
    
    <tr  style="display:none;" <?php if(isset($page['cate_info']['field_setting']['audit'])&&$page['cate_info']['field_setting']['audit']==1){ echo 'style="display:none;"';}?>>
        <td  width="100">审核：</td>
        <td  class="alignleft">
        <label><input type="radio"   name="audit"   value="0" <?php if($page['info']['audit']==0)echo 'checked'; ?> /> 未审核 </label>
        <label><input type="radio"   name="audit"   value="1" <?php if($page['info']['audit']==1)echo 'checked'; ?> /> 已审核 </label>
        </td>     
    </tr>
    
    
    
    <?php $page['cate_info']['extern_content']=json_decode($page['cate_info']['extern_content'],1); 
	if(!is_array($page['cate_info']['extern_content'])) $page['cate_info']['extern_content']=array();
	?>
    <?php foreach($page['cate_info']['extern_content'] as $f){if(!isset($page['info']['info_extern'][$f['name']]))$page['info']['info_extern'][$f['name']]='';?>
    <tr>
        <td><?php echo $f['label']; ?>：</td>
        <td style="position:relative;">
        <div style="position:relative;">
         <?php echo form_type_code::get_html(array('type'=>$f['type'],'default_value'=>$page['info']['info_extern'][$f['name']],'form_name'=>'extern__'.$f['name'],'ini_value'=>$f['value'])); ?>
        </div>
        </td>
    </tr>
    <?php }?>
    
    
    
    <?php foreach($page['model_fields2'] as $f){?>
    
    <tr <?php if(isset($page['cate_info']['field_setting'][$f['field_name']])&&$page['cate_info']['field_setting'][$f['field_name']]==1){echo 'style="display:none;"';} ?>>
        <td><?php echo $f['field_txt']; ?>：</td>
        <td style="position:relative;">
        <div style="position:relative;">
         <?php echo form_type_code::get_html(array('type'=>$f['form_type'],'default_value'=>$page['info'][$f['field_name']],'form_name'=>$f['field_name'],'ini_value'=>isset($f['setting']['ini_value'])?$f['setting']['ini_value']:'','linkage_type_id'=>$f['linkage_type_id'],'linkage_attr'=>array('parent_id'=>$f['linkage_select_parent_id'],'select_num'=>$f['linkage_select_selectnum']))); ?>
         <?php echo $f['tips']; ?>
        </div>
        </td>
    </tr>
    <?php }?>
    
    <tr <?php if(isset($page['cate_info']['field_setting']['info_order'])&&$page['cate_info']['field_setting']['info_order']==1){ echo 'style="display:none;"';}?>>
        <td  width="100">排序：</td>
        <td  class="alignleft"><input type="text" class="ipt"  name="info_order"  value="<?php echo $page['info']['info_order']; ?>"/></td>      
    </tr>
    
    
          
</table>
<table class="tb3" id="tab002" style="display:none;">
    <tr <?php if(isset($page['cate_info']['field_setting']['create_time'])&&$page['cate_info']['field_setting']['create_time']==1){ echo 'style="display:none;"';}?>>
        <td  width="100">创建时间：</td>
        <td  class="alignleft"><input type="text" class="ipt" id="create_time"  name="create_time" value="<?php echo date('Y-m-d H:i:s',$page['info']['create_time']);?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/> </span></td>     
    </tr>
    <tr <?php if(isset($page['cate_info']['field_setting']['info_tags'])&&$page['cate_info']['field_setting']['info_tags']==1){ echo 'style="display:none;"';}?>>
        <td  width="100">标签：</td>
        <td  class="alignleft"><input type="text" class="ipt" id="info_tags"  name="info_tags" onblur="this.value=this.value.replace(/，/g,',')"  value="<?php echo $page['info']['info_tags']; ?>"/> <span>  <input type="button" class="but2" value="提取" onclick="get_tags($('#info_title').val(),'#info_tags');" />* 多个标签用逗号分开，利于检索</span></td>     
    </tr>
    
    <tr <?php if(isset($page['cate_info']['field_setting']['info_py'])&&$page['cate_info']['field_setting']['info_py']==1){ echo 'style="display:none;"';}?>>
        <td  width="100">拼音别名：</td>
        <td  class="alignleft"><input type="text"  class="ipt" id="info_py"  name="info_py"  value="<?php echo $page['info']['info_py']; ?>"/> <span> <input type="button" class="but2" value="获取拼音" onclick="get_pinyin()" /> * 不要太长，尽量用核心词语的拼音或英文 (用于url显示，对seo有利，注意同一分类下不能重复) </span></td>     
    </tr>
    <tr>
        <td  width="100">跳转地址：</td>
        <td  class="alignleft"><input type="text" class="ipt"  name="info_jump_url"  value="<?php echo $page['info']['info_jump_url']; ?>"/> 
        <span> * 该地址如果填写了其它URL，则点击标题链接时候会直接跳转到该URL</span>
        </td>      
    </tr>  
</table>
<table class="tb3" id="tab004">
    <tr>
        <td  width="100">数据列表：</td>
        <td  class="alignleft">
          <div class="mt10">
        	<a href="javascript:void(0);" class="but2" onclick="window.open('<?php echo $this->createUrl('infoFrame/index');?>?select_mode=1','win1','height=500, width=1000, top=100, left=450, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no')">选择信息</a>  
          </div>
          <ul id="mode_relation_box" style="width:700px; height:200px;overflow:auto; border:1px solid #ccc;margin-top:10px;">
             <?php
             foreach($page['info_relation_infos'] as $r){?>
          	  <div class="mode_up" style="position:relative;padding:2px;" data-id="<?php echo  $r['info_id_related'];?>" data-model="<?php echo  $r['model_id_related'];?>">		         
				 <li>
				 	<input type="button" class="but2" onclick="$(this).parent().remove();" style="position:absolute;left:450px;top:5px; cursor:pointer;" value="移除">
				 	<div class=l>
				 		<input type="hidden"   name="relation_recommend[relation_id][]" value="<?php echo  $r['relation_id'];?>"  />
				 		排序： 
				 		<input type="text" size="5"  name="relation_recommend[displayorder][]" value="<?php echo  $r['displayorder'];?>"> 
				 		<select name="relation_recommend[type][]">
				 		<option value=0 <?php if($r['type']==0)echo 'selected';?>>相关推荐</option>
				 		<option value=1 <?php if($r['type']==1)echo 'selected';?>>相关搭配</option>
				 		</select> 
				 		<span class=ccc>(模型：<?php echo  $r['model_name'];?>)</span>
				 		<?php echo  $r['info_title'];?>
				 		<input type="hidden"   name="relation_recommend[info_id_related][]" value="<?php echo  $r['info_id_related'];?>"  />
				 		<input type="hidden"   name="relation_recommend[model_id_related][]" value="<?php echo  $r['model_id_related'];?>"  />
					</div>
				    <div class=clear>
				    </div>
				  </li>
				 </div>
          	<?php }?>
          </ul> 
                 
        </td>      
    </tr>
</table>
<style>
ul.resourcelistul{list-style:decimal;}
ul.resourcelistul li{ list-style:	decimal;}
</style>
<table class="tb3" id="tab003" style="display:none;">
     
    
    <tr>
        <td  width="100">上传：</td>
        <td  class="alignleft">
            <ul id="mode_up_box_r" class="resourcelistul">
<script>
$(document).ready(function (){
	try{
	modes=<?php echo count($page['resource_list']); ?>;
	var rs=[];
	var rid=[];
	var rsorder=[];
	<?php $i=0;foreach($page['resource_list'] as $r3){$i++; ?>
     rs.push("<?php echo $r3['resource_url']; ?>");
	 rid.push("<?php echo $r3['resource_id']; ?>");
	 rsorder.push("<?php echo $r3['resource_order']; ?>");
	<?php }?>
	var addcode='';
	for(var j=1;j<=modes;j++){
	addcode="";
	create_mode_up_resource('add','no',rs[j-1],addcode,rsorder[j-1],rid[j-1]);
	}
	}catch(e){alert(e.message)}
})
</script>
          
            
            </ul>
		<div style="padding:10px 5px;"><input type="button" class="but2"  onClick="create_mode_up_resource('add')" value="新增上传"></div>
        </td>      
    </tr>
    
    
</table>
<table class="tb3">
    <tr>
       <td width="100"></td>
       <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> 
       <?php if(!isset($page['cate_info']['field_setting']['info_preview'])||$page['cate_info']['field_setting']['info_preview']!=1){ ?>
       <input type="button" class="but" id="subtn" value="预览" onclick="preview();" /> 
       <?php }?>
        <input type="button" class="but" value="返回" onClick="window.location='<?php echo $this->createUrl('info/index');?>?cate_id=<?php echo $_GET['cate_id']; ?>&p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>

<?php require(dirname(__FILE__)."/../common/foot.php"); ?>