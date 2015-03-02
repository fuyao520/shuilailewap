<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>

<div class="regmain loregmain">
	<div class="main">
		<div class="box">
			<dl class="userlogin" style="width:auto;float:none;">
				<dt>注册会员</dt>
			  <dd>
			  	<?php if($page['connect_data']['type']){?>
			  	<div class="media-user-box">
			  	  <img src="<?php echo $page['connect_data']['tou_img'];?>" width=30 height=30>	<?php echo $page['connect_data']['nickname'];?>，您已经登陆<?php echo $page['connect_data']['name'];?>，注册成功将会绑定本账号
			  	</div>
			  	<?php }?>
				<form id="form_reg" method="post" autocomplete="off"  onsubmit="return ck_user_reg('<?php echo $page['connect_data']['type']; ?>')" autocomplete="off">
				  <table width="98%" height="204" border="0" cellpadding="0" cellspacing="0">
					<tr>
					  <td width="80" height="50" align="right">用户名：</td>
					  <td><input class="inbg" name="username" type="text" id="uname" >
					  	<span class="red">* 4-20位，可由汉字、数字、字母和“_”组成，注册成功后用户名不可修改</span>
					  </td>
				    </tr>
					<tr>
					  <td height="30" align="right">密 码：</td>
					  <td><input class="inbg" name="upass" type="password" id="upass"> <span class="gray">*6-16个字符组成，区分大小写</span></td>
				    </tr>
					<tr>
                      <td height="30" align="right">确认密码：</td>
					  <td><input class="inbg" name="upass2" type="password" id="upass2"></td>
				    </tr>
					<tr>
                      <td height="30" align="right">电子邮箱：</td>
					  <td><input class="inbg" name="uemail" type="text" id="uemail"> <span class="gray">* 请输入常用邮箱</span></td>
				    </tr>
					<tr>
                      <td height="30" align="right">验证码：</td>
					  <td><input class="inbg" name="reg_rancode" type="text" id="reg_rancode" style="width:50px;">
					  <img src="<?php echo $this->createUrl('verifyCode/index');?>?type=get_reg_rancode" onClick="refresh_rancode('img0022')" id="img0022" />
           看不清？<a href="#" onClick="refresh_rancode('#img0022')">换一张</a>
					  </td>
				    </tr>
					<tr>
                      <td height="17">&nbsp;</td>
					  <td class="syxy">注册即接受《<a  href="#">使用协议</a>》</td>
					</tr>
					<tr>
					  <td height="17">&nbsp;</td>
					  <td><input name="" type="submit" class="drok" value="立即注册"> <span  id="reg_state"></span></td>
				    </tr>
				  </table>
				
				</form>
			  </dd>
			  
			</dl><!--userlogin end-->
			
	  </div><!--box end-->
  </div><!--main end-->
</div><!--regmain end-->





<?php include(dirname(__FILE__)."/common/foot.php")?>

</body>
</html>