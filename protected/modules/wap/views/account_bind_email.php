<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['birth_day']='';
   $page['info']['sex']='';
   $page['info']['constellation']='';
   $page['info']['signature']='';
   $page['info']['tou_img']='';

}
?>
   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
        <div class="help_rig">
			<div class="laction"><h2>绑定邮箱</h2> <span></span></div><!--laction end-->
            <div class="help_con">
				<div class="jfjl">
				<?php if($page['user']['uemail_verify']==1){?>
				<div class="mt10">当前已邮箱</div>
				<table class="tb_up">				
					<tr>
			            	<td width="100">我的邮箱：</td>
			                <td><div style="font-size:16px;color:#f30;font-weight:bold;"><?php echo $page['user']['uemail']?></div> </td>
			            </tr>
				</table>
				
				<?php }else{?>
		        <form name="form1"  method="post"  onsubmit="return bind_email();">
			        <table class="tb_up">
			            <tr>
			            	<td width="100">邮箱：</td>
			                <td><input type="text"  class="inputBg"  name="uemail" id="uemail" value="<?php echo $page['user']['uemail'];?>" /> </td>
			            </tr>
			            <tr>
			            	<td>图片验证码：</td>
			                <td><input type="text" maxlength="4"  class="inputBg size100"  name="email_rancode" id="email_rancode" size="10"  style="margin-top:6px;"/>
			     			 <img src="<?php echo $this->createUrl('verifyCode/index')?>"   onClick="refresh_rancode('#img0033')" id="img0033" /> 看不清？<a href="#" onclick="refresh_rancode('#img0033')">换一张</a> </td>
			            </tr>
			            
			            <tr>
			                <td>邮箱验证码：</td>
			                <td><input type="text"  class="inputBg size100"  maxlength="6"  size="10"  id="email_verify_code" value=""  /> <input type="button" value="点击获取" id="clickgetbtn01" onclick="sent_email_message();" autocomplete="off" /> 
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
 </div>
 </div>

<?php include(dirname(__FILE__)."/common/foot.php")?>

</body>
</html>