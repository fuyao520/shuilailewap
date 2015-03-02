<?php $page['relation_cate_top']['cate_id']='member'; ?>
<!DOCTYPE html>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<title>订单-<?php echo Yii::app()->params['basic']['sitename'] ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/style.css">
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.external.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/common.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/js/common.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/artDialog4.1.7/artDialog.js?skin=idialog"></script>
<script type="text/javascript">
</script>
</head>
<body>
<?php include(dirname(__FILE__)."/common/head.php"); ?>

<div class="wrap width mt10">	
	<?php if(function_exists("tpl__".$page['get']['m'])){call_user_func("tpl__".$page['get']['m']);} ?>
</div>


<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>

</body>
</html>
 <?php 
function tpl__show_user_order(){
	global $page,$fields;
?>
<div class="listmain bg">
	<div class="nav_url clearfix">
		确认订单
	</div>
	<div class="condefaultpx03">
		<div class="pay_bottom">
			<table class="tb_01">  
				<tr>

					<th width="280" class="alignleft">
                        商品
                    </th>
                    <th width="80">数量</th>
                    <th width="120">单价（元）</th>
                    <th width="120">
                    实付款（元）
                    </th>
					<th width="140">
						订单状态
					</th>
					<th>
						操作
					</th>
				</tr>
                </table>
                
				<?php foreach($page['user_order']['list'] as $r){ ?>
				<table style="margin-top:10px;" class="tb_02">
                <tr>
                    <td colspan="5" class="alignleft">订单编号：<?php echo $r['trade_no']; ?> <span style="margin-left:10px;">成交时间：<?php echo date('Y-m-d H:i:s', $r['create_time']); ?></span></td>
                </tr>
                <tr>
                    <td  width="370">
                        
                       <?php $i2=0;foreach($r['goods_list'] as $r2){$i2++; ?> 
                       <div class="clearfix" style=" width:470px; overflow:hidden; <?php if($i2!=count($r['goods_list'])){; ?> border-bottom:1px solid #E6E6E6;<?php }?>">
                            <div style="float:left; width:80px;">
                            <a href="/goods/<?php echo $r2['goods_id'] ?>.html">
                            <img src="<?php echo $r2['goods_img'];?>" onload="resizeImage(this,60,100)" style="float:left; margin:5px;"/>
                            </a>
                            
                            </div>
                           <div style="float:left; width:160px; text-align:left; line-height:20px;"><a target="_blank"  href="/goods/<?php echo $r2['goods_id'] ?>.html"><?php echo $r2['goods_name'] ?></a><br />
                           <?php $goods_attr=json_decode($r2['goods_attr'],1); ?>
                            <?php if(is_array($goods_attr)){foreach($goods_attr as $e){ ?>
                            <?php echo $e['attr_type_name']; ?>:<?php echo $e['attr_name']; ?>  <br>
                            <?php }}?>  
                           </div>
                           <div style="float:left; width:100px;">
                           <?php echo $r2['goods_number']; ?> 
                           </div>
                           <div style="float:left; margin-left:0px; width:100px;"><?php echo $r2['goods_price']; ?></div>
                        </div>
                        
                       <?php }?>
                       
                    </td>

					<td valign="top" width="100"><b><?php echo $r['order_money_count']; ?></b></td>
					<td valign="top" width="120">
					<?php 
					$t=vars::get_field_str('order_state',$r['order_state']); 
					if($t=='等待付款'){
					    echo '<span class="wait_iconv"></span><font color="#F5A800">等待付款</font>';	
					}else if($t=='交易成功'){
					    echo '<span class="ok_iconv01"></span><font color="#006600">交易成功</font>'.($r['pay_type']==8?'<div class="cash022">货到付款</div>':'');
				    }else if($t=='交易失败'){
						echo '<span class="ng_iconv"></span><font color="red">交易失败</font>';
					}else if($t=='担保交易'&&$r['send_goods']==0){
						echo '<span class="ok_iconv"></span><font color="#FF9900">担保交易</font>';
					}else if($t=='担保交易'&&$r['send_goods']==1){
						echo '<span class="ok_iconv"></span><font color="#FF9900">已经发货</font>';
					}
					?><br>
                    <?php 
					if($r['pay_type']){
                    	//echo vars::get_field_str('pay_type2',$r['pay_type']);
                    } ?>
                    </td>
                    
					<td  valign="top">
                    <div class="ddbarbox">
                    <?php if($r['order_state']==3&&$r['send_goods']==1){ ?>
                        <a href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=<?php echo $r['pay_trade_no']; ?>" target="_blank" class="shouhuobtn">确认收货</a>
					<?php }?>
                    <?php if($r['order_state']==0){ ?>
                    <a href="/session_order.php?m=show_order_detail&order_id=<?php echo $r['user_order_id']; ?>#pay">付款</a><br />
                    <?php }?>
                    
                    <?php if($r['order_state']==0&&$r['send_goods']==1){ ?>
                    <a target="_blank" href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=<?php echo $r['user_order_id']; ?>#pay">确认收货</a><br />
                    <?php }?>
                    
                    
                    
                    <a href="/session_order.php?m=show_order_detail&order_id=<?php echo $r['user_order_id']; ?>" >详情</a><br />
                    <?php if($r['order_state']==5||$r['order_state']==0){ ?>
                    <a href="javascript:void(0);" onClick="del_order(<?php echo $r['user_order_id']; ?>,'session_order.php')">删除</a>
                    <?php }?>
                    </div>
                    </td>
				</tr>
                </table>
				<?php }?>
		</div>
		<div class="pagebar clearfix"><?php echo $page['user_order']['pagecode']; ?></div>
	</div>
</div>
<?php }?>


 <?php 
function tpl__show_order_detail(){
	global $page,$fields,$config;
?>
<div class="listmain bg">
	<div class="nav_url clearfix">
	   订单状态
	</div>
	<div class="condefaultpx03">
        <table class="tb_01">  
        <tbody><tr>
          <td width="15%" >订单号：</td>
          <td><?php echo $page['order_detail']['trade_no']; ?></td>
        </tr>
        <tr>
          <td>订单状态：</td>

          <td><?php echo vars::get_field_str('order_state',$page['order_detail']['order_state'],'txt'); ?> 

          </td>
        </tr>
        </tbody>
        </table>  
   <div class="mt10">
       <strong>附加信息</strong>
       <table width="100%" class="tb_01 mt10">
        <tbody><tr>
          <td width="15%" >附加留言：</td>
          <td><?php echo $page['order_detail']['postscript']; ?></td>
        </tr>
        </tbody>
        </table>  
   </div>
   <div class="mt10">
       <strong>商品列表</strong>
   </div>
   <table width="100%" class="tb_02 mt10">
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
            <td colspan="5">
            商品总价: ￥<?php echo $order_money;  ?>元</td>
          </tr>
        </tbody>
        </table>
        <div class="mt10">
        <strong>配送方式</strong>
        </div>
        <div>
		<table width="100%" class="tb_01 mt10">
            <tbody><tr>
              <td align="right"  bgcolor="#ffffff"><?php echo $page['order_detail']['shipping_name']; ?> ￥<?php echo $page['order_detail']['shipping_fee']; ?></td>
            </tr>
            </tbody>
            </table>
		</div>
        <div class="mt10">
           <strong>收货人信息</strong>
       </div>
        <table width="100%" class="tb_01 mt10">
            <tbody>
            <tr>
              <td width="100">收货人姓名：</td>
              <td width="35%"><?php echo $page['order_detail']['consignee']; ?></td>
              <td width="100">电子邮件地址：</td>
              <td width="35%"><?php echo $page['order_detail']['email']; ?></td>
            </tr>
                        <tr>
              <td>详细地址：</td>
              <td  colspan="3"><?php echo $page['order_detail']['address']; ?></td>
            </tr>
                        <tr>
              <td>电话：</td>
              <td><?php echo $page['order_detail']['tel']; ?> </td>
              <td>手机：</td>
              <td><?php echo $page['order_detail']['mobile']; ?></td>
            </tr>
            </tbody>
            </table>
          <div class="mt10">
               <strong>订单总价</strong>
           </div>
          <table width="100%" class="tb_01 mt10">
            <tbody><tr>
              <td align="right"  bgcolor="#ffffff">
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
          <div class="mt10 pay_box0222">
               <h5><strong>支付方式</strong></h5>
               <a name="pay"></a>
           </div>
          <form name="formpay"  method="post" id="formpay" action="/pay.php" target="_blank">
          <div class="pay_box0222">
          <?php if($page['order_detail']['order_state']==0){ ?>
          
         您需要 ￥<?php echo $page['order_detail']['order_money_count']; ?> 元，请选择下列的方式支付
             
             <div>
             
             <h5>第三方支付</h5>
             <div class="third_list clearfix mt10">
             <label><span class="iconthird alipay" onclick="sub_pay_form(1);" title="支付宝"></span></label>
             <label><span class="iconthird unionpay" onclick="sub_pay_form(3);" title="银联"></span></label>
             
             </div>
             
             <h5 class="mt10">货到付款</h5>
             <div class="buxiangzhifu mt10">
                <input type="button" onclick="set_cash_pay(<?php echo $page['order_detail']['user_order_id']; ?>);" class="btn03" value="货到付款"> 
             </div>　
             
             
         
            </div>  
            
		<?php }else{?>
            <?php if($page['order_detail']['pay_type']==8){ ?>
            <span class="ok_iconv"></span> 货到付款
            <?php }else{?>
            <span class="ok_iconv"></span>已经付款  （用的是<?php echo helper::get_arr_txt($fields['pay_type2'],$page['order_detail']['pay_type']); ?>）
                <?php }?>
          <?php }?>
            </div>
            
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
                    <a class="btn09" href="javascript:void(0);" onClick="location='/session_order.php';">支付成功，查看记录</a>
                    <a class="btn09"  href="javascript:void(0);" onClick="C.alert.opacty_close('#pay_complete_box')">支付失败，重新支付</a>
                </div>
            </div>
            <input type="hidden" name="pay_type" value="1" />
            <input type="hidden" name="order_id" value="<?php echo $page['order_detail']['user_order_id']; ?>">
            <input type="hidden" name="pay_money" value="<?php echo $page['order_detail']['order_money_count']; ?>" />
            </form>
            </div>
</div>
        
<?php }?>  