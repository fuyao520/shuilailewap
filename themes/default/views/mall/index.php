<?php include(dirname(__FILE__)."/../common/inc.php");?>
<?php include(dirname(__FILE__)."/../common/head.php");?>
<body>
<?php include(dirname(__FILE__)."/../common/global-bar.php");?>

<?php include(dirname(__FILE__)."/../common/nav.php");?>
<div class="pro-m yahei">
<div class="order-bz">
    <div class="bz sel">确认订单信息</div>
    <div class="bz">在线支付订单</div>
    <div class="bz">成功提交订单</div>
</div>
<div class="division mrt-30"></div>
<div class="site-box mrt-30">
    <p class="site-tn"><b class="ico">1</b>确认收货地址   </p>
    <ul class="address-u clrfix" id="receiver_list" style="display: none">
            </ul>
    <div class="consignee-form mrt-15">
        <form id="form1" method="post" onsubmit="return add_submit(this);">
            <input type="hidden" id="addid" name="addid" value="">
            <input type="hidden" name="xy_lat" id="xy_lat" value="0">
            <input type="hidden" name="xy_lng" id="xy_lng" value="0">
            <?php if(count($page['address_list'])){ ?>
           <select id="address_default"  onchange="selectaddress();">
               <option>--快速选择--</option>
           <?php foreach($page['address_list'] as $r){ 
		   $r['citydata']=json_decode($r['citydata'],1);
		   $citycode='';
		   if(isset($r['citydata']['province_txt'])&&$r['citydata']['city_txt']&&$r['citydata']['area_txt']){
		       $citycode=$r['citydata']['province_txt'].''.$r['citydata']['city_txt'].''.$r['citydata']['area_txt'];
		   }
		   ?>
                <option  name="address_default" <?php if($r['is_default']==1)echo 'checked'; ?> type="radio" data-recv_address="<?php echo $citycode.$r['recv_address']; ?>" data-recv_cellphone="<?php echo $r['recv_cellphone']; ?>" data-recv_contact="<?php echo $r['recv_contact']; ?>"   value="<?php echo $r['recv_address_id']; ?>" /> <?php echo $r['recv_contact']; ?>(<?php echo $r['recv_cellphone']; ?>) <?php echo $citycode.$r['recv_address']; ?></option>
            <?php }?>
            </select>
            <?php }?>
            <div class="list pr">
                <span class="label"><em>*</em>收  货  人：</span>
                <div class="field"><input type="text" class="required textbox" id="consignee_name" name="lnkname" value="" maxlength="20"><span class="error" style="display: none;"><b></b>请输入您的姓名</span></div>
            </div>
            <div class="list pr" id="call_div">
                <span class="label"><em>*</em>手机号：</span>
                <div class="field"><div class="phone"><input type="text" class="required textbox fl"   id="mobile" name="lnktel" maxlength="13" value=""><span class="error" style="display: none;"><b></b>请输入您电话号码</span></div></div>
            </div>
            <div class="list select-address pr">
                <span class="label"><em>*</em>收货地址：</span>
                <div class="field">
                    <span id="span_area">
                                                                                  <select class="input select slt fl" disabled=""><option value="">广东</option></select>
                                                          <select class="input select slt fl" disabled=""><option value="">深圳市</option></select>
                                                          <select class="input select slt fl" disabled=""><option value="">罗湖区</option></select>
                                                          <select class="input select slt fl" disabled=""><option value="">桂园街道</option></select>
                                                          <select class="input select slt fl" disabled=""><option value="">松园</option></select>
                                                                            <input type="hidden" id="hdAreaIds" name="lnkadd1" lang="ext" value="440303004001">
                        <div class="fl pr detailInp" style="margin-top:3px;*margin-top:0;">
                            <input type="text" class="required input pr998" name="lnkadd2" id="address" value="" style="width:270px;" placeholder="详细地址">
                        </div>
                      </span>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="division mrt-30"></div>
<div class="pay-style mrt-30">
    <div class="site-tn">
        <b class="ico">2</b>发票信息 <a href="javascript:;" class="edit" id="bill_edit" style="display:none;" onclick="show_bill(this);">[修改]</a>
        <a href="javascript:;" id="bill_cancel" class="edit" onclick="bill_cancel(this);" style="display:none;">[取消]</a>
    </div>
    <div id="bill_state" class="white-bk mrt-20">如有发票需要，请联系客服：0755-33552888。</div>
    <div id="bill" class="consignee-form">
        <form name="form3" id="form3" method="post" onsubmit="return add_bill(this);">
            <p class="f14 p20">类型和抬头</p>
            <div class="list pr">
                <span class="label w95">发票开具方式：</span>
                <div class="field">
                    <span><input type="radio" name="bill_type" id="bill_type_1" value="0"><label for="bill_type_1">普通发票（纸质）</label></span>
                    <span><input type="radio" name="bill_type" id="bill_type_2" value="1"><label for="bill_type_2">增值税发票</label></span>
                </div>
            </div>
            <div id="bill_header" class="list pr">
                <span class="label w95"><em>*</em>发票抬头：</span>
                <div class="field">
                    <span id="dw_company" class="field">
                        <input type="hidden" name="billid" id="billid">
                        <input type="text" class="bill_required textbox w316" name="bl_header" id="bl_header" placeholder="姓名/单位名称" datatype="bl_header">
                    </span>
                </div>
            </div>
            <div id="bill_rmk">

            </div>
            <div class="form-btn">
                <button name="btn" type="submit" id="bill_btn" class="loginBtn">保存发票信息</button>
            </div>
        </form>
    </div>
    <div class="clr"></div>
</div>
<div class="division mrt-30"></div>
<form method="get" onSubmit="check_order(<?php echo Yii::app()->user->isGuest?0:1; ?>);return false;">
    <?php 
	//计算费用
	$order_money=0;
	$goods_total_gift=0;  //商品数量是否优惠过
	 ?>
    
    <div class="pay-style mrt-30">
        <p class="site-tn"><b class="ico">3</b>配送时间 <a href="javascript:;" class="edit" onclick="showPop('#songShui');">[修改]</a></p>
        <div class="clrfix mrt-20 pr">
            <div class="white-bk" id="delivery_time">2015-2-05(周四)19:49-21:49</div>
            <input type="hidden" id="dt" name="dt" value="2015-2-05(周四)19:49-21:49">
            <div class="bank-mk">温馨提示:(节假日及人力不可抗拒因素除外),非工作时间顺延.</div>
        </div>
        <div class="pr" id="songShui" style="display:none;">
            <div class=" yahei">
            	<select style="display:none;" id="shipping022" onChange="set_shipping()"  autocomplete="off"  >
                   <option value="0">--请选择配送方式--</option>
                   <?php foreach($page['shipping_list'] as $r){ ?>
                   <option <?php if($r['shipping_id']==11) echo 'selected';?> value="<?php echo $r['shipping_id']; ?>" money="<?php echo $r['insure']; ?>"><?php echo $r['shipping_name']; ?>(￥<?php echo $r['insure']; ?>)</option>
                   <?php }?>  
               </select>
                <ul class="login-form">
                    <li class="songs-time clrfix  mrt-10 pr">
                        <span class="mk-sp fl">指定配送时间：</span>
                        <input type="text" class="white-bk" readonly="true" id="dataVal" value="2015-2-05(周四)19:49-21:49">
                        <div id="date-delivery" style="width:508px;height:143px;">
                            <div class="inner" style="position: relative; width: 518px; height: 153px;">
                                <dl class="th">
                                    <dt>时间段</dt>
                                    <dd class="date">
                                   	    <?php $weekarray=array("日","一","二","三","四","五","六");?>
                                    	<?php for($i=1;$i<=7;$i++){ ?>
	                                    	<span row="-1" col="0"><?php echo date('m-d',strtotime("+$i days"));?><br>(周<?php echo $weekarray[date('w',strtotime("+$i days"))]?>)</span>
                                             <?php }?>   
                                                                            </dd>
                                    <dd class="time">
                                        <span row="0" col="-1">9:00-12:00</span>
                                        <span row="1" col="-1">12:00-15:00</span>
                                        <span row="2" col="-1">15:00-19:00</span>
                                    </dd>
                                </dl>
                                <div class="data" style="width:408px;">
                                			
                                            <?php for($i=1;$i<=7;$i++){ ?>
                                            <?php 
                                            
                                            $d=date('Y-m-d',strtotime('+'.$i.'days')).'(周'.$weekarray[date('w',strtotime("+$i days"))].')';
                                            
                                            ?>
                                            
                                            <ul>
                                                <li class="checkbox<?php echo $i==1&&time()>strtotime(date("Y-m-d 12:00:00"))?' disabled':'';?>" row="0" col="1" val="<?php echo $d;?>9:00-12:00">
                                                	<?php echo $i==1&&time()>strtotime(date("Y-m-d 12:00:00"))?'':'可选';?>
                                                </li>
                                                <li class="checkbox<?php echo $i==1&&time()>strtotime(date("Y-m-d 15:00:00"))?' disabled':'';?>" row="0" col="1" val="<?php echo $d;?>12:00-15:00">
                                                	<?php echo $i==1 && time()>strtotime(date("Y-m-d 15:00:00"))?'':'可选';?>
                                                </li>
                                                <li class="checkbox<?php echo $i==1&&time()>strtotime(date("Y-m-d 19:00:00"))?' disabled':'';?>" row="0" col="1" val="<?php echo $d;?>15:00-17:00">
                                                	<?php echo $i==1 && time()>strtotime(date("Y-m-d 19:00:00"))?'':'可选';?>
                                                </li>
                                            </ul>
                                           <?php }?>
                                           </div>
                            </div>
                        </div>
                    </li>
                    <li class="songs-time clrfix  mrt-10">
                        <span class="mk-sp fl">是否配送前确认：</span>
                        <label class="fl y clrfix cbox-lbl" for="confirm1"><input class="fl" type="radio" name="is_confirm" id="confirm1" value="1"><label class="fl" for="confirm1">是</label></label>
                        <label class="fl n clrfix cbox-lbl" for="confirm2"><input class="fl" type="radio" name="is_confirm" id="confirm2" value="0" checked="checked"><label class="fl" for="confirm2">否</label></label>
                    </li>
                    <li class="ps-li mrt-10"><i class="c">温馨提示:</i>(节假日及人力不可抗拒因素除外),非工作时间顺延.</li>
                    <li class="mrt-10"><span class="loginBtn-s w140" onclick="save_delivery_time()">保存配送时间</span></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="division mrt-30"></div>
    <div class="pay-style mrt-30">
        <p class="site-tn"><b class="ico">4</b>商品清单</p>
        <div class="clrfix mrt-20 product_tab">
            <table cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th class="one">商品名称</th>
                    <th class="two">商品价格</th>
                    <th class="three">商品单位</th>
                    <th class="five">商品数量</th>
                    <th class="five">商品总价</th>
                </tr>
                </thead>
                <tbody>
                
                <?php foreach($page['goods_list'] as $r){
			 
			 $a=Youhui::model()->get_goods_youhui($r['goods_id'],'asc');
			 $re=Youhui::model()->get_reduction_money($a,$r['goods_total']);
			 if($re['money']>0){
				 $order_money-=$re['money'];
				 $goods_total_gift=1;	
			 }
			 $goods_attr=json_decode($r['goods_attr'],1);
			 foreach($goods_attr as $r2){
				 $r['now_price']=helper::money($r['now_price']+$r2['attr_price']);
			 }
			 $order_money+=$r['now_price']*$r['goods_total']; 
		 
		 ?>   
                    <tr>
                        <td>
                            <input type="hidden" name="cartid[]" value="189"> 
                            <div class="img_list"><a class="img_pic" href="<?php echo $r['url'];?>" target="_blank"><img alt="<?php echo $r['title'];?>" src="<?php echo $r['thumb'];?>" onerror="this.src='/static/default/images/nopic.jpg'"></a></div>
                            <div class="img_info clearfix"><p class="title_p"> <a class="tit" href="<?php echo $r['url'];?>" target="_blank"><span><?php echo $r['title'];?></span></a></p></div>
                        </td>
                        <td class="sum_dia"><?php echo $r['now_price'];?></td>
                        <td class="sum_dia"><?php echo $r['unit'];?></td>
                        <td class="sum_dia tt">
                            <div class="Numinput">
                                  <?php echo $r['goods_total'];?>
                            </div>
                        </td>
                        <td class="sum_dia"><em id="cart_num_13" class="prd_sum_price" item="2">
                        	<?php 
							if($re['money']>0){
			                    echo '<span class="thr_money">￥'.($r['now_price']*$r['goods_total']).'</span> <span class="new_money03" title="'.$re['title'].'"> ￥'.($r['now_price']*$r['goods_total']-$re['money']).'</span>';
							}else{
							    echo '￥'.sprintf('%.2f',$r['now_price']*$r['goods_total']);	
							}
							?>
                        </em></td>
                    </tr>
                    
                    <?php }?>
                                                </tbody>
            </table>
        </div>
        <div class="order-summary">
            <div class="summary-form" onclick="showPop('#shuiPiao');">
    
                
            </div>
            <div class="statistic fr">
                <div class="list"><span><em id="span-skuNum">2</em> 件商品，总商品金额：</span><label class="price">￥<em id="span-payamt1" class="cart_payamt"><?php echo helper::money($order_money); ?></em></label></div>
                <div class="list"><span>返现：</span><em class="price"> -￥0.00</em></div>
                <div class="list"><span>应付总额：</span><label class="price"> ￥<em id="totalmoney003" class="cart_payamt"><?php echo helper::money($order_money); ?></em></label></div>
            </div>
        </div>
    </div>
    <div class="division mrt-30"></div>
    <div class="clrfix mrt-10">
        <button class="fr order-submit yahei r3" id="order_sbt" type="submit">提交订单</button>
        <div class="fr o-submit"><span>应付总额：</span><label class="price"> ￥<em id="span-total" class="cart_payamt"><?php echo helper::money($order_money); ?></em></label></div>
    </div>
    
    <input type="hidden" id="type" value="<?php echo $this->get('type'); ?>">
    <input type="hidden" id="num" value="<?php echo $this->get('num'); ?>">
    <input type="hidden" id="goods_id" value="<?php echo $this->get('goods_id'); ?>">
    <input type="hidden" id="goods_attr" value="<?php echo urlencode($this->get('goods_attr')); ?>">
    <input type="hidden" id="shipping_id002" value="0"  autocomplete="off"  />
    <input  type="hidden" id="order_money002" value="<?php echo $order_money; ?>"  autocomplete="off"  />
    <input  type="hidden" id="new_money0077" value="<?php echo $order_money; ?>"  autocomplete="off"  />
    <input type="hidden" id="dt" value="">
</form>
</div>


  
<?php include(dirname(__FILE__).'/../common/foot.php'); ?>


<script>
function showPop(obj){$(obj).show();}
function closePop(obj){$(obj).parent("div.pop-body").hide();}
function closeBox(obj){$(obj).parent("div.w-box").hide();}
$("li.checkbox").hover(
        function(){$(this).css({"background":"#7abd54","color":"#fff"});},
        function(){$(this).css({"background":"#fff","color":"#7ABD54"});}
);
$("#dataVal").click(function(){
    $("#date-delivery").show();
});
$("li.checkbox").click(function(){
    if($(this).hasClass('disabled')){
        return false;
    }
    $("#dataVal").val($(this).attr("val"));
    $("#date-delivery").hide();
});
function save_delivery_time(){
    delivery_time = $("#dataVal").val();
    $('#delivery_time').html(delivery_time);
    $('#dt').val(delivery_time);
    $('#songShui').hide();
    is_confirm = $(":input[name='is_confirm']:checked").val();
}



</script>
</body>
</html>


 
