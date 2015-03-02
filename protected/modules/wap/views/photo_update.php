<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['info_id']='';
	$page['info']['info_body']='';
}
?>

<style>
.pishangc li{ position:relative;margin-bottom:10px;}
.upclosebtn{position:absolute;right:-5px;top:-5px;background:#f30;color:#fff;border:none;display:inline-block;padding:2px;z-index:10;}
.pishangc li iframe{margin:70px 0 0 0px;}
.upimgshowbox{position:absolute;left:0px;top:0px;width:98%;height:100%;overflow:hidden;}
.upimgshowbox img{width:110px;}
.newupbtn{display:inline-block;width:110px;height:110px;line-height:110px;text-align:center;font-size:40px;color:#999;border:none;background:#eee;}
.photo-goods-text-box{font-size:18px;font-weight:bold;color:#ec1a5b;margin:10px 0 10px 0;}
.btext02{font-size:18px;color:#ccc;font-weight:bold;height:30px;line-height:30px;text-indent:5px;width:650px;}
.goods_text{color:#000;}
</style>
   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
	        <div class="help_rig">
				<div class="laction"><h2>晒照管理</h2> <span></span></div><!--laction end-->
				<div class="help_con">
				<form name="form1" id="update_info_box" onsubmit="info_save();return false;">
					<textarea name="info_body" id="info_body" placeholder="给你的晒单一个与众不同的开始吧..."><?php echo htmlspecialchars(stripslashes($page['info']['info_body']));?></textarea>
					<div class="photo-goods-text-box">本站宝贝链接：<input type=text class="btext02<?php if($page['info']['info_id']){echo ' goods_text';}?>" onfocus="$(this).addClass('goods_text');" onblur="if($(this).val()==''){$(this).removeClass('goods_text');}"  id="goods_url" 
					placeholder="比如：http://www.<?php echo Yii::app()->params['basic']['sitedomain'];?>/goods/822.html" value="<?php if($page['info']['info_id']){?>http://www.<?php echo Yii::app()->params['basic']['sitedomain'];?>/goods/<?php echo $page['info']['goods_id'];?>.html<?php }?>"> </div>
					<div class="jfjl">
					
            
            <input type="hidden" id="id" value="<?php echo $page['info']['info_id'];?>">
              
            	
					  						
						<ul id="mode_up_box_r" class="resourcelistul pishangc">
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
				<li><a href="javascript:void(0);"  class="newupbtn" onClick="create_mode_up_resource('add')" >+</a></li>         
            </ul>
			
            
            
            <div class="mt10"><input type=submit value="确定保存" class="btn06" ></div>
            
            
            
           
            
        </div>
        </form>
        <a name="list"></a>
        <div class="wdfb">
				<ul>
					<li class="bli on" id="tab001"><h2>我发表的</h2></li>
					<li class="bli" id="tab002"><h2><a href="<?php echo Cms::model()->categorys[46]['surl'];?>">查看更多</a></h2></li>
				</ul>	
				
				<ul class="bul" id="tab_cc_01">
							<?php foreach($page['listdata']['list'] as $r ){?>
							<li>
								<div class="tbox"><a href="<?php echo $r['url'];?>" class="title"><?php echo $r['info_title'];?></a> <span><?php echo helper::timeop($r['create_time']);?></span></div>
								<div class="img_box">
									<?php foreach($r['resource_list'] as $r2){?>
									<a href="<?php echo $r['url'];?>"><img src="<?php echo Attachment::simg($r2['resource_url']);?>"></a>	
									<?php }?>								</div><!--img_box end-->
								<ul class="wdfb_fxd_box">
									<li class="fxd"><span>分享到</span> <a href="<?php echo $r['url'];?>" class="xl"></a> <a href="" class="kj"></a> <a href="" class="tx"></a></li>
									<li class="lr"><span class="ll">浏览 <?php echo $r['info_visitors'];?> </span><span class="xh">喜欢(<?php echo $r['loves'];?>)</span><span class="hf">回复(<?php echo $r['comments_total'];?>)</span> 
									<a href="<?php echo $this->createUrl('infoPhoto/update');?>?id=<?php echo $r['info_id'];?>">[修改]</a>
	            					<a onclick="delete_info(<?php echo $r['info_id'];?>)" href="javascript:void(0);">[删除]</a>
									 </li>
								</ul><!--fxd_box end-->
							</li>
							<?php }?>
							
				 </ul>
				 
				
						

				</ul>
			</div>
			<div class="clearfix page"><?php echo $page['listdata']['pagearr']['pagecode'];?></div>
    </div>
</div>
</div>
</div>
</div>

<?php include(dirname(__FILE__)."/common/foot.php")?>
<script>
function info_save(){
    var postdata=C.form.get_form("#update_info_box");
	//alert($.toJSON(postdata));	return;
	$.post("<?php echo $this->createUrl('infoPhoto/update');?>",postdata,function(restr){
	    try{
			var ret=eval("("+restr+")");
			if(ret.state<1){
			    alert(ret.msgwords);
				return false;	
			}else{
				art.dialog({"content":"发布成功","lock":true,"icon":"succeed","time":1,close:function(){ window.location='<?php echo $this->createUrl('infoPhoto/update');?>';}})	
			}
		}catch(e){alert(e.message+restr);}	
	})
	return false;
}


/*
C.tabs(
		{"style":{		//选项卡样式
		"sclass":"on"	//选中
		},
		"params":[
		{"nav":"#tab001","con":"#tab_cc_01"},
		{"nav":"#tab002","con":"#tab_cc_02"}
		
		]}
		);
*/		


var modes=1;  //默认显示几条
var name_id=1;
function create_mode_up_resource(w,is_add_modes,resource_url,addcode,resource_order,resource_id,mark){
	var framecode='';
	if(!resource_url) resource_url='';
	if(!addcode) addcode='';
	if(!resource_order)resource_order=50;
	if(!mark) mark='';
	var markcode='';
	//alert(framecode);
	var code='<li class="clearfix">'+
		     '    <div class="mode_up_r" style="position:absolute;width:100%;height:100%;left:0px;top:0px;">'+
    		 '        <input type=button class="upclosebtn but2" onclick="'+addcode+'if(modes>0){$(this).parent().parent().remove();modes--;}"  value="移除">'+
			 '        <div class="fl">'+
			 '            <div class=fl>'+
			 '				'+markcode+'			'+
			 '               <input type="hidden" size=5 class="ipt"  name="resource_data[resource_order][]" id="resource_data[resource_order]['+name_id+']"  value="'+resource_order+'" />'+ 
			 '               <input type="hidden"  name="resource_data[resource_id][]" id="resource_data[resource_id]['+name_id+']"   value="'+resource_id+'" />'+ 
			 '               <input type="hidden"  name="resource_data[resource_url][]" class="rrrurl'+name_id+'" id="resource_data[resource_url]['+name_id+']" class=ipt value="'+resource_url+'" />'+ 
			 '		      </div>'+
			 '        <div class=fl id="ff'+name_id+'" style="position:relative;z-index:5;">'+
						framecode+
			 '        </div>'+
			 '        <div class="upimgshowbox"> '+ 
			 '		      <em style="margin:10px;" id="ssimg'+name_id+'">'+
			              (resource_url?'<a href="'+resource_url+'" target=_blank><img src="'+resource_url+'" /></a>':'')+
			 '			  </em>'+
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
			create_upload_iframe('{"inner_box":"#ff'+name_id+'","width":"104","style":"photo01","btn":"上传宝贝照片","func":"callback_upload33","id":"'+name_id+'","thumb":{"width":"300","height":"300"},"water":1}');
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
	    	$("#ssimg"+id).html('<a href="'+json.files[0].original+'" target="_blank"><img src="'+json.files[0].original+'"/></a>');
		}
	}catch(e){
		alert('err:'+e.message);
	}
}
<?php if(!isset($page['info'])){?>
create_mode_up_resource('add');
<?php }?>


</script>
<script>
function delete_info(id){
	if(!confirm('确定吗？')) return false;
	$.get("<?php echo $this->createUrl('InfoPhoto/delete');?>?id="+id,function(jsonstr){
		try{
		var json=eval('('+jsonstr+')');
		if(json.state<=0){
			alert(json.msgwords);
		}else{
			alert(json.msgwords);
			window.location=window.location.href;
			window.location.reload();
		}
		}catch(e){alert(e.message);}
	})
}
</script>


</body>
</html>