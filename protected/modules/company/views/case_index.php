<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>     
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title">案例列表</div>
            <div class="mt10 user-ad-se">
            <form action="<?php echo $this->createUrl('infoCase/index'); ?>">			    
		    关键词：
		    <input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" >
		    <input type="submit" class="btn03" value="查询"  ><br>
	    	</form>
	    	</div>
            <div class="mt10">
            	<input type=button class="btn03" value="添加案例" onclick="location='<?php echo $this->createUrl('infoCase/update');?>'">
            </div>
            <table class="tb_list mt10">
            	<tr>
            		<th>编号</th>
            		<th width=250>标题</th>
            		<th width=40>封面</th>
            		<th width=100>时间</th>
            		<th width=100>类型</th>
            		<th width=100>操作</th>    		
            	</tr>
            	<?php foreach($page['listdata']['list'] as $r){?>
            	<tr>            		
            		<td>
            		<?php if($r['audit']==0){?>
            		<span class="red">[待审核]</span>
            		<?php }?>
            		<?php echo $r['number_no'];?>
            		</td>
            		<td><a href="<?php echo Cms::model()->set_info_url($r);?>"><?php echo $r['info_title'];?></a></td>
            		<td><img src="<?php echo Attachment::simg($r['info_img']);?>" width=30 height=30/></td>
            		<td><?php echo date('Y-m-d H:i:s',$r['create_time']);?></td>
            		<td><?php echo Linkage::model()->get_name($r['stone_cate_id']);?></td>
            		<td>
            			<a href="<?php echo Cms::model()->set_info_url($r);?>">查看</a>
            			<a href="<?php echo $this->createUrl('infoCase/update');?>?id=<?php echo $r['info_id'];?>">修改</a>
            			<a onclick="delete_info(<?php echo $r['info_id'];?>)" href="javascript:void(0);">删除</a>
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
	$.get("<?php echo $this->createUrl('InfoCase/delete');?>?id="+id,function(jsonstr){
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