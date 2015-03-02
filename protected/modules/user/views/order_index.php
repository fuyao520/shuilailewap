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
   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
        <div class="help_rig">
			<div class="laction"><h2>订单管理</h2> <span></span></div><!--laction end-->
			<div class="help_con">
		   			<table class="tb_list"  border="1" cellspacing="0" cellpadding="0">
				<tr>

					<th width="200" class="alignleft">
                        商品
                    </th>
                    <th width="80">数量</th>
                    <th width="84">单价（元）</th>
                    <th width="100">
                    实付款（元）
                    </th>
					<th width="120">
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
                    <td colspan="4" style="text-align:left;">订单编号：<?php echo $r['trade_no']; ?> 成交时间：<?php echo date('Y-m-d H:i:s', $r['create_time']); ?></td>
                </tr>
                <tr>
                    <td width="370">
                        
                       <?php $i2=0;foreach($r['goods_list'] as $r2){$i2++; ?> 
                       <div class="clearfix" style=" width:370px; overflow:hidden; <?php if($i2!=count($r['goods_list'])){; ?> border-bottom:1px solid #E6E6E6;<?php }?>">
                            <div style="float:left; width:80px;">
                            <a href="/goods/<?php echo $r2['goods_id'] ?>.html">
                            <img src="<?php echo $r2['goods_img'];?>" width=80 height=80 style="float:left; margin:5px;"/>
                            </a>
                            
                            </div>
                           <div style="float:left; width:145px; text-align:left; line-height:20px;"><a target="_blank"  href="/goods/<?php echo $r2['goods_id'] ?>.html"><?php echo $r2['goods_name'] ?></a><br />
                           <?php $goods_attr=json_decode($r2['goods_attr'],1); ?>
                            <?php foreach($goods_attr as $e){ ?>
                            <?php echo $e['attr_type_name']; ?>:<?php echo $e['attr_name']; ?>  <br>
                            <?php }?>  
                           </div>
                           <div style="float:left; width:30px;">
                           <?php echo $r2['goods_number']; ?> 
                           </div>
                           <div style="float:left; margin-left:0px; width:70px;"><?php echo $r2['goods_price']; ?></div>
                        </div>
                        
                       <?php }?>
                       
                    </td>
					<td valign="top"  width="100"><b><?php echo $r['order_money_count']; ?></b></td>
					<td valign="top"  width="120">
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
                    
                    <a href="<?php echo $this->createUrl('order/detail'); ?>?order_id=<?php echo $r['user_order_id']; ?>">详情</a><br />
                    <?php if($r['order_state']==5||$r['order_state']==0){ ?>
                    <a href="javascript:void(0);" onclick="del_order(<?php echo $r['user_order_id']; ?>,'<?php echo $this->createUrl('order/delete')?>')">删除</a>
                    <?php }?>
                    </div>
                    </td>
				</tr>
                </table>
				<?php }?>			
				
				
				<div class="pagebar "><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
			</div>
		
		   
           
            
        </div>
    </div>

</div>

<?php include(dirname(__FILE__)."/common/foot.php")?>
<script>
</script>


</body>
</html>