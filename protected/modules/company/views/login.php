<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<div class="width-u">
    <div class="clearfix mt10">
        <a href="/" class="logo">企业中心</a>
    </div>
    
    <div class="user-login-box clearfix">
    	<div class="fl">
        	<img src="/static/company/images/banner-u.jpg" />
        	
        </div>
        <div class="fr">
        	<div class="user-desc">欢迎加入成为企业</div>
            <div class="user_form">
                <div class="user-tit clearfix">
                    <a href="#" class="current">企业用户登录</a>
                    <a href="<?php echo $this->createUrl('site/reg'); ?>">企业用户注册</a>	
                </div>
                <?php if($page['connect_data']['type']){?>
			  	<div class="media-user-box">
			  	  <?php if($page['connect_data']['tou_img']){?>
			  	  <img src="<?php echo $page['connect_data']['tou_img'];?>" width=30 height=30>
			  	  <?php }?>
			  	  	<?php echo $page['connect_data']['nickname'];?>，您已经登陆<?php echo $page['connect_data']['name'];?>，首次登陆需要绑定本站账号
			  	</div>
			  	<?php }?>
                <form id="form_login" method="post" onSubmit="return ck_company_login('<?php echo $page['connect_data']['type']; ?>')">
                   <div><span class="zc"></span><span id="login_state"></span> </div>
                   <div><span class="zc">用户名</span><input type="text"  class="inputBg input01" id="login_uname" value="<?php echo $this->get('uname');?>"/></div>
                   <div><span class="zc">密码</span><input type="password" class="inputBg input02" id="login_upass" value="<?php echo $this->get('upass');?>"/></div>
                   <div><span class="zc">验证码</span>
                   <input type="text"  class="inputBg size100"   name="login_rancode" id="login_rancode" style="width:100px;"/> <img src="<?php echo $this->createUrl('verifyCode/index');?>" onClick="refresh_rancode('#img0033')" id="img0033" /> 看不清？<a href="#" onclick="refresh_rancode('#img0033')">换一张</a></div>
                   <div><span class="zc"></span><input type="submit"  class="btn0100" value="登录" id="sublogin" /> <br>
                        <div class="mt10"><a style="display:none;" href="<?php echo $this->createUrl('site/forgetpassword');?>" >忘了密码？</a>   <a href="<?php echo $this->createUrl('site/reg');?>?connect=<?php echo $page['connect_data']['type']; ?>" >新用户注册</a>  </div>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(dirname(__FILE__)."/foot.php")?>


</body>
</html>