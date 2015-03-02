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
				<div class="laction"><h2>收货地址管理</h2> <span></span></div><!--laction end-->
	           
	            <div class="mt10">
	            	<input type=button class="btn03" value="添加地址" onclick="location='<?php echo $this->createUrl('recvAddress/update');?>'">
	            </div>
	            <table class="tb_list mt10">
	            	<tr>
	            		<th width=100>联系人</th>
	            		<th width=100>手机号</th>
	            		<th class="zc">联系地址</th>
	            		<th>默认</th>
	            		<th width=160>操作</th>    		
	            	</tr>
	            	<?php foreach($page['listdata']['list'] as $r){?>
	            	<tr>            		
	            		
	            		<td><?php echo $r['recv_contact'];?></td>
	            		<td><?php echo $r['recv_cellphone'];?></td>
	            		<td class="zc">
	            		<div style="width:320px;line-height:18px;">
	            		<?php echo $r['recv_address'];?>
	            		</div>
	            		</td>
	            		
	            		<td><?php if($r['is_default']==1){echo '<font color="green" size=+1>√</font>';}?></td>
	            		<td>
	            			<a href="<?php echo $this->createUrl('recvAddress/update');?>?id=<?php echo $r['recv_address_id'];?>">修改</a>
	            			<a onclick="delete_info(<?php echo $r['recv_address_id'];?>)" href="javascript:void(0);">删除</a>
	            			<a href="javascript:void(0);" onclick="set_default_recv_address(<?php echo $r['recv_address_id']; ?>)" >设为默认</a>
	            		</td>
	            	</tr>
	            	<?php }?>
	            
	            </table>
	            
	            <div class="clearfix pagebar"><?php echo $page['listdata']['pagearr']['pagecode'];?></div>
	            
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
//把收货地址设置为默认
function set_default_recv_address(recv_address_id){
	var postdata={id:recv_address_id};
	$.post("<?php echo $this->createUrl('recvAddress/setDefault')?>",postdata,function(data){																						
		try{
		var json=eval('('+data+')');
		if(json.state>0){
			window.location.reload();
		}else{
		    alert(json.msgwords);	
		}
		}catch(e){alert(e.message);}																						 
	})
}
</script>
</body>
</html>