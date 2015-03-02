<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
function create_mode_up(w,is_add_modes,id,title,model_id,cate_id){
	var code='<div class="mode_up" style="position:relative;"><a href="javascript:void(0);" onclick="$(this).parent().remove();" style="position:absolute;left:350px;top:5px; cursor:pointer;">移除</a>'+	
	'<li><div class=l><span class=ccc>(栏目：'+cate_id+' ID：'+id+') <input type=text class="ipt" style="margin:2px;" value="'+title+'" name="infotitle[]"/><input type="hidden"   name="infoid[]" value="'+id+'"  /><input type="hidden"   name="info_model_id[]" value="'+model_id+'"  /></div><div class=clear></div></li>'+
	'           </div>';
	if(w=='add'){
		if(is_add_modes=='no'){
		}else{
		}
	    $('#mode_up_box').append(code);
	}
}
function get_select_info(id,title,model_id,cate_id){
    create_mode_up('add','',id,title,model_id,cate_id);	
}
</script>  
<div class="main mhead">
    <div class="snav">内容中心 »  专题管理	 » <?php echo $page['special']['special_name']; ?> » 关联文档</div>
 
    <div class="mt10">
        <select  onchange="location='<?php echo $this->createUrl('specialInfoRelation/index');?>?special_id=<?php echo $this->get('special_id');?>&special_type='+this.value">
        <option value=''>--选择小分类--</option> 
        <?php foreach($page['special']['types'] as $r){ ?>
        <option value="<?php echo $r['value']; ?>" <?php if($this->get('special_type')==$r['value'])echo 'selected';?>><?php echo $r['txt']; ?></option>
		<?php }?>
		</select>
    </div> 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />
           <input type="button" class="but2" value="删除选中" onclick="set_some('<?php echo $this->createUrl('specialInfoRelation/delete')?>?&special_id=<?php echo $_GET['special_id'];?>&ids=[@]','确定删除吗？');" />
           
          <select onchange="set_some('<?php echo $this->createUrl('specialInfoRelation/updateType')?>?special_type='+this.value+'&special_id=<?php echo $_GET['special_id'];?>&ids=[@]','确定转移吗？');">
        <option value=''>--转移小分类--</option> 
        <?php foreach($page['special']['types'] as $r){ ?>
        <option value="<?php echo $r['value']; ?>" ><?php echo $r['txt']; ?></option>
		<?php }?>
		</select>
           <input type="button" class="but2" value="添加关联" onclick="location='index.php?m=admin&c=special_info_relation&a=add_special_info_relation&special_id=<?php echo $_GET['special_id']; ?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('specialInfoRelation/saveOrder');?>?special_id=<?php echo $_GET['special_id']; ?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="80"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center' width="80"> 排序</th>
        <th width="400"  class="alignleft">标题</th>
        <th width="40">图片</th>
        <th>专题小分类</th>
        <th>操作</th>
    </tr>
    
   <?php 
   foreach($page['i_s_rs']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['relation_id']; ?>" /></td>
        <td><input type="text" size="2" name="listorders[<?php echo $r['relation_id']; ?>]" value="<?php echo $r['i_s_order']; ?>" /></td>
        <td class="alignleft"><div style="height:24px; line-height:24px; width:400px; overflow:hidden;">
		<font color="#999999">[<?php echo $r['model_name']; ?>]</font>
		<?php echo $r['info_title']; ?></div></td>
         <td width="40"><img data-cate_id="<?php echo $r['last_cate_id'];?>" data-model="<?php echo $r['table'];?>" data-info_id="<?php echo $r['info_id'];?>" src="<?php echo isset($r['info_img'])?$r['info_img']:'';?>" width=20 height=20 class="slider-simage info_img"/></td>
        <td><?php echo helper::get_arr_txt($page['special']['types'],$r['special_type'] ); ?></td> 
        <td><a onclick="return dialog_frame(this);" href="<?php echo $this->createUrl('info/update');?>?cate_id=<?php echo $r['last_cate_id'];?>&id=<?php echo $r['info_id'];?>">编辑</a></td>       	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['i_s_rs']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
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
	var info_id=$(this).attr("data-info_id");
	var model=$(this).attr("data-model");
	var cate_id=$(this).attr("data-cate_id");
	info_cover_crop(model,info_id,cate_id,img);
})

</script>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>