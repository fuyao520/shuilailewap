<div class="head-bg02">
	<div class="global-bar">
		<div class="head width clearfix">
			<div class="lotext fr">
				<span id="welcome_box0003"></span>
				<span id="nologin_box003">
				 <a href="<?php echo $this->createUrl('/user/site/login');?>"> 登录</a> <a href="<?php echo $this->createUrl('/user/site/reg');?>">注册</a> | 
				<a href="<?php echo $this->createUrl('/user/post/qqLogin');?>">QQ登陆</a> 
				<a href="<?php echo $this->createUrl('/user/post/weiboLogin');?>">微博登陆</a> |
				<a href="<?php echo $this->createUrl('/user/site/index');?>" class="hyzx">会员中心</a> 
				<a href="<?php echo $this->createUrl('/user/collect/index');?>" class="wdxh">我的收藏</a> | 
				</span>
			</div>
				<!--text ned-->
		</div><!--head ned-->
	</div>
	<div class="clear"></div>
	
	<div class="com-head">
	    <div class="m-cd pr clrfix">
	        <a class="logo-s" href="/"></a>
	        <div class="search">
	            <input class="inp" type="text" placeholder="请输入水的品牌" id="k2" value="" brdid="" />
	            <input class="s-btn" type="button" id="btnSearch"/>
	            <div id="suggest_wrapper" style="width:282px;display:none;"></div>
	            <div id="brand_wrapper" class="pc_brank no-idx" style="width:392px;top:46px;margin-left:292px;display:none;">
	                <ul class="word-l yahei">
	                <?php foreach($brand_cates as $r){?>
	                     <li class="aw" title="<?php echo $r['linkage_name'];?>" brdid="1" style="color:#000000"><?php echo $r['linkage_name'];?></li>
	                <?php }?>
	                 </ul>
	            </div>
	        </div>
	        
	        <div class="head-mall-bar fr">
	        	<div class="head-cart-bar-box">
	        		<a class="head-cart-bar" href="<?php echo $this->createUrl('cart/index');?>"><span class="cart_info">购物车<em id="cartotal078566">0</em>件</span> <b class="icon_delta"></b></a>
	        		<div class="cart_info_main">
	        			<div class="nogoodstips">购物车里没有商品</div>
	        			<div id="goods_list787777">
	        				<table class="tb_list">
	        					<tbody></tbody>
	        				</table>
	        				<a href="<?php echo $this->createUrl('order/index');?>" class="jiesuanbtn01">结算</a>
	        				<a href="<?php echo $this->createUrl('cart/index');?>" class="jiesuanbtn01">查看购物车</a> 
	        			</div>
	        			
	        		</div>
	        	</div>
	        	<a class="head-order-bar" href="<?php echo $this->createUrl('order/list');?>">我的订单</a>
	        	
	        </div>
	        
	    </div>
	</div>

</div>

<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>user/js/user.js"></script>
<script>
var userinfo={"isGuest":1,"uname":"","company_name":""};
check_login();

$(".head-cart-bar-box").hover(function(){
	$(".cart_info_main").show();	
	$(this).find(".icon_delta").rotate({
		angle:0, 
  		animateTo:180
	});
},function(){
	$(".cart_info_main").hide();
	$(this).find(".icon_delta").rotate({animateTo:0});
});
top_cart();
</script>