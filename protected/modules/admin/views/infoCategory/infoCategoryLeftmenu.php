<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
$(document).ready(function(){
	$("#content_left_menu").treeview({
		control: "#treecontrol",
		persist: "cookie",
		cookieId: "treeview-black_c"
	});
	return false;
	//得到每个分类的总数
	var idarr=<?php echo json_encode($page['idarr']); ?>;
	var delay=1000;
	if(idarr.length<10) delay=2000;
	if(idarr.length>10 &&idarr.length<20) delay=4000;
	if(idarr.length>20 &&idarr.length<50) delay=8000;
	if(idarr.length>50 &&idarr.length<100) delay=22000;
	if(idarr.length>100&&idarr.length<200) delay=34000;
	if(idarr.length>200&&idarr.length<400) delay=50000;
	if(idarr.length>400&&idarr.length<600) delay=70000;
	if(idarr.length>600&&idarr.length<800) delay=100000;
	if(idarr.length>800&&idarr.length<1000) delay=150000;
	if(idarr.length>1000) delay=200000;
	
	for(var i=0;i<idarr.length;i++){
		var timeout=parseInt(delay*Math.random());
		var cate_id=idarr[i];
		setTimeout("send_gettotal("+cate_id+")",timeout);
		//break;
	}
	

});
function send_gettotal(cate_id){
    $.ajax({url:"?m=admin&c=InfoCategory&a=get_cate_total_info&cate_id="+cate_id,success: function(data){
			var json=$.evalJSON(data);
			$("#fei_"+json.cate_id).html(json.totals);
	}});	
}
</script>

<div class="content_left_menu" id="content_left_menu">
     <div style="width:400px;">
     <div class="changebtn">
         <a href="<?php echo $this->createUrl('InfoFrame/index');?>?select_mode=<?php echo $this->get('select_mode'); ?>" class="current"  target="main"  onclick="if(!window.main){$(this).attr('target','_parent')}">分类</a>
         <a href="<?php echo $this->createUrl('infoModelFrame/index');?>?select_mode=<?php echo $this->get('select_mode'); ?>" target="main" onclick="if(!window.main){$(this).attr('target','_parent')}">模型</a>
     </div>
    <div id="treecontrol" style="margin:0px 0 0 2px; display:inline-block; position:relative; top:5px;">
        <a></a>
        <a></a>
		<a href="javascript:void(0);"><img src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/jquery_tree/img/minus.gif" /> <img src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/jquery_tree/img/application_side_expand.png" /> 展开/收缩</a>
    </div>
    <ul id="treeview-black">
      <?php 
	    echo $page['categorys'];
	  ?>
     </ul> 
     </div>
</div>
