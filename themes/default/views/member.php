<?php
if($page['member']['is_login']==1 && $page['get']['m']!='activation'){		 	
	header("location:member_center.php");
}
$page['get']['url']=isset($page['get']['url'])?helper::escape($page['get']['url']):'';
if(!preg_match('~^http://~',$page['get']['url'])){
    $page['get']['url']='';	
}
?>
<?php $page['relation_cate_top']['cate_id']='member'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Yii::app()->params['basic']['sitename']; ?></title>
<link href="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/clud_zoom/clud_zoom.css" />
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/js/common.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.external.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/clud_zoom/cloud_zoom.1.0.2.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/artDialog4.1.7/artDialog.js?skin=idialog"></script>

</head>
<body>
<input type="hidden" id="history_url" value="<?php echo $page['get']['url']; ?>" />

<?php include(dirname(__FILE__).'/common/head.php'); ?>
<div class="width breadnav">
    <a href="/">首页</a> » 
    <?php echo $page['snav']; ?>
</div>

<div class="wrap width mt10 clearfix">
   <?php 
if(function_exists("tpl__".$page['get']['m'])){
   call_user_func("tpl__".$page['get']['m']);
}
?>
</div>
    
<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>>

</body>
</html>



<?php 
function tpl__show_reg(){
	global $config,$page; 
?>
<div class="site-title">注册</div>
<div class="user_form">
  <form id="form_reg" method="post" autocomplete="off"  onsubmit="return ck_reg()">
      <div><span class="zc"></span><span  id="reg_state"></span> </div>
      <div><span class="zc"> 帐　　号：</span><input type="text" class="inputBg"  id="uname"/></div>
      <div><span class="zc">邮　　箱：</span><input type="text" class="inputBg" id="email"/></div>
      <div><span class="zc">密　　码：</span><input type="password" class="inputBg" id="upass"/></div>
      <div><span class="zc">确认密码：</span><input type="password" class="inputBg" id="upass2"/></div>
      <div><span class="zc">验证码：</span><input type="text"  class="inputBg size100"  name="reg_rancode" id="reg_rancode" size="10"  style="margin-top:6px;"/>
      <img src="/post.php?m=get_img_rancode&type=get_reg_rancode" onClick="refresh_rancode('img0022')" id="img0022" /></div>
      <div><span class="zc"></span><input type="submit"  id="sub01" class="btn03" value="确定注册" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/images/zhuce.jpg"  />
      <a href="member.php?m=show_login&url=<?php echo $page['get']['url']; ?>"> 我要登录 »</a></div>
  </form>
</div>
<?php }?>
  <?php 
function tpl__reg_ok(){ 
global $config,$page,$c;
?>
  <div class="width" style="font-size:24px; font-weight:bold; color:green;">恭喜你，注册成功！现在就登录吧~
  <script>window.location='/member.php?m=show_login'</script>
  </div>
  <?php }?>
              
  <?php 
function tpl__show_login(){ 
global $config,$page,$c;
?>
<div class="site-title">登录</div>
<div class="user_form">
    <form id="form_login" method="post" onSubmit="return ck_login()">
       <div><span class="zc"></span><span id="login_state"></span> </div>
       <div><span class="zc">帐　　号：</span><input type="text"  class="inputBg" id="login_uname"/></div>
       <div><span class="zc">密　　码：</span><input type="password" class="inputBg" id="login_upass"/></div>
       <div><span class="zc">验证码：</span><input type="text"  class="inputBg size100"   name="login_rancode" id="login_rancode" size="10"/> <img src="/post.php?m=get_img_rancode&type=get_login_rancode" onClick="refresh_rancode('img0033')" id="img0033" /></div>
       <div><span class="zc"></span><input type="submit"  class="btn03" value="登录" id="sublogin" /> <a href="member.php?m=forgetpassword" >忘了密码？</a>   <a href="member.php?m=show_reg" >新用户注册</a>  
       </div>
    </form>
</div>
  <?php }?>
<?php function tpl__forgetpassword(){?>
  <div class="site-title">找回密码</div>
  <div class="user_form">
  <form method="post" name="form_forget"  onsubmit="return ck_forgetpassword();" id="form_forget">
      <div><span class="zc">电子邮箱：</span><input type="text" size="20" class="inputBg" id="forgetmail" maxlength="20" name="email"><span id="mail_forget_state_inner"></span></div>
      <div><span class="zc">验证码：</span><input id="forancode" name="randcode" class="inputBg size100" type="text" style="width:50px;" maxlength="4"> <img src="imgcode.php?m=get_forgetpassword_rancode" class="rancode_img" id="rancode_img33" onClick="refresh_rancode('rancode_img33')" /> <a href="javascript:void(0);" onClick="refresh_rancode('rancode_img33')">刷新</a>   <span id="racode_forget_state_inner"></span></div>
      <div><span class="zc"></span><input type="submit" id="forgetpassword_sub" class="btn03"   value="发送验证"/>  <span id="forget_state_inner"></span></div>
   </form> 
<?php }?>

<?php function tpl__forgetpassword_sendemail_ok(){ ?>
<div class="width">
	<div><span class="ok2">邮件已成功发送到您的邮箱，请登录您的邮箱点击链接进行修改密码！ </span><a href="member.php"> &gt;&gt;登录</a></div>
</div>
<?php } ?>

<?php function tpl__reset_password(){ 
global $page;
?>
<p class="site-title">重置密码</p>

	<div class="resetpassword_box">
    <form method="post" id="form_resetpassword"  name="form_resetpassword" action="member.php?m=save_reset_password" onSubmit="return ck_reset_password();">
    <input type="hidden" id="forget_pass_code" name="forget_pass_code" value="<?php echo $page['member']['forget_pass_code']; ?>" />
    <input type="hidden" id="member_id" name="member_id" value="<?php echo $page['member']['uid']; ?>" />
    <?php echo $page['member']['uname']; ?>
    密码：<input class="inputBg" id="resetpassword" type="password" name="password"  /></td><td><span class="red">*</span><span id="resetpassword_msg_inner"></span>
    确认密码：<input class="inputBg" id="resetpassword2" type="password" name="password2" /></td><td><span class="red">*</span> <span id="resetpassword2_msg_inner"></span>
    <input type="submit" id="resetpassword_sub"  class="btn03"  value="修改密码"/> <span id="resetpassword_state_inner"></span>
         
    </form>
    </div>
<?php } ?>


<?php 
function tpl__reset_password_ok(){
	global $page;
?>

<div class="width mbody">
	<div><span class="ok2"><span class="ok_iconv"></span>您已成功修改您的密码！正转向<a href="member.php"> &gt;&gt;登录</a> </span></div>
    <script>setTimeout(function(){window.location='member.php'},2000)</script>
</div>
<?php 
}
?>
 <?php 
function tpl__activation(){
	global $page;
?>
<div class="width mbody">
    <?php 
    if($page['activation']['result']==1){
    ?>
     <div><span class="ok2" style="font-size: 18px; color:green;" > 恭喜您，您的帐号已激活！10秒后跳转到<a href="member.php">登录</a></span></div>
     <script>setTimeout(function(){window.location='member.php'},10000)</script>
    <?php 
    }
    ?>
    <?php 
    if($page['activation']['result']==0){
    ?>
    <div style="color:#F00; font-size:14px;">您访问的地址有误！，3秒后跳转到登录</div>
      <script>setTimeout(function(){window.location='member.php'},3000)</script>
    <?php 
    }
    ?>
</div>    
<?php 
}
?>

