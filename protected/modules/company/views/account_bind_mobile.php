<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>  
<?php 
if(!isset($page['info'])){
	$page['info']['birth_day']='';
   $page['info']['sex']='';
   $page['info']['constellation']='';
   $page['info']['signature']='';
   $page['info']['tou_img']='';

}
?>  
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            <div class="site-title">绑定手机号</div>
            <div class="help_con">
				<div class="jfjl">
				<?php if($page['user']['uphone_verify']==1){?>
				<div class="mt10">当前已绑定手机号</div>
				<table class="tb_up">
				
					<tr>
			            	<td width="100">我的手机号：</td>
			                <td><div style="font-size:16px;color:#f30;font-weight:bold;"><?php echo $page['user']['uphone']?></div> </td>
			            </tr>
				</table>
				
				<?php }else{?>
		        <form name="form1"  method="post"  onsubmit="bind_cellphone();return false;">
			        <table class="tb_up">
			            <tr>
			            	<td width="100">输入手机号：</td>
			                <td><input type="text"  class="inputBg"  name="cellphone" id="cellphone" value="<?php echo $page['user']['uphone'];?>" /> </td>
			            </tr>
			            <tr>
			            	<td>图片验证码：</td>
			                <td><input type="text" maxlength="4"  class="inputBg size100"  name="cellphone_rancode" id="cellphone_rancode" size="10"  style="margin-top:6px;"/>
			     			 <img src="<?php echo $this->createUrl('verifyCode/index')?>?type=get_cellphone_rancode"   onClick="refresh_rancode('#img0033')" id="img0033" /> 看不清？<a href="#" onclick="refresh_rancode('#img0033')">换一张</a> </td>
			            </tr>
			            
			            <tr>
			                <td>短信验证码：</td>
			                <td><input type="text"  class="inputBg size100"  maxlength="6"  size="10" name="cellphone_verify_code" id="cellphone_verify_code" value=""  /> <input type="button" value="点击获取" id="clickgetbtn01" onclick="sent_cellphone_message();" autocomplete="off" /> 
			                <span id="cellstate"></span> <span id="trysendtimebox"></span>
			                </td>
			            </tr>
			            
			            <tr>
			            	<td></td>
			                <td>
			                    <input type="submit" class="btn06" value="确定" /> <span id="verifystate"></span>
			                </td>
			            </tr>
			        </table>
			    </form>
			    <?php }?>
			    
		        </div>
		    </div>
       </div>
 </div>

<?php include(dirname(__FILE__)."/foot.php")?>

</body>
</html>