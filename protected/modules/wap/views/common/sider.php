<dl class="bzzx_left">
	<dt><h2>会员中心</h2></dt>
	<dd>
		<ul>
			<li class="dbt"><h2>我的会员</h2></li>
			<li class="list"><a href="<?php echo $this->createUrl('order/index');?>"><em class="jf"></em>我的订单</a></li>
			<li class="list"><a href="<?php echo $this->createUrl('points/index');?>"><em class="jf"></em>我的积分</a></li>
			<li class="list"><a href="<?php echo $this->createUrl('collect/index');?>"><em class="sc"></em>我的收藏</a></li>
			<li class="list"><a href="<?php echo $this->createUrl('recvAddress/index');?>"><em class="sc"></em>地址管理</a> 
			<li class="list" style="display:none;"><a href=""><em class="pj"></em>我的评价</a></li>			
			<li class="dbt"><h2>账号信息</h2></li>
			<li class="list"><a href="<?php echo $this->createUrl('userProfile/index');?>"><em class="jb"></em>设置基本信息</a></li>
			<li class="list"><a href="<?php echo $this->createUrl('site/editpassword');?>"><em class="mm"></em>修改密码</a></li>
			<?php /*
			<li class="list"><a href="<?php echo $this->createUrl('account/bindMobile');?>"><em class="sj"></em>绑定手机</a></li>
			*/?>
			<li class="list"><a href="<?php echo $this->createUrl('account/bindEmail');?>"><em class="yx"></em>邮箱绑定</a></li>
			<li class="list"><a href="<?php echo $this->createUrl('thirdpassport/index');?>"><em class="wb"></em>授权管理</a></li>
		</ul>
	</dd>
</dl><!--bzzx_left end-->