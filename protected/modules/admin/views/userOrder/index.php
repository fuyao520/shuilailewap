<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
var orderdata=[];
function print_orders(){
	orderdata=[];
	var a=$(".cklist::checked");
	for(var i=0;i<a.length;i++){
	    orderdata.push(a.eq(i).val());	
	}
	if(orderdata.length<=0){
	    alert('请选中至少一个');
		return false;	
	}
	
	if(window.addEventListener){
		alert('批量打印必须要用IE浏览器');
		return false;
	}
	C.alert.opacty({"width":"250","height":"150","title":"批量打印订单","content":"","div_tag":"#print_all_box"});
	$("#statebox03").html('正在打印订单，总数<span id="task2">0</span>/'+orderdata.length);
	callback_sinle_print_order(0);
}
function callback_sinle_print_order(index){
	if(index<orderdata.length){
		$("#task2").html(index+1);
		window.open("user_order.php?m=print_order_detail&print=1&task="+index+"&user_order_id="+orderdata[index],'win'+parseInt(Math.random()*(2000-10)+10),'height=100, width=200');	
		window.focus();
	}else{
		$("#statebox03").html('任务已经完成，共打印数量'+orderdata.length);	
	}
}
function no_auto_print_activex(){
	$("#statebox03").html('<font color=red>打印失败，需要安装自动打印控件</font>');		
}

function change_money(order_id){
	var content='<div class="change_money_box">订单金额：￥<input type="text" id="order_money_count" style="width:70px;" class="ipt"> 请填写整数</div>';
	var alert1=art.dialog({"content":content,"title":"调整订单金额",lock:true,
		button: [
		         {
		             name: '取消'
		         },
		         {
		             name: '确定',
		             callback: function () {
			             var order_money_count=$("#order_money_count").val();
			             if(order_money_count.match(/^\d+\.\d{2}$/)==null){
							alert('请填写正确的金额');
							return false;
					     }
			             var postdata={"order_money_count":order_money_count,"user_order_id":order_id};
			             $.post('<?php echo $this->createUrl('userOrder/changeMoney');?>',postdata,function(data){
				            var json=eval("("+data+")"); 
				            if(json.state<1){
					            alert(json.msgwords);
						    }else{
							    alert('修改成功');
							    window.location.reload();
							}
				         });
		                 return false;
		             },
		             focus: true
		         }
		     ]
	});	
	
}

</script>
<body>

<div id="print_all_box">
    <div id="statebox03" style=" padding:10px;"></div>
</div>

<div class="main mhead">
    <div class="snav">内容中心 »  订单管理	</div>
     
     <div class="mt10">
     <form method="get" autocomplete="off">
    <select id="search_type" name="search_type">
        <option value="trade_no" <?php if($this->get('search_type')=='trade_no') echo 'selected';  ?>>订单号</option>		        <option value="consignee" <?php if($this->get('search_type')=='consignee') echo 'selected';  ?>>收货人</option>
        <option value="order_state" <?php if($this->get('search_type')=='order_state') echo 'selected';  ?>>付款状态</option>  
    </select>&nbsp;<input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>"  >&nbsp;<input type="submit" class="but" value="查询">&nbsp;
    
    <div class="mt10">
    支付方式：
    <select name="pay_type">
    <option value="0">--支付方式--</option>
    <?php echo vars::input_str(array('node'=>'pay_type2','type'=>'select','default'=>$this->get('pay_type'),'name'=>'pay_type')); ?>
    </select>
    </div>
    <div class="mt10">
    每页显示：
    <select name="pagesize">
    <option value="0" <?php if($this->get('pagesize')==0) echo 'selected'; ?> >默认</option>
    <option value="5" <?php if($this->get('pagesize')==5) echo 'selected'; ?>>5</option>
    <option value="20" <?php if($this->get('pagesize')==20) echo 'selected'; ?>>20</option>
    <option value="50" <?php if($this->get('pagesize')==50) echo 'selected'; ?>>50</option>
    <option value="100" <?php if($this->get('pagesize')==100) echo 'selected'; ?>>100</option>
    <option value="500" <?php if($this->get('pagesize')==500) echo 'selected'; ?>>500</option>
    <option value="1000" <?php if($this->get('pagesize')==1000) echo 'selected'; ?>>1000</option>
    </select>
    </div>
    <div class="mt10">
    时间范围：<input type="text" size="20" class="ipt" name="start_time" id="start_time" value="<?php echo $this->get('start_time')?date('Y-m-d H:i:s',$this->get('start_time')):''; ?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>-<input type="text" size="20"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="ipt" name="end_time" id="end_time" value="<?php echo $this->get('end_time')?date('Y-m-d H:i:s',$this->get('end_time')):''; ?>" />
    <input type="submit" class="but2" value="确定" />  
    <a href="#" onclick="$('#start_time').val('<?php echo date("Y-m-d 00:00:00"); ?>');$('#end_time').val('<?php echo date("Y-m-d 23:59:59"); ?>')">今天</a> 
    <a href="#" onclick="$('#start_time').val('<?php echo date('Y-m-d H:i:s',mktime(0,0,0,date('m'),date('d')-1,date('Y'))); ?>');$('#end_time').val('<?php echo date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y'))-1); ?>')">昨天</a> 
    <a href="#" onclick="$('#start_time').val('<?php echo date("Y-m-d H:i:s",mktime(0,0,0,date('m'),1,date('Y'))); ?>');$('#end_time').val('<?php echo date("Y-m-d H:i:s",mktime(23,59,59,date('m'),date('t'),date('Y'))); ?>')">本月</a>
    <?php $a=get_period_time('3month'); ?>
    <a href="#" onclick="$('#start_time').val('<?php echo $a['beginTime']; ?>');$('#end_time').val('<?php echo $a['endTime']; ?>')">最近三个月</a>
    <?php $a=get_period_time('half_year'); ?>
    <a href="#" onclick="$('#start_time').val('<?php echo $a['beginTime']; ?>');$('#end_time').val('<?php echo $a['endTime']; ?>')">最近半年</a>
    <a href="#" onclick="$('#start_time').val('');$('#end_time').val('')">清空</a>
     </div> 
    </form>
    </div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\'?m=delete_user_order&ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'user_order_del')); ?>
           
          	 <input type="button" class="but2" value="打印选中" onclick="print_orders();" style="display:none;"/>
           
        </div> 
        <div class="r">
            <form method="post" action="?m=create_excel" target="_downframe">
			<textarea name="listdata" style="display:none;"><?php echo json_encode($page['listdata']['list']); ?></textarea>
            
			<input type="submit" class="but2" value="导出Excel"/>
            </form>
            
        	<iframe name="_downframe" style="display:none;"></iframe>
        </div>
    </div>
</div>


<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center'>	
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$this->get('p').'&pagesize='.$this->get('pagesize'),'field_cn'=>'订单号','field'=>'trade_no')); ?>
        </th>
        <th align='center'>	
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$this->get('p').'&pagesize='.$this->get('pagesize'),'field_cn'=>'订单总价','field'=>'order_money_count')); ?>
        </th>
        <th align='center'>	
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$this->get('p').'&pagesize='.$this->get('pagesize'),'field_cn'=>'会员','field'=>'uid')); ?>
        </th>
		
		<th align='center' width="80">
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'search_txt='.$this->get('search_txt').'&p='.$this->get('p').'&pagesize='.$this->get('pagesize'),'field_cn'=>'收货人','field'=>'consignee')); ?>
        </th>
			
				        	
	     <th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$this->get('p').'&pagesize='.$this->get('pagesize'),'field_cn'=>'下单时间','field'=>'create_time')); ?>
        </th>
		
		<th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$this->get('p').'&pagesize='.$this->get('pagesize'),'field_cn'=>'支付方式','field'=>'pay_type')); ?>
        </th>
        
        
		
		<th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$this->get('p').'&pagesize='.$this->get('pagesize'),'field_cn'=>'状态','field'=>'order_state')); ?>
        </th>
        <th width=200>操作</th>
    
	</tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['user_order_id']; ?>" /></td>
       
        <td><?php echo $r['trade_no']; ?></td>
        <td><span style="color:green;font-weight:bold;color:#f37800;"><?php echo $r['order_money_count']; ?></span></td>
        <td><?php echo $r['uid']?$r['uname']:'<font color="red">非会员</font>'; ?></td>
		<td><?php echo $r['consignee']; ?></td>	
		<td><?php echo date('Y-m-d H:i:s',$r['create_time']); ?></td>		
        <td><?php echo vars::get_field_str('pay_type2',$r['pay_type']); ?></td>            
        
        <td>
		<?php 
		 if($r['order_state']==0){
			 echo '<font color="#999999">等待付款</font>';
		 }else if($r['order_state']==1){
		     echo '<font color=green>交易成功</font>';
		 }else if($r['order_state']==2){
			 echo '<font color="#f4b459">交易失败</font>';
		 }else if($r['order_state']==3&&$r['send_goods']==0){
			 echo '<a target="_blank" href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo='.$r['pay_trade_no'].'" title="这个是担保交易！点击去发货"><font color="red">点击发货</font></a>';
		 }else if($r['order_state']==3&&$r['send_goods']==1){
			 echo '<a target="_blank" href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo='.$r['pay_trade_no'].'" title="去支付宝查看发货状态"><font color="#000000">已经发货</font></a>';
		 }
		 ?></td>  
        <td>
        
        <?php if($r['order_state']==3&&$r['send_goods']==0){ ?>
        <a href="<?php echo $this->createUrl('userOrder/setSendGoods');?>?id=<?php echo $r['user_order_id'];  ?>">设为已发货</a>
        <?php }?>
        <a href="<?php echo $this->createUrl('userOrder/detail');?>id=<?php echo $r['user_order_id'];  ?>&p=<?php echo $this->get('p');  ?>"> 详情</a>
        <a href="javascript:void(0);" onclick="change_money(<?php echo $r['user_order_id'];  ?>)">调整金额</a> 
        <a style="display:none;" href="<?php echo $this->createUrl('userOrder/printOrderDetail');?>?id=<?php echo $r['user_order_id'];  ?>" target="_blank">打印</a></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar clearfix"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  
  <div style="font-weight:bold; font-size:14px;">当前筛选出来的统计，订单<?php echo $page['listdata']['total']; ?>个总额：￥<?php echo $page['stat']['total_money']; ?>，交易成功总<?php echo $page['stat']['ok_total']; ?>个总额：￥<?php echo $page['stat']['ok_total_money']; ?> 。
  </div>
  <?php  ?>
  
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>

<?php 
function get_period_time($type='day'){
    $rs = FALSE;
    $now = time();
    switch ($type){
        case 'day'://今天
            $rs['beginTime'] = date('Y-m-d 00:00:00', $now);
            $rs['endTime'] = date('Y-m-d 23:59:59', $now);
            break;
        case 'week'://本周
            $time = '1' == date('w') ? strtotime('Monday', $now) : strtotime('last Monday', $now);
            $rs['beginTime'] = date('Y-m-d 00:00:00', $time);
            $rs['endTime'] = date('Y-m-d 23:59:59', strtotime('Sunday', $now));
            break;
        case 'month'://本月
            $rs['beginTime'] = date('Y-m-d 00:00:00', mktime(0, 0, 0, date('m', $now), '1', date('Y', $now)));
            $rs['endTime'] = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', $now), date('t', $now), date('Y', $now)));
            break;
        case '3month'://三个月
            $time = strtotime('-2 month', $now);
            $rs['beginTime'] = date('Y-m-d 00:00:00', mktime(0, 0,0, date('m', $time), 1, date('Y', $time)));
            $rs['endTime'] = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', $now), date('t', $now), date('Y', $now)));
            break;
        case 'half_year'://半年内
            $time = strtotime('-5 month', $now);
            $rs['beginTime'] = date('Y-m-d 00:00:00', mktime(0, 0,0, date('m', $time), 1, date('Y', $time)));
            $rs['endTime'] = date('Y-m-d 23:39:59', mktime(0, 0, 0, date('m', $now), date('t', $now), date('Y', $now)));
            break;
        case 'year'://今年内
            $rs['beginTime'] = date('Y-m-d 00:00:00', mktime(0, 0,0, 1, 1, date('Y', $now)));
            $rs['endTime'] = date('Y-m-d 23:39:59', mktime(0, 0, 0, 12, 31, date('Y', $now)));
            break;
    }
    return $rs;
}
?>