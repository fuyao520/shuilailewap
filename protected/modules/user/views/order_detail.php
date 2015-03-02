<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['birth_day']='';
    $page['info']['sex']='';
    $page['info']['constellation']='';
    $page['info']['signature']='';
    $page['info']['occupation']='';
}
?>
<style>
strong{color:#12549e;}
</style>   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
        <div class="help_rig">
			<div class="laction"><h2>订单管理</h2> <span></span></div><!--laction end-->
			<div class="help_con">
		   						
				
				<div class="condefaultpx03">
        <table width="100%" class="tb_up mt10">
        <tbody>
        <?php if($page['order_detail']['extension_code']&&$page['order_detail']['extension_code']!='immediately_buy'){ ?>
        <tr>
        	<td>活动类型：</td>
            <td>
			<?php 
			if($page['order_detail']['extension_code']=='exchange_goods'){
				echo '积分商城，共消耗'.$page['order_detail']['integral'].'积分';	
			}else if($page['order_detail']['extension_code']=='group_buy'){
				echo '团购活动';	
			} 
			?>
            </td>
        </tr>
        <?php }?>
        <tr>
          <td width="15%" >订单号：</td>
          <td><?php echo $page['order_detail']['trade_no']; ?></td>
        </tr>
        <tr>
          <td>订单状态：</td>
          <td>
          <?php 
		  $t=vars::get_field_str('order_state',$page['order_detail']['order_state'],'txt');
		  if($t=='等待付款'){
			  echo '<span class="wait_iconv"></span><font color="#F5A800">等待付款</font>';	
		  }else if($t=='交易成功'){
			  echo '<span class="ok_iconv01"></span><font color="#006600">交易成功</font>'.($page['order_detail']['pay_type']==8?'<div class="cash022">货到付款</div>':'');
		  }else if($t=='交易失败'){
			  echo '<span class="ng_iconv"></span><font color="red">交易失败</font>';
		  }else if($t=='担保交易'&&$r['send_goods']==0){
			  echo '<span class="ok_iconv"></span><font color="#FF9900">担保交易</font>';
		  }else if($t=='担保交易'&&$r['send_goods']==1){
			  echo '<span class="ok_iconv"></span><font color="#FF9900">已经发货</font>';
		  }
		  ?>
          
          </td>
        </tr>
        </tbody>
        </table>  
        <?php if($page['order_detail']['postscript']&&$page['order_detail']['postscript']!='undefined'){ ?>
   <div class="mt10">
       <strong>附加信息</strong>
       <table  class="tb_up mt10">
        <tbody><tr>
          <td width="15%" >附加留言：</td>
          <td><?php echo $page['order_detail']['postscript']; ?></td>
        </tr>
        </tbody>
        </table>  
   </div>
   <?php }?>
   
   <div class="mt10">
       <strong>商品列表</strong>
   </div>
   <table width="100%" class="tb_list mt10">
          <tbody><tr>
            <th>商品名称</th>
            <th>商品价格</th>
            <th>购买数量</th>
            <th>小计</th>
          </tr>
          <?php
		   $order_money=0;
		   foreach($page['order_detail']['goods_list'] as $r){
			   $order_money+=$r['goods_price']*$r['goods_number'];
			    ?>
          <tr>
            <td>
             <div class="tblistimgdiv">
                <a href="/goods/<?php echo $r['goods_id'] ?>.html">
                <img src="<?php echo $r['goods_img'];?>" width=80 height=80 style="float:left; margin:5px;"/>
                </a><a href="/goods/<?php echo $r['goods_id'] ?>.html"><?php echo $r['goods_name']?></a><br>
                <?php $goods_attr=json_decode($r['goods_attr'],1); ?>
                <?php foreach($goods_attr as $e){ ?>
                <?php echo $e['attr_type_name']; ?>:<?php echo $e['attr_name']; ?>  <br>
				<?php }?>
                </div>
            </td>                              
            <td><?php echo $r['goods_price']; ?></td>
            <td><?php echo $r['goods_number']; ?></td>
            <td>￥<?php echo $r['goods_price']*$r['goods_number']; ?>元 </td>
          </tr>
             
          <?php }?>
           <tr>
            <td colspan="4">
            商品总价: ￥<?php echo $order_money;  ?>元</td>
          </tr>
        </tbody>
        </table>
        <div class="mt10">
        <strong>配送方式</strong>
        </div>
        <div>
		<table class="tb_up mt10">
            <tbody><tr>
              <td align="right"  bgcolor="#ffffff"><?php echo $page['order_detail']['shipping_name']; ?> ￥<?php echo $page['order_detail']['shipping_fee']; ?></td>
            </tr>
            </tbody>
            </table>
		</div>
        <div class="mt10">
           <strong>收货人信息</strong>
       </div>
        <table  class="tb_up mt10">
            <tbody>
            <tr>
              <td width="100">收货人姓名：</td>
              <td  class="zc"><?php echo $page['order_detail']['consignee']; ?></td>
              
            </tr>
                        <tr>
              <td>详细地址：</td>
              <td class="zc"><?php echo $page['order_detail']['address']; ?></td>
            </tr>
                        <tr>
              
              <td>手机：</td>
              <td class="zc"><?php echo $page['order_detail']['mobile']; ?></td>
            </tr>
            </tbody>
            </table>
          <div class="mt10">
               <strong>订单总价</strong>
           </div>
           
           <div class="mt10">
           <?php if($order_money+$page['order_detail']['shipping_fee']!=$page['order_detail']['order_money_count']){ ?>
                 <?php if($page['order_detail']['is_gift']==1){ ?>
                 <span class="heiliht22"><?php echo $page['order_detail']['gift_detail']; ?></span>
				 <?php }else{?>
                 <span class="heiliht22">价钱经过商家修改</span>
                 <?php }?>
			  <?php }?>
			  <font style="font-size:20px;color:green;font-weight:bold;color:#f37800;"><b>￥<?php echo $page['order_detail']['order_money_count']; ?></b></font>
           </div>
          
          
          <form name="formpay"  method="post" id="formpay" action="<?php echo $this->createUrl('/pay/submit')?>" target="_blank">
          
        
          <?php if($page['order_detail']['order_state']==0){ ?>
          <?php if($page['member']['user_money']<$page['order_detail']['order_money_count']){ ?>
           <?php if($page['member']['user_money']>0){ ?>
          <input type="checkbox" checked="checked" disabled="disabled" /> 使用当前我的账户余额￥<?php echo $page['member']['user_money']; ?>
            <?php }?>
             <div>
             
             
             <div class="mt10">
               <strong>支付方式</strong>
               <a name="pay"></a>
             </div>
             <div class="pay_box0222 mt10">  
                 <div id="paybox2333">
                 
                 <div style="text-align:center;">
                	<a href="javascript:void(0);" onclick="sub_pay_form(1);"><img src="/static/default/images/alipay_go.png" ></a> 
                   </div>
                 
                 
                 <div class="buxiangzhifu mt10" >
                    <a href="javascript:void(0);" onclick="set_cash_pay(<?php echo $page['order_detail']['user_order_id']; ?>);" class="btn_hdfk">货到付款 >></a> 
                 </div>　
                 
                   
             </div>
             
            </div>  
            <div id="paybtn0033" style="display:none;margin-top:20px;"><input type="button" value=" 确认付款 " class="btn03" onclick="balance_coupons_pay(<?php echo $page['order_detail']['user_order_id']; ?>);"/></div>
          
         
         
         
          <?php }else{?>
          <input type="button" value="余额支付" class="btn03" onclick="balance_pay(<?php echo $page['order_detail']['user_order_id']; ?>);"/>
          <?php }?>
            
		<?php }else{?>
            <?php if($page['order_detail']['pay_type']==8){ ?>
            <span class="ok_iconv"></span> 货到付款
            <?php }else{?>
            <span class="ok_iconv"></span>已经付款  （用的是<?php echo helper::get_arr_txt($fields['pay_type2'],$page['order_detail']['pay_type']); ?>）
                <?php }?>
          <?php }?>
            </div>
            
            <div class="pay_complete_box" id="pay_complete_box" style="display:none;">
                <p>将会在新窗口打开网上银行页面；
请在新打开的网页银行页面完成付款，
付款完成前请不要关闭此窗口。</p>
                <div class="bt002ss_box">
                    <a class="btn09" href="<?php echo $this->createUrl('order/detail')?>?order_id=<?php echo $this->get('order_id');?>">支付成功，查看记录</a>
                    <a class="btn09"  href="javascript:void(0);" onclick="C.alert.opacty_close('#pay_complete_box')">支付失败，重新支付</a>
                </div>
            </div>            
            <input type="hidden" name="pay_type" value="1" />
            <input type="hidden" name="order_id" value="<?php echo $page['order_detail']['user_order_id']; ?>">
            <input type="hidden" name="pay_money" value="<?php echo $page['order_detail']['order_money_count']-$page['member']['user_money']; ?>" />
            </form>
<script>
$("input[name=bankCode]").click(function(){
	sub_pay_form(6);
})
</script>
            
            <div class="pay_complete_box" id="pay_complete_box" style="display:none;">
                
                <p>将会在新窗口打开网上银行页面；
请在新打开的网页银行页面完成付款，
付款完成前请不要关闭此窗口。</p>
                <div class="bt002ss_box">
                    <a class="btn09" href="javascript:void(0);" onclick="sub_complete_pay(<?php echo $page['order_detail']['user_order_id']; ?>);">支付成功，查看记录</a>
                    <a class="btn09"  href="javascript:void(0);" onclick="C.alert.opacty_close('#pay_complete_box')">支付失败，重新支付</a>
                </div>
            </div>
            <form name="formpay"  method="post" id="formpay" action="/pay.php" target="_blank">
            <input type="hidden" name="pay_type" value="1" />
            <input type="hidden" name="order_money" value="<?php echo $page['order_detail']['order_money_count']; ?>" />
            <input type="hidden" name="user_money" value="<?php echo $page['member']['user_money']; ?>" />
            <input type="hidden" name="pay_money" value="<?php echo $page['order_detail']['order_money_count']-$page['member']['user_money']; ?>" />
            </form>
            </div>
			</div>
		
		   
           
            
        </div>
    </div>

</div>

<?php include(dirname(__FILE__)."/common/foot.php")?>
<script>
</script>


</body>
</html>