<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>     
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title">关注列表</div>
            
            
           
            <table class="tb_list mt10">
            	<tr>
            		<th width=70>类型</th>
            		<th>编号</th>
            		<th width=250>标题</th>
            		<th width=40>封面</th>
            		<th width=100>时间</th>            		
            		<th width=100>操作</th>    		
            	</tr>
            	<?php foreach($page['listdata']['list'] as $r){?>
            	<tr>
            	
            		<td><?php echo $r['type_name'];?></td>            		
            		<td><?php echo $r['number_no'];?></td>
            		<td>            		
            		<a href="<?php echo $r['url'];?>"><?php echo $r['info_title'];?></a></td>
            		<td><img src="<?php echo Attachment::simg($r['info_img']);?>" width=30 height=30/></td>
            		<td><?php echo date('Y-m-d H:i:s',$r['add_time']);?></td>
            		<td>
            			<a href="<?php echo $r['url'];?>">查看</a>
            			<a onclick="delete_info(<?php echo $r['collect_id'];?>)" href="javascript:void(0);">删除</a>
            		</td>
            	</tr>
            	<?php }?>
            
            </table>
            
            <div class="clearfix pagebar"><?php echo $page['listdata']['pagearr']['pagecode'];?></div>
            
        </div>
    </div>

</div>
<?php include(dirname(__FILE__)."/foot.php")?>

<script>
function delete_info(id){
	if(!confirm('确定吗？')) return false;
	$.get("<?php echo $this->createUrl('collect/delete');?>?id="+id,function(jsonstr){
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