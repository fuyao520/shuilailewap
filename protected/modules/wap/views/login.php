<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<div class="regmain loregmain">
	<div class="main">
		<div class="box">
			<dl class="userlogin">
				<dt>会员登录</dt>
			  <dd>
			  	<?php if($page['connect_data']['type']){?>
			  	<div class="media-user-box">
			  	  <?php if($page['connect_data']['tou_img']){?>
			  	  <img src="<?php echo $page['connect_data']['tou_img'];?>" width=30 height=30>
			  	  <?php }?>
			  	  	<?php echo $page['connect_data']['nickname'];?>，您已经登陆<?php echo $page['connect_data']['name'];?>，首次登陆需要绑定本站账号
			  	</div>
			  	<?php }?>
				<form id="form_login" method="post" onSubmit="return ck_user_login('<?php echo $page['connect_data']['type']; ?>')">
				  <table width="390" height="68" border="0" cellpadding="0" cellspacing="0">
					<tr>
					  <td width="80" height="50" align="right">用户名：</td>
					  <td width="220"><input class="inbg" name="username" type="text" id="login_uname"></td>
					  <td width="90">&nbsp;</td>
					</tr>
					<tr>
					  <td height="30" align="right">密 码：</td>
					  <td><input class="inbg" name="password" type="password" id="login_upass"></td>
					  <td></td>
					</tr>
					<tr>
					  <td height="30" align="right">验证码：</td>
					  <td colspan=2><input class="inbg" name="password" type="text" id="login_rancode" style="width:100px;"><img src="<?php echo $this->createUrl('verifyCode/index');?>?type=get_login_rancode" onClick="refresh_rancode('#img0033')" id="img0033" /> <a href="#" onclick="refresh_rancode('#img0033')">换一张</a>  <a href="<?php echo $this->createUrl('site/forgetpassword');?>">忘记密码？</a></td>
					</tr>
					<tr>
					  <td height="17">&nbsp;</td>
					  <td colspan=2><input name="" type="submit" class="drok" value="登 录"> <span id="login_state"></span></td>
					</tr>
				  </table>
				
				</form>
			  </dd>
			</dl><!--userlogin end-->
			<div class="log_rig">
				<div class="zhzc"><span>还没有账号？</span><a href="<?php echo $this->createUrl('site/reg');?>?connect=<?php echo $page['connect_data']['type'];?>"><img src="/static/user/images/ljzc.jpg"></a></div>
				<div class="qitlog">
					<span>你也可以通过以下途径登录</span>
					<a href="<?php echo $this->createUrl('post/qqLogin');?>" title="QQ登陆"><img src="/static/user/images/login_qq_btn.jpg"></a><br>
					<a href="<?php echo $this->createUrl('post/weiboLogin');?>" title="微博登陆"><img src="/static/user/images/login_weibo_btn.jpg"></a><br>
					<?php /* ?>
					<a href="<?php echo $this->createUrl('post/taobaoLogin');?>" title="淘宝登陆"><img src="/static/default/images/login_taobao_btn.jpg"></a>
					<?php */?>
				</div><!--qitlog end-->
			</div><!--log_rig end-->
	  </div><!--box end-->
  </div><!--main end-->
</div><!--regmain end-->


<?php include(dirname(__FILE__)."/common/foot.php")?>


</body>
</html>