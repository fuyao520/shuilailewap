<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
        <div class="help_rig">
			<div class="laction"><h2>我关注的人</h2> <span></span></div><!--laction end-->
			<div class="help_con">
				<div class="jfjl">
		            
			            <ul class="fans-list clearfix">
			            	<?php foreach($page['listdata']['list'] as $r){?>
			            	
			            	
			            	<li>
			            	    <a href="<?php  echo p_s_url('uid',$r['uid2'],1);?>"><img class="touimg" src="<?php echo $r['tou_img'];?>" width=50 height=50>   </a>    		
			            		<p>
			            		<a href="<?php echo Cms::model()->categorys[46]['surl'];?>?uid=<?php echo $r['uid2'];?>" class="nick"><?php echo $r['uname'];?></a><br>
			            		星座：<?php echo $r['constellation'];?><br>
			            		
			            		<span class="ico ok">已关注</span>
			            		<a onclick="delete_info(<?php echo $r['id'];?>)" href="javascript:void(0);">取消关注</a>
			            		</p>
			            		<div class="clear"></div>
			            		<div>
			            			职业：<?php echo $r['occupation'];?><br>
			            			简介：<?php echo helper::cut_str($r['signature'],20);?>
			            		</div>
			            	</li>
			            	<?php }?>
			          </ul>
            <div class="page"><?php echo $page['listdata']['pagearr']['pagecode'];?></div>
		            
		        </div>
	        </div>
        </div>
    </div>

</div>
<?php include(dirname(__FILE__)."/common/foot.php")?>

<script>
function delete_info(id){
	if(!confirm('确定吗？')) return false;
	$.get("<?php echo $this->createUrl('fans/delete');?>?id="+id,function(jsonstr){
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