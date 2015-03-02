<?php include(dirname(__FILE__)."/../common/inc.php");?>
<?php include(dirname(__FILE__)."/../common/head.php");?>
<body>
<?php include(dirname(__FILE__)."/../common/global-bar.php");?>

<?php include(dirname(__FILE__)."/../common/nav.php");?>
<div class="pro-m yahei">

	
	<div class="cart-b-hd">
         <h2 class="title">支付状态</h2>
    </div>
            
    <div class="pay_back_box clearfix">
	
	  <?php if($page['pay']['result']==1){?>
	     <div class="pay_ok">
	     	<span class="pay_ok_ico"></span><br>
	     	支付成功！成功收到您的付款 <?php echo $page['pay']['money']; ?> 元 。
	     	<?php if(isset($page['pay']['order_id'])&&$page['pay']['order_id']){ ?>
	     	正在跳转...<br>
	          <script>setTimeout("location='/order/list'",2000)</script>
		 	<?php }?>
	     </div>
	     <span style="display:none;">支付状态：<?php echo isset($page['pay']['trade_status'])?$page['pay']['trade_status']:''; ?></span>
	     
	     
	  <?php }elseif($page['pay']['result']==2){?>   
		 <div class="pay_danbao">
		 	  <span class="pay_warm_ico"></span><br>
		 	  正在进行支付宝担保交易，您需要等待我们发货，然后确认收货 。</span><br>
	     	  <span style="display:none;">支付状态：<?php echo isset($page['pay']['trade_status'])?$page['pay']['trade_status']:''; ?></span>
	     </div>
	  <?php }else{?>
	  	 <div class="pay_ng">
	  	 	<span class="pay_ng_ico"></span><br>
	  	 	支付失败，出什么问题了呢，您可以联系客服
	  	 </div>
	  <?php } ?>
	         
            
			
    
    
	</div>
</div>

  
<?php include(dirname(__FILE__).'/../common/foot.php'); ?>


</body>
</html>


 
