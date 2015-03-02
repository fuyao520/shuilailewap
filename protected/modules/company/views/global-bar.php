<div class="global-bar">
	<div class="width clearfix">
		<div class="fl">
			<a href="/" class="backhome">
			<?php if(isset($page['cate']['cate_id'])&&$page['cate']['cate_id']=='home'){?>
			欢迎登陆水来了
			<?php }else{?>
			返回首页
			<?php }?>
			</a>
		</div>
		<div class="fr clearfix">
			 <span id="welcome_box0003"></span>
			 <span id="nologin_box003"> 
		     <a href="<?php echo $this->createUrl("/company/site/login");?>" class="topicon login">登陆</a> 
		     <a href="<?php echo $this->createUrl("/company/site/reg");?>" class="topicon reg">注册</a>	
		     </span> 
		</div>
	</div>
	
</div>


<script>
var userinfo={"isGuest":1,"uname":"","company_name":""};
$.getJSON("<?php echo Yii::app()->params['basic']['siteurl']; ?>company/post/checkLogin?jsoncallback=?",function(json){
    try{
	if(!json.isGuest){
	    $("#welcome_box0003").html(
		'  '+json.company_name+'('+json.uname+')，'+
		'<a href="<?php echo Yii::app()->params['basic']['siteurl']; ?>company/site/index/"> <span class="red">管理中心</span> </a>'+
		'<a href="<?php echo Yii::app()->params['basic']['siteurl']; ?>company/site/logout/"> [退出] </a>'+
		'');	
		$("#nologin_box003").css({"display":"none"});

		userinfo.isGuest=0;
		userinfo.uname=json.uname;
		userinfo.company_name=json.company_name;
		$("#index-u-nologin_box003").css({"display":"none"});
		$("#index-u-uname").html(json.company_name);
		$("#index-u-welcome_box0003").css({"display":""});
		$(".commentnickname").val(json.uname);
	}else{
		$("#nologin_box003").css({"display":""});			
	}	
	}catch(e){alert(e.message);}  
});
$(".publish-bar-box").hover(
	function(){
		$('.publish-bar-main-box').show();
	},
	function(){
		$('.publish-bar-main-box').hide();
	}
	
)
</script>
