<div class="dialog-login-box">
	<div class="userlogin">
		<div class="global-tit-d-u"><h3>登陆水来了</h3>
		</div>
	  	
		<form id="form_login" method="post" onSubmit="return ck_user_login('','dialog_login_ok()')">
		  <table width="390" height="68" border="0" cellpadding="0" cellspacing="0">
			<tr>
			  <td width="80" height="50" align="right">用户名：</td>
			  <td width="220"><input class="text05" name="username" type="text" id="login_uname"></td>
			  <td width="90">&nbsp;</td>
			</tr>
			<tr>
			  <td height="50" align="right">密 码：</td>
			  <td><input  class="text05" name="password" type="password" id="login_upass"></td>
			  <td></td>
			</tr>
			<tr>
			  <td height="50" align="right">验证码：</td>
			  <td colspan=2><input  class="text05"  name="password" type="text" id="login_rancode" style="width:100px;"><img src="<?php echo $this->createUrl('verifyCode/index');?>?type=get_login_rancode" onClick="refresh_rancode('#img0033')" id="img0033" /> <a href="#" onclick="refresh_rancode('#img0033')">换一张</a>  <a href="<?php echo $this->createUrl('site/forgetpassword');?>">忘记密码？</a></td>
			</tr>
			<tr>
			  <td height="50">&nbsp;</td>
			  <td  height="50" colspan=2><input  type="submit" class="l-sub" value="登 陆"> <span id="login_state"></span></td>
			</tr>
		  </table>
		
		</form>
	  </div>
	<div class="login-right">
		<div class="l-zhuce"><span class="none-text">还没有账号？</span><a href="<?php echo $this->createUrl('site/reg');?>"><img src="/static/user/images/ljzc.jpg"></a></div>
		<div class="qitlog">
			<div class="l-tips">其他登陆方式：</div>
			<a href="<?php echo $this->createUrl('post/qqLogin');?>" title="QQ登陆"><img src="/static/user/images/qq_login.png"></a><br>
			<a href="<?php echo $this->createUrl('post/weiboLogin');?>" title="微博登陆"><img src="/static/user/images/weibo_login.png"></a><br>
			<?php /* ?>
			<a href="<?php echo $this->createUrl('post/taobaoLogin');?>" title="淘宝登陆"><img src="/static/default/images/login_taobao_btn.jpg"></a>
			<?php */?>
		</div><!--qitlog end-->
	</div><!--log_rig end-->
	<div class="clear"></div>
 </div>

