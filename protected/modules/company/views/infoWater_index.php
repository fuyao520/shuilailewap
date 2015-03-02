<?php include(dirname(__FILE__)."/head.php")?>
<style>
.waterlist-m{width:240px;}
.waterlist-m .img{float:left;}
.waterlist-m img{width:100px;height:100px;border:1px solid #ccc;border:1px solid #eee;}
.waterlist-m span{display:block;font-size:12px;text-align:center;margin:10px;}
.waterlist-m .ftxt{float:left;line-height:20px;padding-left:10px;}
</style>  
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>     
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title">我经营的饮水品牌</div>
           
            <div class="mt10">
            	<input type=button class="btn03" value="编辑" onclick="location='<?php echo $this->createUrl('infoWater/update');?>'">
            </div>
            <table class="tb_up mt10">
            	</tr>
            	<?php foreach($page['listdata']['list'] as $r){?>
            		
            	<tr>
            		<td>
            		   <div class="waterlist-m">
            		   	<a class="img" href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['thumb'];?>">
            		   		
            		   	</a>
            		   	<div class="ftxt">
            		   		<p class="tit"><?php echo $r['info_title'];?></p>
            		   		<p>品牌：怡宝</p>
            		   		<p>规格：<?php echo $r['guige']==1?'桶装水':'支装水';?></p>
            		   		<p>市场价：<?php echo $r['market_price'];?></p>
            		   		<p>现价：<?php echo $r['now_price'];?></p>
            		   	</div>
            		   	
            		   	
            		   </div>
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