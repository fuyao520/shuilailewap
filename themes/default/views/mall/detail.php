<?php include(dirname(__FILE__)."/../common/inc.php");?>
<?php include(dirname(__FILE__)."/../common/head.php");?>
<body>
<?php include(dirname(__FILE__)."/../common/global-bar.php");?>

<?php include(dirname(__FILE__)."/../common/nav.php");?>
<style>
/*表格列表显示样式*/
.tb_list{border:1px solid #e8e8e8;width:100%; border-bottom:0px;}
.tb_list tr:hover{background:#f6f4f4;}
.tb_list tr{background:#f6f6f6;}
.tb_list tr th{height:40px;line-height:40px;background:#f6f6f6;border:1px solid #eee;border-bottom:1px solid #e8e8e8; text-align:center;font-size:16px;font-weight:100;}
.tb_list tr td{line-height:200%; border-bottom:1px solid #e8e8e8; text-align: center; padding:10px 0;}
.tb_list tr td.alignleft,.tb_list tr th.alignleft{ text-align:left; text-indent:10px;}
.tb_list tr td input.ipt{margin:5px 0 5px 0;}

strong{color:#12549e;}

</style>
<div class="pro-m yahei">

<div class="cart-b-hd">
                <h2 class="title">我的订单</h2>
            </div>
	<div class="listmain bg">
	<div class="condefaultpx03">
        <table class="tb_up">  
        <tbody><tr>
          <td width="15%" >订单号：</td>
          <td class="zc"><?php echo $page['order_detail']['trade_no']; ?></td>
        </tr>
        <tr>
          <td>订单状态：</td>

          <td class="zc"><?php echo vars::get_field_str('order_state',$page['order_detail']['order_state'],'txt'); ?> 

          </td>
        </tr>
        </tbody>
        </table>  
   <div class="mt10">
       <strong>附加信息</strong>
       <table  class="tb_up mt10">
        <tbody><tr>
          <td width="15%" >附加留言：</td>
          <td class="zc"><?php echo $page['order_detail']['postscript']; ?></td>
        </tr>
        </tbody>
        </table>  
   </div>
   <div class="mt10">
       <strong>商品列表</strong>
   </div>
   <table width="100%" class="tb_list mt10">
          <tbody><tr>
            <th class="alignleft">商品名称</th>
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
            <td class="alignleft">
              <div class="tblistimgdiv">
                <a href="/goods/<?php echo $r['goods_id'] ?>.html">
                <img src="<?php echo $r['goods_img'];?>" onload="resizeImage(this,80,100)" style="float:left; margin:5px;"/>
                </a><a href="/goods/<?php echo $r['goods_id'] ?>.html"><?php echo $r['goods_name']?></a><br>
                <?php $goods_attr=json_decode($r['goods_attr'],1); ?>
                <?php if(is_array($goods_attr)){foreach($goods_attr as $e){ ?>
				<?php echo $e['attr_type_name']; ?>:<?php echo $e['attr_name']; ?>  <br>
                <?php }}?> 
                </div>
            </td>                              
            <td><?php echo $r['goods_price']; ?></td>
            <td><?php echo $r['goods_number']; ?></td>
            <td>￥<?php echo $r['goods_price']*$r['goods_number']; ?>元
            <?php if($r['is_gift']==1){?> 			
            <span class="infogift" title="<?php echo $r['gift_detail']; ?>"></span>
            <?php }?>
            </td>
          </tr>
             
          <?php }?>
           <tr>
            <td colspan="5"  class="yc">
            商品总价: ￥<?php echo $order_money;  ?>元</td>
          </tr>
        </tbody>
        </table>
        <div class="mt10">
        <strong>配送方式</strong>
        </div>
        <div>
		<table width="100%" class="tb_up mt10">
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
          <table width="100%" class="tb_up mt10">
            <tbody><tr>
              <td class="yc"  bgcolor="#ffffff">
               <?php if($order_money+$page['order_detail']['shipping_fee']!=$page['order_detail']['order_money_count']){ ?>
                 <?php if($page['order_detail']['is_gift']==1){ ?>
                 <span class="heiliht22"><?php echo $page['order_detail']['gift_detail']; ?></span>
				 <?php }else{?>
                 <span class="heiliht22">价钱经过商家修改</span>
                 <?php }?>
			  <?php }?>
              
              <font size="+1" color="red">共计：<b>￥<?php echo $page['order_detail']['order_money_count']; ?></b></font></td>
            </tr>
            </tbody>
          </table>
          <form name="formpay"  method="post" id="formpay" action="<?php echo $this->createUrl('/pay/submit')?>" target="_blank">
          
        
          <?php if($page['order_detail']['order_state']==0){ ?>
          
          
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
            <?php if($page['order_detail']['pay_type']==8){ ?>
            <span class="ok_iconv"></span> 货到付款
            <?php }else{?>
            <span class="ok_iconv"></span>已经付款  （用的是<?php echo helper::get_arr_txt('pay_type2',$page['order_detail']['pay_type']); ?>）
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
            </form>
            </div>
</div>
        
    
    
    
</div>

  
<?php include(dirname(__FILE__).'/../common/foot.php'); ?>


</body>
</html>


 
