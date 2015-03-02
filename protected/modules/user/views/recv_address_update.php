<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['recv_address_id']='';
	$page['info']['recv_contact']='';
	$page['info']['recv_address']='';
	$page['info']['recv_cellphone']='';
}
?>

<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>


<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>	
	        <div class="help_rig">
				<div class="laction"><h2>收货地址管理</h2> <span></span></div><!--laction end-->
	            
	     		
	            
	          <script>
function ck_recv_address2(){
    try{
		if($(".level_1").val()==''){
			alert('请选择省份');
			return false;
		}
		if($(".level_2").val()==''){
			alert('请选择城市');
			return false;
		}
		if($(".level_3").val()==''){
			alert('请选择区域');
			return false;
		}
		$("#province_txt").val($(".level_1 option:selected").text());
		$("#city_txt").val($(".level_2 option:selected").text());
		$("#area_txt").val($(".level_3 option:selected").text());
	}catch(e){alert(e.message);}	
}
</script>
   
   <div class="condefaultpx03">
   <form action="javascript:void(0);" id="update_info_box"  method="post" onsubmit="info_save();return false;">
   		<input type="hidden" id="id"  value="<?php echo $page['get']['recv_address_id']; ?>" />
		<div class="condefaultpx03">
			<table class="tb_up mt10">
			  <tr height="30"> 
				<td width="80" align="right">收 货 人 :</td>
				<td><input class="ipt"  name="recv_contact" id="recv_contact" type="text" style="width:200px;" value="<?php echo $page['info']['recv_contact']; ?>" /> <font color="#FF0000">*</font></td>
			  </tr>
			  <tr height="30">
				<td width="80" align="right">手 机 号 : </td>
				<td><input class="ipt"  name="recv_cellphone" id="recv_cellphone" type="text" style="width:200px;"  value="<?php echo $page['info']['recv_cellphone']; ?>" /> <font color="#FF0000">*</font></td>
			  </tr>
			  <tr height="30">
				<td width="80" align="right">联系地址 : </td>
				<td>
                <input class="ipt"  name="recv_address" id="recv_address" type="text"  value="<?php echo $page['info']['recv_address']; ?>" /> <font color="#FF0000">*</font></td>
              </tr>
              
              
			  <tr height="30">
				<td align="right"> 
				
				</td>
				<td align="left">
					<input type="submit" value="保存"  name="button" class="btn03" >
   					<input type="button" value="返回"  class="btn03" onclick="location.href='<?php echo $this->createUrl('recvAddress/index'); ?>'" >
			  </tr>
			</table>

		</div>
	</form>
    </div>
	            
	        </div>
	        </div>
    </div>

</div>
<?php include(dirname(__FILE__)."/foot.php")?>

<script>
function delete_info(id){
	if(!confirm('确定吗？')) return false;
	$.get("<?php echo $this->createUrl('recvAddress/delete');?>?id="+id,function(jsonstr){
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
function info_save(){
    var postdata=C.form.get_form("#update_info_box");
	//alert($.toJSON(postdata));	return;
	$.post("<?php echo $this->createUrl('recvAddress/update');?>",postdata,function(restr){
	    try{
			var ret=eval("("+restr+")");
			if(ret.state<1){
			    alert(ret.msgwords);
				return false;	
			}else{
			    window.location='<?php echo $this->createUrl('recvAddress/index');?>';	
			}
		}catch(e){alert(e.message+restr);}	
	})
	return false;
}

</script>
</body>
</html>