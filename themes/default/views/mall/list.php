<?php include(dirname(__FILE__)."/../common/inc.php");?>
<?php include(dirname(__FILE__)."/../common/head.php");?>
<body>
<?php include(dirname(__FILE__)."/../common/global-bar.php");?>

<?php include(dirname(__FILE__)."/../common/nav.php");?>
<div class="pro-m yahei">

	<div class="cart-b-hd">
                <h2 class="title">我的订单</h2>
            </div>
            
	<?php if($page['listdata']['total']){?>
	<div class="pay_bottom">
			<table class="tb_list">  
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
                
				<?php foreach($page['listdata']['list'] as $r){ ?>
				<table style="margin-top:10px;" class="tb_list">
                <tr>
                    <td colspan="5" class="alignleft">订单编号：<?php echo $r['trade_no']; ?> <span style="margin-left:10px;">成交时间：<?php echo date('Y-m-d H:i:s', $r['create_time']); ?></span></td>
                </tr>
                <tr>
                    <td  width="490">
                        
                       <?php $i2=0;foreach($r['goods_list'] as $r2){$i2++; ?> 
                       <div class="clearfix" style=" width:470px; overflow:hidden; <?php if($i2!=count($r['goods_list'])){; ?> border-bottom:1px solid #E6E6E6;<?php }?>">
                            <div style="float:left; width:80px;">
                            <a href="/goods/<?php echo $r2['goods_id'] ?>.html">
                            <img src="<?php echo $r2['goods_img'];?>" width=80 height=80 style="float:left; margin:5px;"/>
                            </a>
                            
                            </div>
                           <div style="float:left; width:160px;margin-left:15px; text-align:left; line-height:20px;"><a target="_blank"  href="/goods/<?php echo $r2['goods_id'] ?>.html"><?php echo $r2['goods_name'] ?></a><br />
                           <?php $goods_attr=json_decode($r2['goods_attr'],1); ?>
                            <?php if(is_array($goods_attr)){foreach($goods_attr as $e){ ?>
                            <?php echo $e['attr_type_name']; ?>:<?php echo $e['attr_name']; ?>  <br>
                            <?php }}?>  
                           </div>
                           <div style="float:left; width:140px;">
                           <?php echo $r2['goods_number']; ?> 
                           </div>
                           <div style="float:left; margin-left:0px; width:60px;"><?php echo $r2['goods_price']; ?></div>
                        </div>
                        
                       <?php }?>
                       
                    </td>

					<td valign="top" width="120"><b style="font-weight:bold;color:#f37800;"><?php echo $r['order_money_count']; ?></b></td>
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
                    <a href="<?php echo $this->createUrl('order/detail'); ?>?order_id=<?php echo $r['user_order_id']; ?>#pay">付款</a><br />
                    <?php }?>
                    
                    <?php if($r['order_state']==0&&$r['send_goods']==1){ ?>
                    <a target="_blank" href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=<?php echo $r['user_order_id']; ?>#pay">确认收货</a><br />
                    <?php }?>
                    
                    <a href="<?php echo $this->createUrl('order/detail'); ?>?order_id=<?php echo $r['user_order_id']; ?>" >详情</a><br />
                    <?php if($r['order_state']==5||$r['order_state']==0){ ?>
                    <a href="javascript:void(0);" onClick="del_order(<?php echo $r['user_order_id']; ?>,'<?php echo $this->createUrl('order/delete');?>')">删除</a>
                    <?php }?>
                    </div>
                    </td>
				</tr>
                </table>
				<?php }?>
		</div>
		<div class="pagebar clearfix"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>

        <?php }else{?>
        <div id="shopCart" style="width:460px; margin:0 auto;">
                    <div class="shop-cart-box">
                        <div class="cart-b-hd">
                            <h2 class="title">您暂无交易记录，<a style="color:#e46713;" href="<?php echo Cms::model()->categorys[117]['surl']; ?>">这就去购物？</a></h2>
                        </div>
                    </div>
                                
        </div>
    	<?php }?>
    
    
    
</div>

  
<?php include(dirname(__FILE__).'/../common/foot.php'); ?>


</body>
</html>


 
