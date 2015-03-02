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
			<div class="laction"><h2>第三方授权管理</h2> <span></span></div><!--laction end-->
			<div class="help_con">
				<div class="jfjl">
		            <table class="tb_list mt10">
		            	<tr>
		            		<th width=100>网站</th>
		            		<th>账户</th>
		            		<th width=80>授权时间</th>
		            		
		            		<th>操作</th>		
		            	</tr>
		            	<?php foreach($page['listdata']['list'] as $r){?>
		            	<tr>            		
		            		<td>
		            		<img src="/static/user/images/<?php echo $r['media_type'];?>.png" width=80 height=80 align="middle">
		            			
		            			
		            		</td>
		            		<td>
		            		<?php  $a=helper::json_decode_cn($r['user_data'],1);?>
		            		<?php echo $a['nickname'];  ?><br>
		            		<img src="<?php echo $a['tou_img'];?>" width=40 height=40>
		            		
		            		</td>
		            		<td><?php echo date('Y-m-d',$r['created']);?></td>
		            		<td><a href="javascript:void(0);" onclick="delete_info(<?php echo $r['id'];?>)">删除</a></td>
		            		
		            	</tr>
		            	<?php }?>
		            
		            </table>
		            
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
	$.get("<?php echo $this->createUrl('thirdpassport/delete');?>?id="+id,function(jsonstr){
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