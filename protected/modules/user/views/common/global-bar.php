<div class="global-bar">
	<div class="head width clearfix">
		<h1 class="zfy fl"><a href="/" class="backhome">返回首页</a>  </h1>
		<div class="lotext fr">
			<span id="welcome_box0003"></span>
			<span id="nologin_box003">
			<a href="<?php echo $this->createUrl('/user/site/login');?>">登录</a> | <a href="<?php echo $this->createUrl('/user/site/reg');?>">注册</a> 
			<a href="<?php echo $this->createUrl('/user/post/qqLogin');?>"><img src="/static/user/images/qq.jpg"></a> 
			<a href="<?php echo $this->createUrl('/user/post/weiboLogin');?>"><img src="/static/user/images/xr.jpg"></a>
			</span>
		</div>
			
		<div class="text fr">
			<a href="<?php echo $this->createUrl('/user/site/index');?>" class="hyzx">会员中心</a>
			<a href="<?php echo $this->createUrl('/user/collect/index');?>" class="wdxh">我的收藏</a>
		</div><!--text ned-->
	</div><!--head ned-->
</div>
<div class="clear"></div>
<script>
var userinfo={"isGuest":1,"uname":"","company_name":""};
check_login();
</script>