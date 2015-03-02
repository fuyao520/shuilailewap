<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php //if(isset($page['cate_info']['field_setting'][0])){echo 'aaa';}die('d'); ?>
<?php $select_mode=$this->get('select_mode',0);?>
<script>
function set_flag(){
    try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	var idarrs=idarr.join(',');
	C.alert.opacty({"width":"300","height":"150","title":"批量设置属性","content":"","div_tag":"#flag_box"});
	}catch(e){alert(e.message)}	
}
function post_flag(){
	try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	var idarrs=idarr.join(',');
	var flag_value=$("#flagvar:checked").val();
	if(typeof(flag_value)=='undefined'){
	    alert('请选择属性');	
		return false;
	}
	$.get("<?php echo $this->createUrl('info/setFlag'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&ids="+idarrs+"&flag="+flag_value,function(data){
		window.location=window.location.href;	
	});
	}catch(e){alert(e.message)}	
    	
}
function set_cate(){
    try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	var idarrs=idarr.join(',');
	C.alert.opacty({"width":"250","height":"350","title":"批量转移分类","content":"","div_tag":"#cate_box"});
	}catch(e){alert(e.message)}	
}
function post_cate(){
	try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	var idarrs=idarr.join(',');
	var cate_id=$("#cate_id").val();
	if(typeof(cate_id)=='undefined' || cate_id==0){
	    alert('请选择分类');	
		return false;
	}
	$.get("<?php echo $this->createUrl('info/setInfoCate'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&ids="+idarrs+"&set_cate_id="+cate_id,function(data){
		//alert(data);
		window.location=window.location.href;	
	});
	}catch(e){alert(e.message)}	
    	
}

function select_mode(id,title,model_id,model_name,eobj){
	try{
	    if(!window.parent.opener.get_select_info(id,title,model_id,model_name)){
		    alert('已经存在');
			return false;
		}
	    $(eobj).html('<span class=green>√</span>');	  
		
    }catch(e){
	    alert(e.message);	
	}
}

function get_select_info(id,title,model_id,cate_id){
    create_mode_up('add','',id,title,model_id,cate_id);	
}



function set_recommend(){
    try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	if($("#recommend_select_box").find("select").length==0){
		$.post("<?php echo $this->createUrl('recommend/getRecommendList'); ?>",function(jsonstr){
			try{
				var json=eval("("+jsonstr+")");
				var code='';
				for(var i=0;i<json.list.length;i++){
					code+='<option value="'+json.list[i].recommend_id+'">'+(json.list[i].recommend_name)+'</option>';	
				}
				code='<select id="recommend_id" size="13">'+code+'</select>';
				$("#recommend_select_box").html(code);
			}catch(e){alert(e.message+jsonstr);}	
		})
	}
	C.alert.opacty({"width":"250","height":"400","title":"加入推荐","content":"","div_tag":"#recommend_box"});
	}catch(e){alert(e.message)}	
}
function set_special(){
    try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	if($("#special_select_box").find("select").length==0){
		$.post("<?php echo $this->createUrl('special/getSpecialList'); ?>",function(jsonstr){
			try{
				var json=eval("("+jsonstr+")");
				var code='';
				/*
				for(var i=0;i<json.list.length;i++){
					code+='<option data="'+encodeURIComponent(json.list[i].typesetting)+'" value="'+json.list[i].special_id+'">'+(json.list[i].special_name)+'</option>';	
				}
				*/
				code='<select id="special_id" size="13"  style=" width:400px; " onchange="show_special_small_cate(this)">'+decodeURIComponent(json.data)+'</select>';
				$("#special_select_box").html(code);
			}catch(e){alert(e.message+jsonstr);}	
		})
	}
	C.alert.opacty({"width":"550","height":"450","title":"加入推荐","content":"","div_tag":"#special_box"});
	}catch(e){alert(e.message)}	
}
function del_recommend(table,info_id,recommend_id){
	$.get("<?php echo $this->createUrl('info/delRecommend'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&table="+table+"&info_id="+info_id+"&recommend_id="+recommend_id,function(jsonstr){
		try{
		var json=eval("("+jsonstr+")");
		if(json.code<=0){
			alert(json.statewords)
		}else{
			window.location=window.location.href;
		}
		}catch(e){alert(e.message+jsonstr);}
			
	});
}

function set_special(){
    try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	if($("#special_select_box").find("select").length==0){
		$.post("<?php echo $this->createUrl('special/getSpecialList'); ?>",function(jsonstr){
			try{
				var json=eval("("+jsonstr+")");
				var code='';
				/*
				for(var i=0;i<json.list.length;i++){
					code+='<option data="'+encodeURIComponent(json.list[i].typesetting)+'" value="'+json.list[i].special_id+'">'+(json.list[i].special_name)+'</option>';	
				}
				*/
				code='<select id="special_id" size="13"  style=" width:400px; " onchange="show_special_small_cate(this)">'+decodeURIComponent(json.data)+'</select>';
				$("#special_select_box").html(code);
			}catch(e){alert(e.message+jsonstr);}	
		})
	}
	C.alert.opacty({"width":"550","height":"450","title":"加入推荐","content":"","div_tag":"#special_box"});
	}catch(e){alert(e.message)}	
}
function post_set_special(){
	try{
	var idarr=get_group_checked('.cklist');
	if(idarr.length==0){
		alert('请选中至少一个');
		return false;
	}
	var idarrs=idarr.join(',');
	var special_id=$("#special_id").val();
	if(typeof(special_id)=='undefined' || special_id==0){
	    alert('请选择专题');	
		return false;
	}
	var small_cate=$("#special_small_cate").val();
	$.get("<?php echo $this->createUrl('info/setSpecial'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&ids="+idarrs+"&set_special_id="+special_id+"&small_cate="+small_cate,function(jsonstr){
		//alert(data);
		try{
		var json=eval("("+jsonstr+")");
		if(json.code<=0){
			alert(json.statewords)
		}else{
			window.location=window.location.href;
		}
		}catch(e){alert(e.message+jsonstr);}
			
	});
	}catch(e){alert(e.message)}		
}
function show_special_small_cate(element){
	try{
	var obj=$(element).find("option::selected")	
	var data=decodeURIComponent(obj.attr("data"));
	var catejson=eval("("+data+")");
	var code='';
	for(var i=0;i<catejson.length;i++){
		code+='<option value="'+catejson[i].value+'">'+decodeURIComponent(catejson[i].txt)+'</option>';	
	}
	$("#special_small_cate").html(code);
	}catch(e){alert(e.message)}	
}

function del_special(model_id,info_id,special_id){
	$.get("<?php echo $this->createUrl('info/delSpecial'); ?>?cate_id=<?php echo $_GET['cate_id']; ?>&model_id="+model_id+"&info_id="+info_id+"&special_id="+special_id,function(jsonstr){
		try{
		var json=eval("("+jsonstr+")");
		if(json.code<=0){
			alert(json.statewords)
		}else{
			window.location=window.location.href;
		}
		}catch(e){alert(e.message+jsonstr);}
			
	});
}

function send_gettotal(cate_id){
    $.ajax({url:"<?php echo $this->createUrl('infoCategory/getCateTotalInfo');?>?cate_id="+cate_id,success: function(data){
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
    <div class="mt10">
    	<form>
    		<input type="hidden" name="select_mode" value="<?php echo $select_mode;?>">
    		<input type="hidden" name="cate_id" value="<?php echo $this->get('cate_id');?>">
    		 
	    	<div>
	    		<?php /*支持联动菜单搜索*/?>
	    		<?php foreach($page['model_fields'] as $f){if($f['form_type']!='linkage')continue;?>
	    				 <?php echo $f['field_txt'];?>：<?php echo form_type_code::get_html(array('type'=>$f['form_type'],'default_value'=>$this->get($f['field_name']),'form_name'=>$f['field_name'],'ini_value'=>isset($f['setting']['ini_value'])?$f['setting']['ini_value']:'','linkage_type_id'=>$f['linkage_type_id'],'linkage_attr'=>array('parent_id'=>$f['linkage_select_parent_id'],'select_num'=>$f['linkage_select_selectnum']))); ?>   			
	    		<?php }?>
	    	</div>
		    <div class="mt10">
			    <select name="search_type">
			        <option value="keys" <?php echo isset($_GET['search_type'])&&$_GET['search_type']=='keys'?'selected':''; ?>>标题关键字</option>
			        <option value="id" <?php echo isset($_GET['search_type'])&&$_GET['search_type']=='id'?'selected':''; ?>>内容ID</option>
			    </select>
			    &nbsp;<input type="text" name="search_txt" class="ipt" value="<?php echo isset($_GET['search_txt'])?$_GET['search_txt']:''; ?>" >&nbsp;
			    <input type="submit" class="but" value="查询" >&nbsp;
			    
		    </div>
   	  </form>
    
    </div>
    
    <div class="mt10 clearfix" <?php if($select_mode==1){?>style="display:none;"<?php }?>>
        <div class="l">
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />','auth_tag'=>'info_edit')); ?>
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('info/delete').'?cate_id='.$_GET['cate_id'].'&ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'info_delete')); ?>
            <?php if(!isset($page['cate_info']['field_setting']['set_audit'])||$page['cate_info']['field_setting']['set_audit']==0){?>
			<?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="已审核" onclick="set_some(\''.$this->createUrl('info/auditInfo').'?cate_id='.$_GET['cate_id'].'&ids=[@]&audit=1\',\'确定设置为已审核吗？\');" />','auth_tag'=>'info_audit')); ?>
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="未审核" onclick="set_some(\''.$this->createUrl('info/auditInfo').'?cate_id='.$_GET['cate_id'].'&ids=[@]&audit=0\',\'确定设置为未审核吗？\');" />','auth_tag'=>'info_audit')); ?>
            <?php }?>
            <?php if(!isset($page['cate_info']['field_setting']['set_flag'])||$page['cate_info']['field_setting']['set_flag']==0){?>
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="设置属性" onclick="set_flag()" />','auth_tag'=>'info_update')); ?>
            <?php }?>
            <?php if(!isset($page['cate_info']['field_setting']['set_recommend'])||$page['cate_info']['field_setting']['set_recommend']==0){?>
			<?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="加入推荐" onclick="set_recommend()" />','auth_tag'=>'info_setRecommend')); ?>
			<?php }?>
            <?php if(!isset($page['cate_info']['field_setting']['set_special'])||$page['cate_info']['field_setting']['set_special']==0){?>
			<?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="加入专题" onclick="set_special()" />','auth_tag'=>'info_setSpecial')); ?>
			<?php }?>
			<?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="转移分类" onclick="set_cate()" />','auth_tag'=>'info_setInfoCate')); ?>
            <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加'.$page['cate_info']['model_name'].'" onclick="location=\''.$this->createUrl('info/update').'?cate_id='.$_GET['cate_id'].'\'" />','auth_tag'=>'info_update')); ?>
            
            
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('info/saveOrder');?>?cate_id=<?php echo $_GET['cate_id']; ?>" name="form_order" method="post" >
<table class="tb" >
    <tr>
        <?php if($select_mode!=1){?>
        <th width="40"><a href="javascript:void(0);" onclick="check_all('.cklist');">反选</a></th>
        <th align='center' width="48">排序</th>
        <?php }?> 
        <th align='center' width="70">
        <?php echo helper::field_paixu(array('url'=>''.$this->createUrl('info/index').'?cate_id='.$_GET['cate_id'].'&p='.$_GET['p'].'','field_cn'=>'ID','field'=>'info_id')); ?>
        </th>
        <?php if(!isset($page['cate_info']['field_setting']['info_title'])||$page['cate_info']['field_setting']['info_title']==0){?>
        <th  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('info/index').'?cate_id='.$_GET['cate_id'].'&p='.$_GET['p'].'','field_cn'=>show_field_txt($page['mymodelfs'],'info_title'),'field'=>'info_title')); ?></th>
        <?php }?>
        <?php if($select_mode!=1){?>
        <?php foreach($page['model_fields'] as $f){?>
        <th title="<?php echo $f['field_txt']; ?>"  <?php if(isset($page['cate_info']['field_setting'][$f['field_name']])&&$page['cate_info']['field_setting'][$f['field_name']]==1){echo 'style="display:none;"';} ?>><div style=" height:20px;  line-height:20px;max-width:100px;overflow:hidden; text-align:center;"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('info/index').'?cate_id='.$_GET['cate_id'].'&p='.$_GET['p'].'','field_cn'=>$f['field_txt'],'field'=>$f['field_name'])); ?></div></th>
       <?php } ?>
       <?php }?> 
      	<?php if($select_mode==1){?>
        <th width="40">图片</th>
        <?php }?>
        <th width=140>操作 </th>
       
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
	   $r['info_attr_title']=json_decode($r['info_attr_title'],true);
   ?>
    <tr>   
        <?php if($select_mode!=1){?>
        <td><input type="checkbox" class="cklist" value="<?php echo $r['info_id']?$r['info_id']:$r['i_info_id']; ?>" /></td>
        <td><input type="text" size="2" name="listorders[<?php echo $r['info_id']; ?>]" value="<?php echo $r['info_order']; ?>" /></td>
        <?php }?> 
        <td><?php echo $r['info_id']; ?></td>
        <?php if(!isset($page['cate_info']['field_setting']['info_title'])||$page['cate_info']['field_setting']['info_title']==0){?>
        <td class="alignleft"><div style="height:20px; line-height:20px; overflow:hidden; ">
		<?php if($r['audit']==0) echo '<a href="'.$this->createUrl('info/index').'?cate_id='.$_GET['cate_id'].'&p='.$_GET['p'].'&audit=0" title="点击查看所有未审核"><font color=red>[未审核]</font></a>'; ?>
        <?php if($r['flag_c']==1) echo '<font color=red>[推荐]</font>'; ?>
        <?php if($r['flag_h']==1) echo '<font color=red>[头条]</font>'; ?>
        <?php if($r['flag_s']==1) echo '<font color=red>[滚动]</font>'; ?>
        <?php if($r['flag_a']==1) echo '<font color=red>[特推]</font>'; ?>
        <?php if($r['flag_d']==1) echo '<font color=red>[幻灯]</font>'; ?>
		<a title="<?php echo $r['info_title']; ?>" href="<?php echo $this->createUrl('info/update');?>?cate_id=<?php echo $r['last_cate_id'];  ?>&p=<?php echo $_GET['p'];  ?>&id=<?php echo $r['info_id']; ?>" <?php if($select_mode==1){?>onclick="return false;"<?php }?>><?php echo stripslashes($r['info_title']); ?></a>
        <?php }?>
        </div>
        <?php $recommends=Recommend::model()->get_info_recommends($page['cate_info']['model_table_name'],$r['info_id']); ?>
        <?php $specials=Special::model()->get_info_specials($page['cate_info']['model_id'],$r['info_id']); ?>
        <?php if(count($recommends)||count($specials)){ ?>
        <div style=" line-height:20px; overflow:hidden;" class="infotitlerecommend_box">
            [专题/推荐位] 
            <?php foreach($recommends as $r2){  ?>
            <a onclick="return dialog_frame(this);" title="点击查看此推荐位所有信息" href="<?php echo $this->createUrl('recommend/update');?>?id=<?php echo $r2['recommend_id']; ?>" ><?php echo $r2['recommend_name']; ?></a><i class="delx" title="取消" onclick="del_recommend('<?php echo $page['cate_info']['model_table_name']; ?>',<?php echo $r['info_id']; ?>,<?php echo $r2['recommend_id']; ?>);">X</i>
            <?php }?>
            <?php foreach($specials as $r2){  ?>
            <a onclick="return dialog_frame(this);" title="点击查看此专题的所有信息" href="<?php echo $this->createUrl('specialInfoRelation/Index');?>?special_id=<?php echo $r2['special_id']; ?>" ><?php echo $r2['special_name']; ?></a><i class="delx" title="取消" onclick="del_special('<?php echo $page['cate_info']['model_id']; ?>',<?php echo $r['info_id']; ?>,<?php echo $r2['special_id']; ?>);">X</i>
            <?php }?>
        </div>
        <?php }?>
        </td>
        <?php if($select_mode!=1){?>
        <?php foreach($page['model_fields'] as $f){?>
        <td  <?php if(isset($page['cate_info']['field_setting'][$f['field_name']])&&$page['cate_info']['field_setting'][$f['field_name']]==1){echo 'style="display:none;"';} ?>><div style=" height:20px; overflow:hidden; line-height:20px;max-width:100px; text-align:center;"><?php  echo form_type_code::get_html(array('m'=>'list_show_value','field_value'=>$r[$f['field_name']],'form_name'=>$f['field_name'],'type'=>$f['form_type'],'ini_value'=>isset($f['setting']['ini_value'])?$f['setting']['ini_value']:'','linkage_type_id'=>$f['linkage_type_id'],'id'=>$r['info_id'])) ?></div></td>
       <?php } ?>
       <?php }?> 
       
       <?php if($select_mode==1){?>
        <td width="40"><img src="<?php echo isset($r['info_img'])?$r['info_img']:'';?>" width=20 height=20 class="slider-simage"/></td>
        <?php }?>
        <td>
               
        <?php if(!$select_mode){?>
	        <?php foreach($page['cmodel'] as $r2){ ?>
	        <a onclick="return dialog_frame(this);" href="<?php echo $this->createUrl('childTable/index');?>?info_id=<?php echo $r['info_id'];?>&id_model_id=<?php echo $r['model_id'];?>&cmodel_id=<?php echo $r2['model_id'];?>"><?php echo $r2['model_name'];?></a>
			<?php }?>
	        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('info/update').'?cate_id='.$r['last_cate_id'].'&p='.$_GET['p'].'&id='.$r['info_id'].'">修改</a>','auth_tag'=>'info_edit')); ?>
	        <?php if(!isset($page['cate_info']['field_setting']['info_comment'])||$page['cate_info']['field_setting']['info_comment']==0){?>
	          <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('Comment/index').'?search_type=fromid&search_txt='.$page['cate_info']['model_table_name'].'-'.$r['info_id'].'" onclick="return dialog_frame(this);" >评论<span class=red>('.$r['comments_total'].')</span></a>','auth_tag'=>'comment_show')); ?>
	        <?php }?>
        
        <?php }else{?>
        <a href="javascript:void(0);" onclick="select_mode(<?php echo $r['info_id'];?>,'<?php echo $r['info_title']; ?>',<?php echo $page['cate_info']['model_id'];?>,'<?php echo $page['cate_info']['model_name'];?>',this);">选中</a>
        <?php }?>
           </td>
        
    </tr>
   <?php } ?> 
      
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<div id="flag_box" style="background:#fff; display:none; line-height:24px;">
    <div style="padding:15px;">
        <input type="radio" id="flagvar" name="flagvar" value="flag_c" /> 推荐
        <input type="radio" id="flagvar" name="flagvar" value="flag_h" /> 头条
        <input type="radio" id="flagvar" name="flagvar" value="flag_s" /> 滚动
        <input type="radio" id="flagvar" name="flagvar" value="flag_a" /> 特推
        <input type="radio" id="flagvar" name="flagvar" value="flag_d" /> 幻灯
        <br />
        <input type="radio" id="flagvar" name="flagvar" value="none" /> 取消所有属性
        
        <div style="text-align: center; margin-top:15px;">
        <input type="button"  class="but" value="确定" onclick="post_flag();"/> 
        <input type="button"  class="but" value="取消" onclick="C.alert.opacty_close('#flag_box')"/>
        </div>
    </div>
</div>
<div id="cate_box" style="background:#fff; display:none; line-height:24px;">
    <div style="padding:15px;">
        <select id="cate_id" size="13">
            <option value="0">--转移到--</option>
            <?php echo $page['categorys_option'];?>
        </select>
        
        <div style="text-align: center; margin-top:15px;">
        <input type="button"  class="but" value="确定" onclick="post_cate();"/> 
        <input type="button"  class="but" value="取消" onclick="C.alert.opacty_close('#cate_box')"/>
        </div>
    </div>
</div>

<div id="recommend_box" style="background:#fff; display:none; line-height:24px;">
    <div style="padding:15px;">
        <div style="color:red;">注意，必须是同一模型的推荐位</div>
        <div id="recommend_select_box" style="text-align: center;"> 
           加载中..
        </div>
        
        <div style="text-align: center; margin-top:15px;">
        <input type="button"  class="but" value="确定" onclick="post_set_recommend();"/> 
        <input type="button"  class="but" value="取消" onclick="C.alert.opacty_close('#recommend_box')"/>
        </div>
    </div>    
</div>

<div id="special_box" style="background:#fff; display:none; line-height:24px;">
    <div style="padding:15px;">
        
        <div id="special_select_box" style="display:inline; width:440px; overflow:hidden;"> 
           加载中..
        </div>
        <select id="special_small_cate" size="13" style="display:inline; width:100px;">
            
         </select>
        
        <div style="text-align: center; margin-top:15px;">
        <input type="button"  class="but" value="确定" onclick="post_set_special();"/> 
        <input type="button"  class="but" value="取消" onclick="C.alert.opacty_close('#special_box')"/>
        </div>
    </div>    
</div>

<?php 
function show_field_txt($mymodelfs,$filed_name){
		foreach($mymodelfs as $b){
			if($b['field_name']==$filed_name){
				return $b['field_txt'];
				break;	
			}
		}
	}
?>
<div class="float-simage-box" style="position: absolute;">
</div>


<script src="/static/lib/jquery.jcrop/jquery.jcrop.min.js"></script>
<link rel="stylesheet" href="/static/lib/jquery.jcrop/jquery.Jcrop.css">
<script>
$(".slider-simage").hover(
	function(){
		$(".float-simage-box").show();
		var imgurl=$(this).attr("src");
		$(".float-simage-box").html('<img src="'+imgurl+'" width=150 />');
		var left=$(this).offset().left-150;
		var top=$(this).offset().top;
		$(".float-simage-box").css({"left":left+'px',"top":top+'px'});
	},
	function(){
		$(".float-simage-box").hide();
	}
)

//封面快速裁剪
$(".info_img").click(function(){
	var img=$(this).attr("src");
	var id=$(this).attr("data-id");
	var idField="info_id";
	var imgField='info_img';
	var table='<?php echo $page['cate_info']['model_table_name'];?>';	
	info_cover_crop(table,id,idField,img,imgField);
})



</script>


<?php require(dirname(__FILE__)."/../common/foot.php"); ?>