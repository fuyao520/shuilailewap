<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>   
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title">站内信</div>
            <table class="tb_up mt10">
            	<tr>
            		<td>时间：</td>
            		<td><?php echo date('Y-m-d H:i:s',$page['info']['post_date']);?></td>
            	</tr>
            	<tr>
            		<td>标题：</td>
            		<td><?php echo $page['info']['pm_title'];?></td>
            	</tr>
            	<tr>
            		<td>内容：</td>
            		<td><?php echo $page['info']['pm_body'];?></td>
            	</tr>
            	
            	<tr>
            		<td></td>
            		<td><input type="button" onclick="window.location='<?php echo $this->createUrl('pmList/index');?>'" class="btn06" value="返回"></td>
            			
            	</tr>
            </table>
            
            
            
        </div>
    </div>

</div>
<?php include(dirname(__FILE__)."/foot.php")?>

</body>
</html>