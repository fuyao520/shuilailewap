<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>  
<style>
.waterlist-m{width:240px;}
.waterlist-m .img{float:left;}
.waterlist-m img{width:100px;height:100px;border:1px solid #ccc;border:1px solid #eee;}
.waterlist-m span{display:block;font-size:12px;text-align:center;margin:10px;}
.waterlist-m .ftxt{float:left;line-height:20px;padding-left:10px;}
</style>  
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title">编辑主营品牌</div>
            <form name="form1" id="update_info_box" onsubmit="info_save();return false;">
            <table class="tb_up mt10">
            <tr>
            		<td><input type="button" onclick="window.location='<?php echo $this->createUrl('infoWater/index');?>'" class="btn06" value="返回"></td>
            		<td></td>
            			
            	</tr>
            <?php $a=Cms::model()->info_list(array('p'=>$this->get('p'),'cate_id'=>117,'pagesize'=>20,'joinsql'=>"left join company_water as b on b.info_id=l.info_id and b.uid=".Yii::app()->company_user->uid,"selectsql"=>"b.id as wid,l.*"));?>
            	<?php foreach($a['list'] as $r){?>
            		
            	<tr>
            		<td>
            		   <div class="waterlist-m">
            		   	<a class="img" href="<?php echo $r['url'];?>" target="_blank"><img src="<?php echo $r['thumb'];?>">
            		   		
            		   	</a>
            		   	<div class="ftxt">
            		   		<p class="tit"><?php echo $r['title'];?></p>
            		   		<p>品牌：怡宝</p>
            		   		<p>规格：<?php echo $r['guige']==1?'桶装水':'支装水';?></p>
            		   		<p>市场价：<?php echo $r['market_price'];?></p>
            		   		<p>现价：<?php echo $r['now_price'];?></p>
            		   	</div>
            		   	
            		   	
            		   </div>
            		  </td> 
            		<td  width=100>
            		   <input type="checkbox" value="<?php echo $r['info_id'];?>" class="wchecklist" <?php if($r['wid']){echo 'checked';}?>>
            		   
            		</td>
            			
            	</tr>
            	<?php }?>
            	<tr>
            		<td><input type="button" onclick="window.location='<?php echo $this->createUrl('infoWater/index');?>'" class="btn06" value="返回"></td>
            		<td></td>
            			
            	</tr>
            	
            	
            	
            	
            	
            
            </table>
            <div class="clearfix pagebar"><?php echo $a['pagearr']['pagecode'];?></div>
            </form>
           
            
        </div>
    </div>

</div>

<?php include(dirname(__FILE__)."/foot.php")?>
<script>
$(".wchecklist").change(function(){info_save(this);});
function info_save(eobj){
	var type=0;
	if($(eobj).attr("checked")){
		type=1;
	}
	var info_id=$(eobj).val();
    var postdata={"info_id":info_id,"type":type};
	//alert($.toJSON(postdata));	return;
	$.post("<?php echo $this->createUrl('infoWater/update');?>",postdata,function(restr){
	    try{
			var ret=eval("("+restr+")");
			if(ret.state<1){
			    alert(ret.msgwords);
				return false;	
			}else{
			    //window.location='<?php echo $this->createUrl('infoWater/index');?>';	
			}
		}catch(e){alert(e.message+restr);}	
	})
	return false;
}



function callback_upload33(ret){
	try{
		//alert(ret);
		var json=$.evalJSON(ret);
		var id=json.params.id;
		//alert(id);
		if(json.files.length<=0) {
			alert('上传失败');
			return false;
		}
		$(".rrrurl"+id).val(json.files[0].original);
		if(json.files[0].original.match(/(\.doc)|(\.docx)|(\.xls)|(\.xlsx)/)){
			$("#ssimg"+id).html('<a style="display:inline-block;background:#fbf9f4;color:blue;padding:5px 2px;width:200px;overflow:hidden;" href="'+json.files[0].original+'" target="_blank">'+json.files[0].oname+'.'+json.files[0].extension+'</a>');
		}else{
	    	$("#ssimg"+id).html('<a href="'+json.files[0].original+'" target="_blank"><img src="'+json.files[0].original+'" style="max-width:50px;max-height:50px;" /></a>');
		}
	}catch(e){
		alert('err:'+e.message);
	}
}
</script>


</body>
</html>