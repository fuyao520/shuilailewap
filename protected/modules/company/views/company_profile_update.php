<?php include(dirname(__FILE__)."/head.php")?>
<?php 
if(!isset($page['company'])){
	$page['company']['company_name']='';
	   $page['company']['domain_py']='';
	   $page['company']['seo_title']='';
	   $page['company']['seo_keywords']='';
	   $page['company']['seo_description']='';
	   $page['company']['company_tel']='';
	   $page['company']['email']='';
	   $page['company']['contact']='';
	   $page['company']['company_address']='';
	   $page['company']['info_body']='';
	   $page['company']['company_fax']='';
	   $page['company']['company_about']='';
	   $page['company']['company_logo']='';
	   $page['company']['erweima']='';
	   $page['company']['weibo']='';
	   $page['company']['hours']='';
	   $page['company']['qq']='';
	   $page['company']['business']='';
	   $page['company']['location_x']='114.066074';
	   $page['company']['location_y']='22.548724';
	   $page['company']['scale']='';
	   $page['company']['reg_assets']='';
	   $page['company']['company_banner']='';
	   $page['company']['year']='';
	   $page['company']['qq']='';
	   $page['company']['url']='';
	   $page['company']['business_products']='[]';
	   $page['company']['business_stones']='';
}
$page['company']['business_products']=json_decode($page['company']['business_products'],1);
function checkbrand($ps,$brand2){
	if(!is_array($ps)) return;
	foreach($ps as $brand){
		if($brand==$brand2){
			return 'checked';
		}
	}
}

if($page['company']['location_x']==0 || $page['company']['location_y']==0){
	$page['company']['location_x']=114.066074;
	$page['company']['location_y']=22.548724;
}
?>

<style>
.tb_02 tr th{height:40px;line-height:40px;background:#eee;}
.brandlist09{line-height:22px;}
.brandlist09 label{display:inline-block;width:100px;}
</style>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=FA00ef59da477d2f0a357931222a715a"></script>
<script>
var lbs_map={
		map : null,
		run:function(){
			lbs_map.showmap();
			
		},
		showmap:function (){
			lbs_map.map=new BMap.Map("location-map")
			lbs_map.map.enableScrollWheelZoom();    //启用滚轮放大缩小，默认禁用
			lbs_map.map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
			lbs_map.map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
			lbs_map.map.centerAndZoom(new BMap.Point(<?php echo $page['company']['location_x'];?>,<?php echo $page['company']['location_y'];?>), 14);

			var point = new BMap.Point(<?php echo $page['company']['location_x'];?>,<?php echo $page['company']['location_y'];?>);
			//lbs_map.map.addEventListener("click", lbs_map.show_info);	
			var marker = new BMap.Marker(point);
			lbs_map.map.addOverlay(marker);	
			marker.enableDragging();

			marker.addEventListener("dragend",function(){
			    var marketpoint=marker.getPosition();  //获取一个点
			   // alert(marketpoint.lng+","+marketpoint.lat);   //显示标注移动后的经纬度
			   $("#location_x").val(marketpoint.lng);
			   $("#location_y").val(marketpoint.lat);
			});
		}
}		
$(function(){
	lbs_map.run();
	
})
</script>
<body>


<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>    
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            
            <div class="site-title">
            基本信息设置
			</div>
            <div > 
		        <div class="marindefault">
		        <form action="javascript:void(0);" onsubmit="return false;" id="company_setting_box">
		        <table class="tb_up">
		  			<tr>
		  			<th colspan=2>水站资料</th>
		            </tr>
		            <tr>
		                <td class="zctd">水站名称：</td>
		                <td height=30>
		                <?php echo $page['company']['company_name']; ?>
		                <input type="hidden" disabled class="ipt size400" id="company_name" value="<?php echo $page['company']['company_name']; ?>"/></td>
		            </tr>
		           
		            <tr>
		                <td class="zctd">门店照片：</td>
		                <td>
		                
		                <style>.img08 img{max-width:60px;max-height:60px;_width:60px;_height:60px;}</style>
			             <input type="hidden" id="company_logo" value="<?php echo $page['company']['company_logo'];?>" />
			             <span class="img08" id="company_logo_span">
			             <?php if($page['company']['company_logo']){?>
			             <a href="<?php echo $page['company']['company_logo'];?>" target=_blank><img src="<?php echo $page['company']['company_logo'];?>"></a>
			             <?php }?>
			             </span>
			    		 <script>create_upload_iframe('{"func":"callback_upload","Eid":"company_logo"}');</script>
			               
		                
		                </td>
		            </tr>
		            
		           
	            <tr>
	                <td class="zctd">主营品牌：</td>
	                <td>
	                	<div class="brandlist09">
	                	<?php $brand_cates=Linkage::model()->get_linkage_data(17); ?>
	                	<?php $i=0;foreach($brand_cates as $r){$i++;?>
	                	 <label><input type="checkbox" <?php echo checkbrand($page['company']['business_products'],$r['linkage_id']);?> value="<?php echo $r['linkage_id'];?>" class="business_products" name="business_products[<?php echo $i-1;?>]">  <?php echo $r['linkage_name'];?></label>
	                	<?php }?>
	                	</div>
	                </td>
	            </tr>
	            
	            <tr>
	                <td class="zctd">送水范围：</td>
	                <td>
	                	<div class="brandlist09">
	                		<div class="fl">
	                  			<select multiple id="region_id" name="region_id[]" style="width:200px; height:130px;">
	                  			<?php foreach($page['region_business'] as $r){?>
	                  			<option value="<?php echo $r['region_id'];?>"><?php echo $r['name'];?></option>
	                  			<?php }?>
        		        		</select>
        						
	                  		
	                  		</div>
		                	<div class="fl" style="margin-top:40px;margin-left:10px;">
			                	<span id="t_s_area"></span>
		               			 <span id="t_s_area_load"></span> 
		                   		<script>cg_edit_sele_cc("0","area[]","t_s_area","1","112083",3);</script>
		                   		<input type="button" class="but2" value="添加选中"  onclick="change_post_cate_fun()" >
		                   		<br>
		                   		
		                   		<input type="button" class="but2" value="删除选中"  onclick="del_option()" style="margin-top:10px;">
	                  		</div>
	                  		
	                   
	                	</div>
	                </td>
	            </tr>
		            
					<tr>
		  			<th colspan=2>联系方式</th>
		            </tr>
		            <tr>
		                <td class="zctd">联系电话：</td>
		                <td><input type="text" class="ipt size400" id="company_tel" value="<?php echo $page['company']['company_tel']; ?>" /></td>
		            </tr>
		            <tr>
		                <td class="zctd">QQ：</td>
		                <td><input type="text" class="ipt size400" id="qq" value="<?php echo $page['company']['qq']; ?>"/></td>
		            </tr>
		            <tr>
		                <td class="zctd">联系人：</td>
		                <td><input type="text" class="ipt size400" id="contact" value="<?php echo $page['company']['contact']; ?>" /></td>
		            </tr>
		            <tr>
		                <td class="zctd">门店地址：</td>
		                <td>
		                <textarea id="company_address" style="width:400px; height:50px;"><?php echo htmlspecialchars(stripslashes($page['company']['company_address'])); ?></textarea>
		                
		                </td>
		            </tr>
		            <tr>
		                <td class="zctd">地图定位：</td>
		                <td>
		                <input type="hidden" class="ipt" id="location_x" value="<?php echo $page['company']['location_x']; ?>" />
		                <input type="hidden" class="ipt" id="location_y" value="<?php echo $page['company']['location_y']; ?>" />
		                <div style="color:red;padding:10px;">请拖动地图中红色的标记，进行地理位置的确定</div>
		                <div style="width:100%;height:400px;" id="location-map">
		                	
		                </div>
		                </td>
		            </tr>
		            <tr>
		  			<th colspan=2>水站介绍</th>
		            </tr>
		            <tr>
		                <td class="zctd">水站介绍：</td>
		                <td>
		                <div style="position:relative;margin-right:5px;">
                <textarea id="company_about"  name="company_about"  style="width:100%; height:300px;" ><?php echo stripcslashes(htmlspecialchars($page['company']['company_about']));?></textarea>
					<script>var company_about=$("#company_about").xheditor({skin:'nostyle',"tools":"full"});</script>
                    <span class="upbtn_box" id="upbtn_box"><script>load_editor_upload('company_about');</script></span>
                </div>
		                
		                </td>
		            </tr>
		            
		            <tr>
		                <td class="zctd"></td>
		                <td>
		                	<input type="button" class="btn06" value="提交" onclick="save_company_setting();" /> 
		                	<input type="button"  class="btn06" value="返回" onclick="window.location='<?php echo $this->createUrl('companyProfile/index');?>'" />
		                </td>
		            </tr>
		            
		        </table>
		        </form>
		        </div>
		    </div>
       </div>
 </div>

<?php include(dirname(__FILE__)."/foot.php")?>
<script>
function change_post_cate_fun(){
	try{
		if(!$("#t_s_area select").eq(2).length){
			alert('请选择社区');
			return false;
		}
		var opobj=$("#t_s_area select").eq(2).find("option:selected");//alert(opobj);
		if(opobj.html().match(/选择/)){
			alert('请选择社区');
			return false;
		}
		if(!opobj.val()) return false;
		//alert(2);
		var optioncode=opobj.html();//alert(optioncode);
		var txt=optioncode;
		var optioncode='<option value="'+opobj.val()+'">'+optioncode+'</option>';
		var hhoptions=$("#region_id option");
		for(var i=0; i<hhoptions.length;i++){
		    var vTmp=hhoptions[i].value;//alert(vTmp);
            if(vTmp==opobj.val()){
			    //alert(txt+' ID:'+opobj.val()+'已经存在！')
            	alert(txt+'已经存在！')
			    return false;
			} 	
		}
		$("#region_id").append(optioncode);
	}catch(e){
		console.log(e.message);
	}
}
function del_option(){
     $("#region_id option:selected").remove(); 	
}

function save_company_setting(){
	if($("#company_tel").val()==''){
		alert('联系电话不能为空');	
		return false;
	}
    var postdata=C.form.get_form("#company_setting_box");
	//获取送水范围
	postdata.region_data=[];
	$("#region_id option").each(function(){
		postdata.region_data.push($(this).val());
	});
	//alert($.toJSON(postdata));	return;
	$.post("<?php echo $this->createUrl('companyProfile/update')?>",postdata,function(restr){
	    try{
			var ret=eval("("+restr+")");
			if(ret.code<1){
			    alert(ret.statewords);
				return false;	
			}else{//alert('ok');return;
			    window.location='<?php echo $this->createUrl('companyProfile/index');?>';	
			}
		}catch(e){alert(e.message+restr);}	
	})	
}

</script>


</body>
</html>