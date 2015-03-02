<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php error_reporting(E_ALL & ~E_NOTICE);?>

<?php 
//处理未定义的变量
if(!isset($page['info'])){
	$page['info']['model_id']=isset($page['get']['model_id'])?$page['get']['model_id']:'';
	$page['info']['cate_id']='';
	$page['info']['cname']='';
	$page['info']['cname_py']='';
	$page['info']['nav_show']=0;
	$page['info']['highlight']=0;
	$page['info']['recommend']=0;
	$page['info']['cname_py']='';
	$page['info']['cname_en']='';
	$page['info']['corder']=50;
	$page['info']['cimg']='';
	$page['info']['ctitle']='';
	$page['info']['ckey']='';
	$page['info']['cdesc']='';
	$page['info']['cbody']='';
	$page['info']['cjump_url']='';
	$page['info']['single']=0;
	$page['info']['jump_first_cate']='';
	$page['info']['getcateids']='';
	$page['info']['cate_host']=isset($page['parentcate']['cate_host'])?($page['parentcate']['cate_host']):'';
	$page['info']['host_is_top']=isset($page['parentcate']['host_is_top'])?($page['parentcate']['host_is_top']):'';
	
	$page['info']['ad_area_id']=isset($page['parentcate']['ad_area_id'])?($page['parentcate']['ad_area_id']):'';
	$page['info']['csetting']=array();
	$page['info']['csetting']['templates_display']=isset($page['parentcate']['csetting']['templates_display'])?($page['parentcate']['csetting']['templates_display']):'';
	$page['info']['csetting']['templates_list']=isset($page['parentcate']['csetting']['templates_list'])?($page['parentcate']['csetting']['templates_list']):'';
	$page['info']['csetting']['templates_detail']=isset($page['parentcate']['csetting']['templates_detail'])?($page['parentcate']['csetting']['templates_detail']):'';
	$page['info']['csetting']['pagesize']=isset($page['parentcate']['pagesize'])?intval($page['parentcate']['pagesize']):12;
	$page['info']['csetting']['list_rewrite']=isset($page['parentcate']['csetting']['list_rewrite'])?($page['parentcate']['csetting']['list_rewrite']):'';
	$page['info']['csetting']['detail_rewrite']=isset($page['parentcate']['csetting']['detail_rewrite'])?($page['parentcate']['csetting']['detail_rewrite']):'';
	
	$page['info']['field_setting']=isset($page['parentcate']['field_setting'])?($page['parentcate']['field_setting']):'';
	
	$page['info']['extern_content']=isset($page['parentcate']['extern_content'])?($page['parentcate']['extern_content']):'';

}
?>

<script>
function callback_upload22(ret){
	try{
		//alert(ret);
		var json=$.evalJSON(ret);
		if(json.files.length<=0) {
			alert('上传失败');
			return false;
		}
		$("#cimg").val(json.files[0].original);
		$("#showcimg").html('<img src="'+json.files[0].original+'" width=24 height=24 />');
	}catch(e){
		alert('err:'+e.message);
	}
}
function get_pinyin(){
    var cname_py=$("#cname_py");
	$.get("<?php echo $this->createUrl('infoCategory/getPinyin');?>?str="+encodeURI($("#cname").val()),function(jsondata){
	    try{
		    var  data=$.evalJSON(jsondata);
			cname_py.val(data.str_py);
		}catch(e){
		    alert(e);	
		}
	})	
	
}
function openfile(id){
    window.open('<?php echo $this->createUrl('fileList/index'); ?>?element_id='+id,'win1','height=400, width=700, top=100, left=450, toolbar=no, menubar=no, scrollbars=no, resizable=no,location=n o, status=no')
}
function __backfile(file,elementid){
	$("#"+elementid).val(file);
}
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

$(function(){
	$.get("<?php echo $this->createUrl('fileList/getTplList');?>",function(jsonstr){
		var jsondata=eval('('+jsonstr+')');
		var optionstr='';
		for(var i=0;i<jsondata.list.length;i++){
			var nowval='<?php echo $page['info']['csetting']['templates_list']; ?>';
			optionstr+='<option value='+jsondata.list[i].file+' '+(nowval==jsondata.list[i].file?'selected':'')+' >'+jsondata.list[i].name+'</option>';
		}
		$("#t_list_se").append(optionstr);
	})
	
	
})
</script>

<script>
$(document).ready(function(){
	C.tabs(
	{"style":{		//选项卡样式
	"sclass":"current"	//选中
	},
	"params":[
	{"nav":"#conbtn1","con":"#con001"},
	{"nav":"#conbtn2","con":"#con002"},
	{"nav":"#conbtn3","con":"#con003"},
	{"nav":"#conbtn4","con":"#con004"},
	{"nav":"#conbtn5","con":"#con005"},
	{"nav":"#conbtn6","con":"#con006"}
	]}
	)
})
</script>
<div class="main mhead">
    <div class="snav">内容中心 » 资讯分类</div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('infoCategory/update');?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['cate_id']; ?>" />
<div class="tab_table">
   <div class="title01"><?php echo isset($page['info'])=='edit_info_category'?'修改栏目':'添加栏目' ?></div>
   <div class="btn_box">
        <a href="#" id="conbtn1" class="current" >基本设置</a>
        <a href="#" id="conbtn2" >高级设置</a>
        <a href="#" id="conbtn3" >模版设置</a>
        <a href="#" id="conbtn4" >参数设置</a>
        <a href="#" id="conbtn5"  >seo设置</a>
        <a href="#" id="conbtn6"  >栏目介绍</a>
   </div>
</div>
<div id="e_box">
<table class="tb3" id="con001" width="100%">
    <tr>
        <td  width="120">选择模型：</td>
        <td  class="alignleft">
        <select id="model_id" name="model_id">
            <?php echo $this->get_option(array('table_name'=>'model','id_field_name'=>'model_id','txt_field_name'=>'model_name','select_value'=>$page['info']['model_id'],'wheresql'=>' where model_type=0 and parent_model_id=0 ')); ?>
		</select></td>      
    </tr><tr>
        <td  width="100">上级栏目：</td>
        <td  class="alignleft"><select id="parent_id" name="parent_id">
        <option value="0">≡ 作为一级栏目 ≡</option>
		<?php echo $page['categorys']; ?></select></td>      
    </tr>
    <tr>
        <td  width="100">栏目名称：</td>
        <td  class="alignleft"><input type="text" class="ipt" id="cname" name="cname" value="<?php echo $page['info']['cname']; ?>"/></td>      
    </tr>
    <tr>
        <td  width="100">url目录：</td>
        <td  class="alignleft"><input type="text" class="ipt" id="cname_py" name="cname_py"  value="<?php echo $page['info']['cname_py']; ?>"/> <input type="button" class="but2" value="获取拼音" onclick="get_pinyin()" /> <font> * 同一个域名下url目录名最好不要重复</font></td>      
    </tr>
    <tr>
        <td  width="100">栏目别名：</td>
        <td  class="alignleft"><input type="text" class="ipt" id="cname_en" name="cname_en"  value="<?php echo $page['info']['cname_en']; ?>"/> </td>      
    </tr>
    <tr>
        <td  width="100">导航：</td>
        <td  class="alignleft">
        <label>显示 <input type="radio" class="ipt" id="nav_show" name="nav_show"  value="1" <?php echo $page['info']['nav_show']?'checked':''; ?>/></label>
        <label>隐藏 <input type="radio" class="ipt" id="nav_show" name="nav_show" value="0" <?php echo $page['info']['nav_show']?'':'checked'; ?>/></label>
        </td>      
    </tr>
    <tr>
        <td  width="100">单篇介绍：</td>
        <td  class="alignleft">
        <label>是 <input type="radio" class="ipt" id="single" name="single"  value="1"  <?php echo $page['info']['single']?'checked':''; ?>/></label>
        <label>否 <input type="radio" class="ipt" id="single" name="single" value="0" <?php echo $page['info']['single']?'':'checked'; ?>/></label>
        <label><input type="checkbox" value="1" name="for_all_child_single" /> 应用于所有下级分类<span class=ccc>（csetting）</span></label>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">排序：</td>
        <td  class="alignleft"><input type="text" class="ipt" id="corder" name="corder"  value="<?php echo $page['info']['corder']; ?>"/></td>      
    </tr>
    <tr>
        <td  width="100">栏目封面：</td>
        <td  class="alignleft">
        <div class="l">
            <input type="text" class="ipt" id="cimg" name="cimg" value="<?php echo $page['info']['cimg']; ?>"/>
        </div>
        <div class="l" style="margin:0px 10px;" id="cimg_span">
        <?php echo $page['info']['cimg']?'<img src="'.$page['info']['cimg'].'" width=24 height=24>':'' ?>
        </div>
        <div class="l" >
           <script>create_upload_iframe('{"func":"callback_upload","Eid":"cimg"}');</script>
        </div>
        
        </td>      
    </tr>
    
</table>
<table class="tb3" id="con002" style="display:none;">
    <tr>
        <td  width="120">链接：</td>
        <td  class="alignleft">
        <input type="text" class="ipt" id="cjump_url" name="cjump_url" value="<?php echo $page['info']['cjump_url']; ?>"/>手工填写（优先）   
        </td>      
    </tr>
    <tr>
        <td  width="120">链接：</td>
        <td  class="alignleft">
        <label><input <?php echo $page['info']['jump_first_cate']==1?'checked':''; ?> type="checkbox" value="1" name="jump_first_cate" /> 跳转到第一个子分类</label> 
        </td>      
    </tr>
    <tr>
        <td  width="120">绑定域名：</td>
        <td  class="alignleft">
        <input type="text" class="ipt" id="cate_host" name="cate_host" value="<?php echo $page['info']['cate_host']; ?>"/> 
        <label><input type="checkbox" value="1" name="for_child_cate_host" /> 应用于子分类</label>
        <label><input type="checkbox" value="1" name="for_all_child_cate_host" /> 应用于所有下级分类</label>
        
         （需加 http://，一级或二级域名的根网址）
        </td>      
    </tr>
    <tr>
        <td  width="120">域名作为该分类url：</td>
        <td  class="alignleft">
        <input type="checkbox" id="host_is_top" value="1" name="host_is_top" <?php if($page['info']['host_is_top']==1){echo 'checked';} ?> />是的  （针对绑定了域名的情况下）
        </td>      
    </tr>
    <tr>
        <td  width="120">绑定广告位：</td>
        <td  class="alignleft"><select id="ad_area_id" name="ad_area_id">
        <option value="0">--选择--</option>
          <?php echo $this->get_option(array('table_name'=>'ad_area','id_field_name'=>'area_id','txt_field_name'=>'area_name','select_value'=>$page['info']['ad_area_id'])); ?>
        </select><label><input type="checkbox" value="1" name="for_child_ad_area_id" /> 应用于子分类<span class=ccc></span><span class="red"></span></label></td>      
    </tr>
    <tr>
        <td>获取指定栏目的内容</td>
        <td  class="alignleft"><input type="text" class="ipt" id="getcateids" name="getcateids" value="<?php echo $page['info']['getcateids']; ?>"/> 填写栏目的ID，多个请用英文逗号隔开，不同的模型无效 <span class="red">请按要求填写，否则会出现错误</span></td>      
    </tr>
    <tr>
        <td>关联栏目：</td>
        <td  class="alignleft"><select id="relation_cate_id" name="relation_cate_id">
        <option value="0">≡ 所有顶级栏目 ≡</option>
		<?php echo $page['categorys2']; ?></select> 
<label><input type="checkbox" value="1" name="for_child_relation_cate_id" /> 应用于子分类</label>
<label><input type="checkbox" value="1" name="for_all_child_relation_cate_id" /> 应用于所有下级分类</label>
</td>      
    </tr>
	<tr>
		<td>是否高亮</td>
		<td  class="alignleft">
		<label> 是 <input type="radio" class="ipt" id="highlight" name="highlight"  value="1" <?php echo $page['info']['highlight']?'checked':''; ?>/></label>
        <label> 否 <input type="radio" class="ipt" id="highlight" name="highlight" value="0" <?php echo $page['info']['highlight']?'':'checked'; ?>/></label>
		</td>
	</tr>
    <tr>
		<td>是否推荐</td>
		<td  class="alignleft">
		<label> 是 <input type="radio" class="ipt" id="recommend" name="recommend"  value="1" <?php echo $page['info']['recommend']?'checked':''; ?>/></label>
        <label> 否 <input type="radio" class="ipt" id="recommend" name="recommend" value="0" <?php echo $page['info']['recommend']?'':'checked'; ?>/></label>
		</td>
	</tr>
    
    
</table>   
<table class="tb3" id="con003" style="display:none;">
    <tr>
        <td  width="120">封面模版：</td>
        <td  class="alignleft">
        <input id="templates_display" name="csetting[templates_display]" type="text" class="ipt"    value="<?php echo isset($page['info']['csetting']['templates_display'])?$page['info']['csetting']['templates_display']:''; ?>"/> <input type="button" class="but2" value=" 浏览 " onclick="openfile('templates_display')" />
        </td>      
    </tr>
    <tr>
        <td  width="100">列表样式：</td>
        <td  class="alignleft">
        
        <input id="templates_list" name="csetting[templates_list]" type="hidden" class="ipt"    value="<?php echo isset($page['info']['csetting']['templates_list'])?$page['info']['csetting']['templates_list']:''; ?>"/> 
        <input type="hidden" class="but2" value=" 浏览 " onclick="openfile('templates_list')"/> <span>
        <select id="t_list_se" onchange="$('#templates_list').val(this.value);">
    		<option value=''>--选择风格--</option>
    	</select>
         * 比如图文列表，普通新闻列表，图片列表等</span>     
    	
    	
    	</td> 
    </tr>
    <tr>
        <td  width="100">详细模版：</td>
        <td  class="alignleft">
        <input id="templates_detail" name="csetting[templates_detail]" type="text" class="ipt"    value="<?php echo isset($page['info']['csetting']['templates_detail'])?$page['info']['csetting']['templates_detail']:''; ?>"/> <input type="button" class="but2" value=" 浏览 " onclick="openfile('templates_detail')"/></td>      
    </tr>
    <tr>
        <td  width="100">列表url规则：</td>
        <td  class="alignleft"><select id="list_rewrite" name="csetting[list_rewrite]">
        <option value="0">--选择--</option>
          <?php echo helper::get_option(array('table_name'=>'rewrite','wheresql'=>' where rewrite_type=0 ','id_field_name'=>'rewrite_id','txt_field_name'=>'rewrite_name','txt_field_name2'=>'rewrite_example','select_value'=>$page['info']['csetting']['list_rewrite'])); ?>
        </select></td>      
    </tr>
    <tr>
        <td  width="100">详细页url规则：</td>
        <td  class="alignleft"><select id="detail_rewrite" name="csetting[detail_rewrite]">
        <option value="0">--选择--</option>
          <?php echo helper::get_option(array('table_name'=>'rewrite','wheresql'=>' where rewrite_type=1 ','id_field_name'=>'rewrite_id','txt_field_name'=>'rewrite_name','txt_field_name2'=>'rewrite_example','select_value'=>$page['info']['csetting']['detail_rewrite'])); ?>
        </select></td>      
    </tr>
    <tr>
        <td>分页大小：</td>
        <td  class="alignleft">
            <input type="text" class="ipt" size="10" id="pagesize" name="csetting[pagesize]" value="<?php echo $page['info']['csetting']['pagesize']; ?>"/>
        </td>      
    </tr>
    <tr>
        <td></td><td>
        <label><input type="checkbox" value="1" name="for_child_templates_same" /> 应用于子分类<span class=ccc>（csetting）</span></label>
        <label><input type="checkbox" value="1" name="for_all_child_templates_same" /> 应用于所有下级分类<span class=ccc>（csetting）</span></label>
        </td>
    </tr>
 </table>
 
 <table class="tb3" id="con004" style="display:none;">
    <tr>
        <td  width="120">勾选隐藏的参数：</td>
        <td  class="alignleft">
          <div style=" height:30px; line-height:30px;">温馨提示： 勾选了的话 该参数将不会在管理内容的时候出现哦</div>
          <div><label><input type="checkbox" onclick="check_all('.field_chk');"/> 全选/反选</label> </div>
         <?php $delfield=array('info_id');foreach($page['model_field'] as $r2){ if(in_array($r2['field_name'],$delfield)){continue;} ?>
          <div> <input class="field_chk" type="checkbox" <?php if(isset($page['info']['field_setting'][$r2['field_name']])&& $page['info']['field_setting'][$r2['field_name']]==1)echo 'checked'; ?> name="field_setting[<?php echo $r2['field_name']; ?>]" value="1" /> <strong><?php echo $r2['field_txt']; ?></strong>（<?php echo $r2['field_name']; ?>） </div>
		 <?php }?>
         
        
        </td>      
    </tr>
    <tr>
        <td></td><td>
        <label><input type="checkbox" value="1" name="for_child_field_setting_same" /> 应用于子分类<span class=ccc>（field_setting）</span></label>
        <label><input type="checkbox" value="1" name="for_all_child_field_setting_same" /> 应用于所有下级分类<span class=ccc>（field_setting）</span></label>
        </td>
    </tr>
    <tr>
        <td  width="120">扩展属性：</td>
        <td  class="alignleft">
          <div style=" height:30px; line-height:30px;">温馨提示：  编辑文档的时候 这些参数将会以json的格式保存在模型的info_extern 这个字段。</div>
          <table class="tb" style="width:880px;">
              <tbody> 
              <tr>
                  <th>属性文字</th>
                  <th>属性ID</th>
                  <th>表单类型</th>
                  <th title="值和显示的文字用英文逗号隔开，每个之间用请回车换行">属性预设值</th>
                  <th width="60"></th>
              </tr>
              </tbody>
              <tbody id="attr_area_box">
              <?php
			  $page['info']['extern_content']=isset($page['info']['extern_content'])?$page['info']['extern_content']:'[]';
			  $page['info']['extern_content']=json_decode($page['info']['extern_content'],1);
			  if(!is_array($page['info']['extern_content'])) $page['info']['extern_content']=array();
			  ?>
              <?php $i=0;foreach($page['info']['extern_content'] as $b){ $i++;?>
              <tr>		
                  <td><input type="text" class="ipt" name="extern_content[label][]" style="width:80px;min-width:80px;" value="<?php echo $b['label']; ?>"></td>		
                  <td><input type="text" class="ipt" name="extern_content[name][]" style="width:80px;min-width:80px;" value="<?php echo $b['name']; ?>"></td>		
                  <td>
                  <select name="extern_content[type][]">			
                      <?php echo vars::input_str(array('node'=>'form_types','type'=>'select','default'=>$b['type'],'name'=>'form_type')); ?>	
                  </select>
                  </td>		
                  <td><textarea class="ipt" name="extern_content[value][]" style="width:300px; height:40px; line-height:20px;"><?php echo $b['value']; ?></textarea></td>		
                  <td class="controltd"><?php if($i!=1){ ?><a href="javascript:void(0);" onclick="$(this).parent().parent().remove();">删除</a><?php }?></td>	
              </tr>
              <?php }?>
              <?php if(count($page['info']['extern_content'])==0){ ?>
              <tr>		
                  <td><input type="text" class="ipt" name="extern_content[label][]" style="width:80px;min-width:80px;" value=""></td>		
                  <td><input type="text" class="ipt" name="extern_content[name][]" style="width:80px;min-width:80px;" value=""></td>		
                  <td>
                  <select name="extern_content[type][]">			
                      <?php echo vars::input_str(array('node'=>'form_types','type'=>'select','default'=>'','name'=>'form_type')); ?>	
                  </select>
                  </td>		
                  <td><textarea class="ipt" name="extern_content[value][]" style="width:300px; height:40px; line-height:20px;"></textarea></td>		
                  <td class="controltd"></td>	
              </tr>
			  <?php }?>
              </tbody>
              <tbody>
              	   <tr><td colspan="5"><span class="l">&nbsp;&nbsp;<input type="button" class="but2" value="添加一个属性" onclick="attr_add();"></span></td></tr>
       		  </tbody>
          </table>
		
         
        
        </td>      
    </tr>
    
    <tr>
        <td></td><td>
        <label><input type="checkbox" value="1" name="for_child_extern_content_same" /> 应用于子分类<span class=ccc>（extern_content）</span></label>
        <label><input type="checkbox" value="1" name="for_all_child_extern_content_same" /> 应用于所有下级分类<span class=ccc>（extern_content）</span></label>
        </td>
    </tr>
 </table>
 <table class="tb3" id="con005" style="display:none;">
    <tr>
        <td  width="100">SEO标题：</td>
        <td  class="alignleft">
            <textarea id="ctitle" name="ctitle" class="ipt" style="width:400px; height:40px;"><?php echo $page['info']['ctitle']; ?></textarea>
        </td>      
    </tr>
    <tr>
        <td  width="100">SEO关键词：</td>
        <td  class="alignleft">
            <textarea id="ckey" name="ckey" class="ipt" style="width:400px; height:40px;"><?php echo $page['info']['ckey']; ?></textarea>
        </td>      
    </tr>
    <tr>
        <td  width="100">SEO描述：</td>
        <td  class="alignleft">
            <textarea id="cdesc" name="cdesc" class="ipt" style="width:400px; height:40px;"><?php echo $page['info']['cdesc']; ?></textarea>
        </td>      
    </tr>
   
    
    
    
</table>  
 <table class="tb3" id="con006" style="display:none;">
    <tr>
        <td  width="100">栏目介绍：</td>
        <td  class="alignleft">
            <div style="position:relative;margin-right:5px;">
            <textarea name="cbody" id="cbody" style="width:100%; height:400px;" ><?php echo htmlspecialchars(stripslashes($page['info']['cbody'])); ?></textarea>
              <script>var cbody=$("#cbody").xheditor({"skin":"nostyle"});</script>
              <span class="downhttpimgbtn" id="downbtn_cbody"><a href="javascript:void(0);" onclick="download_http_img('cbody');">下载远程图片</a></span>
              <span class="upbtn_box" id="upbtn_box"><script>load_editor_upload('cbody');</script></span>
            </div>
            
        </td>      
    </tr>
   
    
    
    
</table>   
</div>
<div>
<table class="tb3">
 <tr>
        <td width="100"></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('infoCategory/index');?>'" /></td>
    </tr>
    </table>
</div>

</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>