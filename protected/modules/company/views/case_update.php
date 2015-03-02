<?php include(dirname(__FILE__)."/head.php")?>
<?php 
if(!isset($page['info'])){
	$page['info']['info_id']='';
	$page['info']['info_title']='';
	$page['info']['color']='';
	$page['info']['stone_cate_id']='';
	$page['info']['city_id']='';	
	$page['info']['create_time']=time();
	$page['info']['info_img']='';
	$page['info']['info_body']='';
	$page['info']['stone_cate_id']='';
	$page['info']['main_stone']='';
	$page['info']['work_type']='';
	$page['info']['case_type']='';
	$page['info']['year']='';
	$page['info']['money']='';
	$page['resource_list']=array();
}
?>

<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>    
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title"><?php echo $page['info']['info_id']?'修改案例':'添加案例';?></div>
            <form name="form1" id="update_info_box" onsubmit="info_save();return false;">
            <input type="hidden" id="id" value="<?php echo $page['info']['info_id'];?>">
            <table class="tb_up mt10">
            	<tr>
            		<td width=100>标题</td>
            		<td>
            		<input type="text" value="<?php echo $page['info']['info_title'];?>" id="info_title" class="ipt size400">
            		</td>
            			
            	</tr>
            	<tr>
            		<td>封面</td>
            		<td>
            		<style>.img08 img{max-width:60px;max-height:60px;_width:60px;_height:60px;}</style>
		             <input type="hidden" id="info_img" value="<?php echo $page['info']['info_img'];?>" />
		             <span class="img08" id="info_img_span">
		             <?php if($page['info']['info_img']){?>
		             <a href="<?php echo $page['info']['info_img'];?>" target=_blank><img src="<?php echo $page['info']['info_img'];?>"></a>
		             <?php }?>
		             </span>
		    		 <script>create_upload_iframe('{"func":"callback_upload","Eid":"info_img"}');</script>
        			</td>  
            			
            	</tr>
            	<tr >
			        <td>地点：</td>
			        <td style="position:relative;">
			        <div style="position:relative;">
			          <span id="t_s_city_id">
			        </span>
			        <span id="t_s_city_id_load"></span> 
			           <script>cg_edit_sele_cc("<?php echo $page['info']['city_id'];?>","city_id[]","t_s_city_id","1","1",2);</script>
				        
					                 </div>
			        </td>
			    </tr>
			        
			    <tr >
			        <td>年份：</td>
			        <td style="position:relative;">
			        <div style="position:relative;">
			         <input type="text"  class="ipt"  id="year" name="year" value="<?php echo $page['info']['year'];?>" >                 </div>
			        </td>
			    </tr>
			        
			    <tr >
			        <td>工程报价：</td>
			        <td style="position:relative;">
			        <div style="position:relative;">
			         <input type="text"  class="ipt"  id="money" name="money" value="<?php echo $page['info']['money'];?>" >                 </div>
			        </td>
			    </tr>
			        
			    <tr>
			        <td>石种分类：</td>
			        <td style="position:relative;">
			        <div style="position:relative;">
			          <span id="t_s_stone_cate_id">
			        </span>
			        <span id="t_s_stone_cate_id_load"></span> 
			           <script>cg_edit_sele_cc("<?php echo $page['info']['stone_cate_id'];?>","stone_cate_id[]","t_s_stone_cate_id","17","0",0);</script>
				        
					                 </div>
			        </td>
			    </tr>
			    <tr>
            		<td width=100>主要石材：</td>
            		<td>
            		<input type="text" value="<?php echo $page['info']['main_stone'];?>" id="main_stone" class="ipt">
            		</td>
            			
            	</tr>
	
			    <tr >
			        <td>作品类型：</td>
			        <td style="position:relative;">
			        <div style="position:relative;">
			          <span id="t_s_work_type">
			        </span>
			        <span id="t_s_work_type_load"></span> 
			           <script>cg_edit_sele_cc("<?php echo $page['info']['work_type'];?>","work_type[]","t_s_work_type","20","0",0);</script>
				        
					                 </div>
			        </td>
			    </tr>
			        
			    <tr >
			        <td>工程类型：</td>
			        <td style="position:relative;">
			        <div style="position:relative;">
			          <span id="t_s_case_type">
			        </span>
			        <span id="t_s_case_type_load"></span> 
			           <script>cg_edit_sele_cc("<?php echo $page['info']['case_type'];?>","case_type[]","t_s_case_type","19","0",0);</script>
				        
					                 </div>
			        </td>
			    </tr>
            	<tr>
            		<td>详细介绍</td>
            		<td>
            	<div style="position:relative;margin-right:5px;">
                <textarea id="info_body"  name="info_body"  style="width:100%; height:300px;" ><?php echo stripcslashes(htmlspecialchars($page['info']['info_body']));?></textarea>
					<script>var info_body=$("#info_body").xheditor({skin:'nostyle',"tools":"full"});</script>
                    <span class="upbtn_box" id="upbtn_box"><script>load_editor_upload('info_body');</script></span>
                </div>
            			
            		</td>
            			
            	</tr>
            	
            	
            	<tr>
            		<td>
            			图片：
            		</td>
            		<td>
            			<ul id="mode_up_box_r" class="resourcelistul">
<script>
$(document).ready(function (){
	try{
	modes=<?php echo count($page['resource_list']); ?>;
	var rs=[];
	var rid=[];
	var rsorder=[];
	var mark=[];
	<?php $i=0;foreach($page['resource_list'] as $r3){$i++; ?>
     rs.push("<?php echo $r3['resource_url']; ?>");
	 rid.push("<?php echo $r3['resource_id']; ?>");
	 rsorder.push("<?php echo $r3['resource_order']; ?>");
	 mark.push("<?php echo $r3['mark']; ?>");
	<?php }?>
	var addcode='';
	for(var j=1;j<=modes;j++){
	addcode="";
	create_mode_up_resource('add','no',rs[j-1],addcode,rsorder[j-1],rid[j-1],mark[j-1]);
	}
	}catch(e){alert(e.message)}
})
</script>                    
            </ul>
		<div style="padding:10px 5px;"><input type="button" class="but2"  onClick="create_mode_up_resource('add')" value="新增上传"></div>
            		</td>
            	</tr>
            	
            	
            	<tr>
            		<td></td>
            		<td><input type=submit value="确定" class="btn06"> <input type="button" onclick="window.location='<?php echo $this->createUrl('infoCase/index');?>'" class="btn06" value="返回"></td>
            			
            	</tr>
            	
            	
            	
            
            </table>
            </form>
           
            
        </div>
    </div>

</div>

<?php include(dirname(__FILE__)."/foot.php")?>
<script>
function info_save(){
    var postdata=C.form.get_form("#update_info_box");
	//alert($.toJSON(postdata));	return;
	$.post("<?php echo $this->createUrl('infoCase/update');?>",postdata,function(restr){
	    try{
			var ret=eval("("+restr+")");
			if(ret.state<1){
			    alert(ret.msgwords);
				return false;	
			}else{
			    window.location='<?php echo $this->createUrl('infoCase/index');?>';	
			}
		}catch(e){alert(e.message+restr);}	
	})
	return false;
}



var modes=1;  //默认显示几条
var name_id=1;
function create_mode_up_resource(w,is_add_modes,resource_url,addcode,resource_order,resource_id,mark){
	var framecode='';
	if(!resource_url) resource_url='';
	if(!addcode) addcode='';
	if(!resource_order)resource_order=50;
	if(!mark) mark='';
	var markcode='<select class="rmark" name="resource_data[mark][]" id="resource_data[mark]['+name_id+']" ><option value=1 '+(mark==1?'selected':'')+'>项目照片</option><option value=2 '+(mark==2?'selected':'')+'>产品照片</option></select>';
	//alert(framecode);
	var code='<li class="clearfix">'+
		     '    <div class="mode_up_r" style="position:relative;margin:5px;">'+
    		 '        <input type=button class="but2" onclick="'+addcode+'if(modes>0){$(this).parent().parent().remove();modes--;}" style="position:absolute;left:350px;top:5px; cursor:pointer;" value="移除">'+
			 '        <div class="fl">'+
			 '            <div class=fl>'+
			 '				'+markcode+'			'+
			 '               <input type="hidden" size=5 class="ipt"  name="resource_data[resource_order][]" id="resource_data[resource_order]['+name_id+']"  value="'+resource_order+'" />'+ 
			 '               <input type="hidden"  name="resource_data[resource_id][]" id="resource_data[resource_id]['+name_id+']"   value="'+resource_id+'" />'+ 
			 '               <input type="hidden"  name="resource_data[resource_url][]" class="rrrurl'+name_id+'" id="resource_data[resource_url]['+name_id+']" class=ipt value="'+resource_url+'" />'+ 
			 '		      </div>'+
			 '        <div class=fl id="ff'+name_id+'">'+
						framecode+
			 '        </div>'+
			 '        <div class=fl> '+ 
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
		//$('.rmark').val(mark);
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
		$(".rrrurl"+id).val(json.files[0].original);
		if(json.files[0].original.match(/(\.doc)|(\.docx)|(\.xls)|(\.xlsx)/)){
			$("#ssimg"+id).html('<a style="display:inline-block;background:#fbf9f4;color:blue;padding:5px 2px;width:200px;overflow:hidden;" href="'+json.files[0].original+'" target="_blank">'+json.files[0].oname+'.'+json.files[0].extension+'</a>');
		}else{
	    	$("#ssimg"+id).html('<a href="'+json.files[0].original+'" target="_blank"><img src="'+json.files[0].original+'" style="max-width:50px;max-height:50px;" /></a>');
		}
	}catch(e){
		alert('err:'+e.message);
	}
}
</script>


</body>
</html>