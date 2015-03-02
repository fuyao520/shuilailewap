<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>   
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title">我的积分记录</div>
            <div class="mt10">我当前总积分：<?php echo $page['points_total'];?></div>
            <table class="tb_list mt10">
            	<tr>
            		<th width=100>时间</th>
            		<th width=80>积分</th>
            		<th>产生原因</th>		
            	</tr>
            	<?php foreach($page['listdata']['list'] as $r){?>
            	<tr>            		
            		<td>
            		<?php echo date('Y-m-d',$r['create_date']);?></a></td>
            		<td><?php echo $r['points']>0?'<span style="color:green;font-weight:bold;">+'.$r['points'].'</span>':'<span style="color:#f00;font-weight:bold;">+'.$r['points'].'</span>';?></td>
            		<td><?php echo $r['points_reason'];?></td>
            		
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
	$.get("<?php echo $this->createUrl('InfoStock/delete');?>?id="+id,function(jsonstr){
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