<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<div class="regmain">
	<div class="main">
		<dl class="aqzx_zhmm">
			<dt><h2>安全中心-重置密码</h2></dt>
		  <dd>	
		    <form action="" method="post" name="zhmm" id="zhmm" onSubmit="ck_reset_password();return false;">
		    <input type="hidden" id="forget_pass_code" name="forget_pass_code" value="<?php echo $page['user']['forget_pass_code']; ?>" />
		     <input type="hidden"  id="uid" value="<?php echo $page['user']['uid']; ?>" /> 
		      <table width="465" border="0" cellspacing="0" cellpadding="0">
		      	
                <tr>
                  <td width="142" height="30" align="right">账号：</td>
                  <td><?php echo $page['user']['uname'];?></td>
                </tr>
                <tr>
                  <td height="30" align="right">请输入新密码：</td>
                  <td><input  id="resetpassword" class="inbg" type="password"><span id="resetpassword_msg_inner"></span></td>
                </tr>
                <tr>
                  <td height="30" align="right">请再次输入新密码：</td>
                  <td><input id="resetpassword2" class="inbg" type="password" > <span id="resetpassword2_msg_inner"></span></td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td><input class="fsyj" type="submit" id="resetpassword_sub" value="立 即 修 改">
                  	<span id="resetpassword_state_inner"></span>
                  </td>
                </tr>
              </table>
            </form>

		  </dd>
		</dl><!--aqzx_zhmm end-->
  </div><!--main end-->
</div><!--regmain end-->

<?php include(dirname(__FILE__)."/common/foot.php")?>
</body>
</html>