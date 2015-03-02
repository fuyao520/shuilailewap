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
				<div class="laction"><h2>晒照管理</h2> <span></span></div><!--laction end-->
				<div class="help_con">
					<div class="jfjl">
	            <div class="mt10">
	            	<input type=button class="btn03" value="添加晒照" onclick="location='<?php echo $this->createUrl('infoPhoto/update');?>'">
	            </div>
	            <table class="tb_list mt10">
	            	<tr>
	            		<th width=250>标题</th>
	            		<th width=40>封面</th>
	            		<th width=100>时间</th>
	            		<th width=100>操作</th>    		
	            	</tr>
	            	<?php foreach($page['listdata']['list'] as $r){?>
	            	<tr>            		
	            		<td>
	            		<?php if($r['audit']==0){?>
	            		<span class="red">[待审核]</span>
	            		<?php }?>
	            		<a href="<?php echo Cms::model()->set_info_url($r);?>"><?php echo $r['info_title'];?></a></td>
	            		<td><img src="<?php echo Attachment::simg($r['info_img']);?>" width=30 height=30/></td>
	            		<td><?php echo date('Y-m-d H:i:s',$r['create_time']);?></td>	
	            		<td>
	            			<a href="<?php echo Cms::model()->set_info_url($r);?>">查看</a>
	            			<a href="<?php echo $this->createUrl('infoPhoto/update');?>?id=<?php echo $r['info_id'];?>">修改</a>
	            			<a onclick="delete_info(<?php echo $r['info_id'];?>)" href="javascript:void(0);">删除</a>
	            		</td>
	            	</tr>
	            	<?php }?>
	            
	            </table>
	            
	            <div class="clearfix page"><?php echo $page['listdata']['pagearr']['pagecode'];?></div>
	            </div>
	        </div>
	    </div>

	</div>
</div>
</div>	
<?php include(dirname(__FILE__)."/common/foot.php")?>

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