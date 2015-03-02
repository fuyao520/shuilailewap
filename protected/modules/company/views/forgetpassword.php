<?php include(dirname(__FILE__).'/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/global-bar.php'); ?>
<div class="width-u">
    <div class="clearfix mt10">
        <a href="/" class="logo">石材团购网</a>
        <b class="welcome_login">企业平台中心</b>
    </div>
    
	<div class="user_form2">
		<div class="site-title">找回密码</div>
	  <dd>
	    <form method="post" name="form_forget"  onsubmit="ck_forgetpassword();return false;" id="form_forget">
		      <table width="565" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="141" height="30" align="right">你注册的邮箱：</td>
                  <td><input  class="inbg" type="text" placeholder="请输入您的邮箱"  id="forgetmail"> <span id="mail_forget_state_inner"></span></td>
                </tr>
                <tr>
                  <td height="30" align="right">验证码：</td>
                  <td><input  class="inbg" type="text" id="forancode" style="width:100px;"> <img src="<?php echo $this->createUrl('verifyCode/index')?>?type=get_forgetpassword_rancode" class="rancode_img" id="rancode_img33" onClick="refresh_rancode('rancode_img33')" /> <a href="javascript:void(0);" onClick="refresh_rancode('rancode_img33')">刷新</a>   <span id="racode_forget_state_inner"></span></td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td><input class="fsyj" type="submit" id="forgetpassword_sub"  value="发送验证邮件"><span id="forget_state_inner"></span></td>
                </tr>
              </table>
            </form>
				

		  </dd>
	  </div><!--aqzx_zhmm end-->
  </div><!--main end-->
</div><!--regmain end-->

<?php include(dirname(__FILE__)."/foot.php")?>
</body>
</html>