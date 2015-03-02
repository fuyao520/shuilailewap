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

</style>
<body>

<div class="pro-m yahei">

	
	<div class="cart-b-hd">
                <h2 class="title">我的购物车</h2>
                <p class="tip" style="display:none;">在线支付全场满¥150免运费</p>
            </div>
            
	<?php if($page['listdata']['total']){?>
	<div class="condefaultpx03">	
			<div class="width_top">
				<?php 
			$cart_money=0;
			$goods_total_gift=0;  //商品数量是否优惠过
		?>
		<table class="tb_list mb10">
			<tr>
				<th width="350">商品名称</th>
				<th>单价</th>
				<th>购买数量</th>
				<th>小计</th>
				<th>操作</th>
			</tr>
			
			<?php foreach ($page['listdata']['list'] as $r){
					$a=Youhui::model()->get_goods_youhui($r['goods_id'],'asc');
					$re=Youhui::model()->get_reduction_money($a,$r['goods_total']);
					if($re['money']>0){
					    $cart_money-=$re['money'];	
						$goods_total_gift=1;
					}
					$goods_attr=json_decode($r['goods_attr'],1);
					foreach($goods_attr as $r2){
						$r['now_price']=helper::money($r['now_price']+$r2['attr_price']);
					}
					$cart_money+=$r['now_price']*$r['goods_total'];
					
			?>
			<tr>
				<td>
                <div class="tblistimgdiv">
                <a href="/goods/<?php echo $r['goods_id'] ?>.html">
                <img src="<?php echo $r['goods_img'];?>" width=100 height=100 style="float:left; margin:5px;"/>
                </a><a href="/goods/<?php echo $r['goods_id'] ?>.html"><?php echo $r['goods_name']?></a><br>
                <?php $r['goods_attr'];$goods_attr=json_decode($r['goods_attr'],1); ?>
                <?php if(is_array($goods_attr)){foreach($goods_attr as $e){ ?>
                <?php echo $e['attr_type_name']; ?>:<?php echo $e['attr_name']; ?>  <br>
				<?php }}?>
                </div>
                </td>
				<td>￥<?php echo $r['now_price']?></td>
				<td><input class="update_cart_id" cart_id="<?php echo $r['cart_id']; ?>" type="text" value="<?php echo $r['goods_total']?>" style="width:30px;text-align:center;height:26px;line-height:26px;" autocomplete="off" /></td>
				<td>
                <?php 
				if($re['money']>0){
                    echo '<span class="thr_money">￥'.($r['now_price']*$r['goods_total']).'</span> <span class="new_money03" title="'.$re['title'].'"> ￥'.($r['now_price']*$r['goods_total']-$re['money']).'</span>';
				}else{
				    echo '￥'.helper::money($r['now_price']*$r['goods_total']);	
				}
				?>
                </td>
				<td><a class="cartdelbtn" onClick="delecart(<?php echo $r['cart_id']; ?>)" href="javascript:void(0);">删除</a></td>
			</tr>
			<?php }?>
		</table>
		<?php 
		$a=Youhui::model()->get_activity(1);
		$b=Youhui::model()->get_activity_reduction_money($a,$cart_money,Yii::app()->user->isGuest?0:1);
		if($b['money']>0 && $goods_total_gift==0){
			$cart_money-=$b['money'];
		?>
        <div class="mt10">
         <div class="tituseractivity heiliht22">提示：当前您参与了优惠活动， <?php echo $b['title']; ?></div>
        </div>
        <?php }?>
		<table width="100%"  border="1" class="tb_list">
			<tr>
				<td class="zc">
					购物金额总计：<span class="red">￥ <?php echo helper::money($cart_money); ?>元</span> （不包含运费）
				</td>
				<td width="200" align="right">
				<input type="submit" value="清空购物车"  autocomplete="off"  id="sub01" name="button" class="btn02" onClick="delecart_all()" >
				<input type="submit" value="更新购物车"  autocomplete="off"  id="sub01" name="button" class="btn02" onClick="update_cart_goods_total();">
				</td>
			</tr>
		</table>
		
		<table width="100%" class="my_tb2 mb10 mt10">
			<tr>
				<td>
					
				</td>
				<td align="right">
	      			<input type="submit" value="继续购物"  autocomplete="off"  id="sub01" name="button" class="btnC" onClick="location.href='<?php echo Cms::model()->categorys[117]['surl']; ?>'"> <input type="submit" <?php if(count($page['listdata']['list'])==0){ ?>onclick="alert('餐车无商品，无法进行结算');return false;"<?php }else{?>onclick="location.href='/order/index'"<?php }?> value="结算中心"  autocomplete="off"  id="sub01" name="button" class="btnB" >
    </label>  <span id="statebox" style="color:red;"></span>
				</td>
			</tr>
		</table>
			
			</div>
		</div>
		
		
		<?php }else{?>
        <div id="shopCart" style="width:460px; margin:0 auto;">
                    <div class="shop-cart-box">
                        <div class="cart-b-hd">
                            <h2 class="title">您的购物车暂无商品，<a style="color:#e46713;" href="<?php echo Cms::model()->categorys[117]['surl']; ?>">这就去购物？</a></h2>
                        </div>
                    </div>
                                
        </div>
    	<?php }?>
    
    
</div>

  
<?php include(dirname(__FILE__).'/../common/foot.php'); ?>


</body>
</html>


 
