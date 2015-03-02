0!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=7">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo($config['basic']['sitename']); ?>后台管理中心</title>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo($config['basic']['cssurl']); ?>admin/<?php echo $page['ADMIN_STYLE']; ?>/admin.css" />
<script language="javascript" type="text/javascript" src="<?php echo($config['basic']['cssurl']); ?>lib/js/jquery-1.7.1.min.js" ></script>
<script language="javascript" type="text/javascript" src="<?php echo($config['basic']['cssurl']); ?>lib/js/common.js" ></script>
<script language="javascript" type="text/javascript" src="<?php echo($config['basic']['cssurl']); ?>admin/js/common.js" ></script>
<script language="javascript" type="text/javascript" src="<?php echo($config['basic']['cssurl']); ?>lib/My97DatePicker/WdatePicker.js" ></script>

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

</script>
</head>
<style>
.red2{ color:red; font-weight:bold;}
.green2{color:green; font-weight:bold;}
#title_colorpanel table tr{ line-height:inherit; border-bottom:none;}
a.close-own {
background:url(<?php echo($config['basic']['cssurl']); ?>img/m/cross.png) no-repeat left 3px;display: block;width: 16px;height: 16px;position: absolute;outline: none;right: 7px;top: 8px;text-indent: 200px;overflow: hidden;
}
a.close-own:hover{background-position: left -46px}
</style>
<body>

<div id="print_all_box">
    <div id="statebox03" style=" padding:10px;"></div>
</div>

<?php 
if(function_exists("tpl__".$page['get']['m'])){
   call_user_func("tpl__".$page['get']['m']);
}
?>
<?php if($page['get']['m']!='print_order_detail'){ ?>
<div class="main mfoot"><?php require_once("inc_foot.php"); ?></div>
<?php }?>
</body>
</html>


<?php 
function tpl__show_user_order(){
    global $page,$user_order_types,$fields;
?>
<div class="main mhead">
    <div class="snav">内容中心 »  订单管理	</div>
     
     <div class="mt10">
     <form method="get" autocomplete="off">
    <select id="search_type" name="search_type">
        <option value="trade_no" <?php if(isset($page['get']['search_type']) && $page['get']['search_type']=='trade_no') echo 'selected';  ?>>订单号</option>		        <option value="consignee" <?php if(isset($page['get']['search_type']) && $page['get']['search_type']=='consignee') echo 'selected';  ?>>收货人</option>
        <option value="order_state" <?php if(isset($page['get']['search_type']) && $page['get']['search_type']=='order_state') echo 'selected';  ?>>付款状态</option>  
    </select>&nbsp;<input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo isset($page['get']['search_txt'])?$page['get']['search_txt']:''; ?>"  >&nbsp;<input type="submit" class="but" value="查询">&nbsp;
    
    <div class="mt10" style="display:none;">
    门店：
    <input type="radio" name="order_cate" value="0" <?php if($page['get']['order_cate']==0) echo 'checked'; ?> />不限
    <input type="radio" name="order_cate" value="3" <?php if($page['get']['order_cate']==3) echo 'checked'; ?> />综合
    <input type="radio" name="order_cate" value="1" <?php if($page['get']['order_cate']==1) echo 'checked'; ?> />快点
    <input type="radio" name="order_cate" value="2" <?php if($page['get']['order_cate']==2) echo 'checked'; ?> />金和楼
    </div>
    <div class="mt10">
    支付方式：
    <select name="pay_type">
    <option value="0">--支付方式--</option>
    <?php echo vars::input_str(array('node'=>'pay_type2','type'=>'select','default'=>$page['user_order']['pay_type'],'name'=>'pay_type')); ?>
    </select>
    </div>
    <div class="mt10">
    每页显示：
    <select name="pagesize">
    <option value="0" <?php if($page['get']['pagesize']==0) echo 'selected'; ?> >默认</option>
    <option value="5" <?php if($page['get']['pagesize']==5) echo 'selected'; ?>>5</option>
    <option value="20" <?php if($page['get']['pagesize']==20) echo 'selected'; ?>>20</option>
    <option value="50" <?php if($page['get']['pagesize']==50) echo 'selected'; ?>>50</option>
    <option value="100" <?php if($page['get']['pagesize']==100) echo 'selected'; ?>>100</option>
    <option value="500" <?php if($page['get']['pagesize']==500) echo 'selected'; ?>>500</option>
    <option value="1000" <?php if($page['get']['pagesize']==1000) echo 'selected'; ?>>1000</option>
    </select>
    </div>
    <div class="mt10">
    时间范围：<input type="text" size="20" class="ipt" name="start_time" id="start_time" value="<?php echo $page['get']['start_time']?date('Y-m-d H:i:s',$page['get']['start_time']):''; ?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>-<input type="text" size="20"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="ipt" name="end_time" id="end_time" value="<?php echo $page['get']['end_time']?date('Y-m-d H:i:s',$page['get']['end_time']):''; ?>" />
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
           <?php check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\'?m=delete_user_order&ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'user_order_del')); ?>
           
          	 <input type="button" class="but2" value="打印选中" onclick="print_orders();" />
           
        </div> 
        <div class="r">
            <form method="post" action="?m=create_excel" target="_downframe">
			<textarea name="listdata" style="display:none;"><?php echo json_encode($page['user_order']['list']); ?></textarea>
            
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
		<th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'订单分类','field'=>'order_cate')); ?>
        </th>
        <th align='center' width="80">
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'编号','field'=>'user_order_id')); ?>
        </th>
		
        <th align='center'>	
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'订单号','field'=>'trade_no')); ?>
        </th>
        <th align='center'>	
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'订单总价','field'=>'order_money_count')); ?>
        </th>
        <th align='center'>	
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'会员','field'=>'uid')); ?>
        </th>
		
		<th align='center' width="80">
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'收货人','field'=>'consignee')); ?>
        </th>
			
				        	
	     <th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'下单时间','field'=>'create_time')); ?>
        </th>
		
		<th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'支付方式','field'=>'pay_type')); ?>
        </th>
        
        
		
		<th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$page['get']['search_type'].'&search_txt='.$page['get']['search_txt'].'&p='.$page['get']['p'].'&pagesize='.$page['get']['pagesize'],'field_cn'=>'状态','field'=>'order_state')); ?>
        </th>
        <th width=200>操作</th>
    
	</tr>
    
   <?php 
   foreach($page['user_order']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['user_order_id']; ?>" /></td>
        <td><?php 
		if($r['order_cate']==3){
		    echo '<span class="o_c zh">综合</span>';	
		}else if($r['order_cate']==1){
		    echo '<span class="o_c kd">快点</span>';	
		}else if($r['order_cate']==2){
		    echo '<span class="o_c jhl">金和楼</span>';	
		}
		?></td>
        <td><?php echo $r['user_order_id']; ?></td>
        <td><?php echo $r['trade_no']; ?></td>
        <td><?php echo $r['order_money_count']; ?></td>
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
        <a href="user_order.php?m=set_send_goods&user_order_id=<?php echo $r['user_order_id'];  ?>">设为已发货</a>
        <?php }?>
        <a href="user_order.php?m=edit_user_order&user_order_id=<?php echo $r['user_order_id'];  ?>&p=<?php echo $page['get']['p'];  ?>">修改 </a>  <a href="user_order.php?m=show_order_detail&user_order_id=<?php echo $r['user_order_id'];  ?>&p=<?php echo $page['get']['p'];  ?>"> 详情</a> <a href="user_order.php?m=print_order_detail&user_order_id=<?php echo $r['user_order_id'];  ?>" target="_blank">打印</a></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar clearfix"><?php echo $page['user_order']['pagecode']; ?></div>
  
  <div style="font-weight:bold; font-size:14px;">当前筛选出来的统计，订单<?php echo $page['user_order']['total']; ?>个总额：￥<?php echo $page['stat']['total_money']; ?>，交易成功总<?php echo $page['stat']['ok_total']; ?>个总额：￥<?php echo $page['stat']['ok_total_money']; ?> 。
  </div>
  <?php  ?>
  
</form>
</div>
<?php }?>

<?php 
function tpl__add_user_order(){
	global $page,$category_top_host;
	$page['user_order']['user_order_id']='';
	$page['user_order']['uid']='';
	$page['user_order']['trade_no']='';
	$page['user_order']['create_time']='';
	$page['user_order']['pay_time_complete']='';
	$page['user_order']['order_money_count']='';
	$page['user_order']['pay_type']=1;
	$page['user_order']['order_state']=0;
	
	$page['user_order']['address']='';
	$page['user_order']['consignee']='';
	$page['user_order']['mobile']='';
	$page['user_order']['email']='';

    tpl__edit_user_order();
}
?>



<?php 
function tpl__edit_user_order(){
    global $page,$configs,$category_top_host;
?>
<div class="main mhead">
    <div class="snav">用户中心 »  
    会员订单管理 </div>
</div>
<div class="main mbody">
<form method="post" action="?m=save_<?php echo $page['get']['m']; ?>&p=<?php echo $page['get']['p'];?>">
<input type="hidden" id="user_order_id" name="user_order_id" value="<?php echo $page['user_order']['user_order_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['get']['m']=='edit_user_order'?'修改订单':'添加订单' ?></th>
    </tr>
</table>
<table   class="tb3 mt2">  
    <tr>
        <th colspan="2" class="alignleft">基本信息</th>
    </tr>
    
    <tr>
        <td  width="100">会员的ID：</td>
        <td  class="alignleft">
        <input type="text" size="10"  class="ipt"  id="uid"   name="uid" value="<?php echo $page['user_order']['uid']; ?>"/>  <span class="red"> * 直接填写会员的ID号 </span>

        </td>      
    </tr>
    <tr>
        <td  width="100">订单金额：</td>
        <td  class="alignleft">
        <input type="text" size="5"  class="ipt"  id="order_money_count"   name="order_money_count" value="<?php echo $page['user_order']['order_money_count']; ?>"/>  <span class="red"> * 必须是数字或小数</span>

        </td>      
    </tr>
    <tr>
        <td  width="100">付款方式：</td>
        <td  class="alignleft">
        <span>
		<?php echo vars::input_str(array('node'=>'pay_type2','type'=>'radio','default'=>$page['user_order']['pay_type'],'name'=>'pay_type')); ?>
        </span>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">本站订单号：</td>
        <td  class="alignleft">
         <input type="text"  class="ipt"  id="pay"   name="trade_no" value="<?php echo $page['user_order']['trade_no']; ?>"/>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">支付结果：</td>
        <td  class="alignleft">
        <?php echo vars::input_str(array('node'=>'order_state','type'=>'radio','default'=>$page['user_order']['order_state'],'name'=>'order_state')); ?>
        </td>      
    </tr>
   
    <tr>
        <td  width="100">支付创建时间：</td>
        <td  class="alignleft">
         <input type="text"  class="ipt"  id="create_time"   name="create_time" value="<?php echo $page['user_order']['create_time']==0?'':date('Y-m-d H:i:s',$page['user_order']['create_time']); ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
        </td>      
    </tr>
    <tr>
        <td  width="100">支付完成时间：</td>
        <td  class="alignleft">
         <input type="text"  class="ipt"  id="pay_time_complete"   name="pay_time_complete" value="<?php echo $page['user_order']['pay_time_complete']==0?'':date('Y-m-d H:i:s',$page['user_order']['pay_time_complete']); ?>"   onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
        </td>      
    </tr>
   </table>
   
   <table class="tb mt6">
    <tr>
        <th colspan="5" class="alignleft">商品信息</th>
    </tr>
    <tr class="bg007">
        <th width="100">商品ID</th>
        <th>商品名称</th>
        <th>数量</th>
        <th>价格</th>
        <th></th>
    </tr>
    <tbody id="goods_box">
	<?php foreach ($page['order_goods']['goods_list'] as $r){?>
    <tr>
        <td width="100">
        <input type="hidden" name="order_goods_data[order_goods_id][]" value="<?php echo $r['order_goods_id'] ?>" />
        <input type="text" class="goods_id" name="order_goods_data[goods_id][]"	style="width:50px;"  value="<?php echo $r['goods_id'] ?>" /></td>
        <td> <img src="<?php echo $r['goods_img']; ?>" width="60" height="50" align="middle"/>
              <input class="ipt"  type="hidden" name="order_goods_data[goods_img][]" value="<?php echo $r['goods_img'] ?>"  />
              <input class="ipt"  type="text" name="order_goods_data[goods_name][]" value="<?php echo $r['goods_name'] ?>"  /></td>
        <td><input class="ipt"  type="text" name="order_goods_data[goods_number][]" value="<?php echo $r['goods_number'] ?>"  style="width:50px;"/></td>
        <td>￥<input class="ipt"  type="text" name="order_goods_data[now_price][]" value="<?php echo $r['goods_price'] ?>"  style="width:50px;"/> 元</td>
        <td><a href="#" onclick="del_goods($(this))">删除</a></td>
    </tr>
	<?php }?>
    </tbody>
    <tr>
        <td colspan="5" align="left">
        <div style="padding:5px; text-align:left;">
        <select id="adsgoods" onchange="add_goods();">
            <option value="0">--添加一个商品--</option>
            <?php  foreach($page['goods'] as $r){   ?>
            <option value="<?php echo $r['info_id']; ?>" goods_img="<?php echo $r['info_img']; ?>" now_price="<?php echo $r['now_price']; ?>" goods_name="<?php echo $r['info_title']; ?>" ><?php echo $r['info_title']; ?></option>
            <?php }?>
        </select>
        </div>
        </td>
    </tr>
  </table>  
<script>
function add_goods(){
    var a=$("#adsgoods option::selected");
	if(a.val()==0){
	    return false;	
	}
	var goods_id=a.val();
	var goods_img=a.attr("goods_img");
	var goods_name=a.attr("goods_name");
	var now_price=a.attr("now_price");
	for(var i=0;i<$(".goods_id").length;i++){
	    if($(".goods_id").eq(i).val()==goods_id){
		    alert('已存在');
			return false;	
		}	
	}
	$("#goods_box").append(''+
	'<tr>'+
    '   <td width="100">'+
    '    <input type="hidden" name="order_goods_data[order_goods_id][]" value="0" />'+
    '    <input class="goods_id" type="text" name="order_goods_data[goods_id][]"	style="width:50px;"  value="'+goods_id+'" /></td>'+
    '    <td> <img src="'+goods_img+'" width="60" height="50" align="middle"/>'+
    '          <input class="ipt"  type="hidden" name="order_goods_data[goods_img][]" value="'+goods_img+'"  />'+
    '          <input class="ipt"  type="text" name="order_goods_data[goods_name][]" value="'+goods_name+'"  /></td>'+
    '    <td><input class="ipt"  type="text" name="order_goods_data[goods_number][]" value="1"  style="width:50px;"/></td>'+
    '    <td>￥<input class="ipt"  type="text" name="order_goods_data[now_price][]" value="'+now_price+'"  style="width:50px;"/> 元</td>'+
	'<td><a href="#" onclick="del_goods($(this))">删除</a></td>'+
    '</tr>'+
	'');
			
}  
function del_goods(e){
	if($("#goods_box tr").length>1){
    	e.parent().parent().remove();	
	}else{
	    	
	}
}
</script>
  <table class="tb3 mt6">
    <tr>
        <th colspan="2" class="alignleft">收货人信息</th>
    </tr>
     <tr>
         <td width="100">收货人：</td><td> <input type="text"  class="ipt"  id="consignee"   name="consignee" value="<?php echo $page['user_order']['consignee']; ?> " size="10"/></td>
     </tr>
     <tr>
         <td width="100">收货地址：</td><td><input type="text"  class="ipt"  id="address"   name="address" value="<?php echo $page['user_order']['address']; ?> " size="40"/></td>
     </tr>
     <tr>
         <td width="100">手机号码：</td><td><input type="text"  class="ipt"  id="mobile"   name="mobile" value="<?php echo $page['user_order']['mobile']; ?>" /></td>
     </tr>
     <tr>
         <td width="100">Email：</td><td><input type="text"  class="ipt"  id="email"   name="email" value="<?php echo $page['user_order']['email']; ?>" /></td>
     </tr>
  </table>
 <table class="tb3 mt6">
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='user_order.php?p=<?php echo $page['get']['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php }?>
<?php 
function tpl__show_order_detail(){
    global $page,$config,$category_top_host,$fields;
?>
<div class="main mhead">
    <div class="snav">用户中心 »  
    会员订单管理 </div>
</div>
<div class="main mbody">
<input type="hidden" id="user_order_id" name="user_order_id" value="<?php echo $page['user_order']['user_order_id']; ?>" />
<div id="printbox">
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft">订单详情</th>
    </tr>
</table>
<table   class="tb3 mt2">  
    <tr>
        <th colspan="2" class="alignleft">基本信息</th>
    </tr>
    
    <tr>
        <td  width="100">会员：</td>
        <td  class="alignleft">
        <?php 
		if($page['user_order']['uid']){
		    echo $page['user_order']['uid'].' ('.$page['user_order']['uname'].')';	
		}else{
		    echo '<font color="#666666">非会员</font>';	
		}
		?>
        </td>      
    </tr>
    <tr>
        <td  width="100">订单金额：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['order_money_count']; ?>
         <br />
         <?php if($page['user_order']['is_gift']){ ?>
         享受了优惠：<span style="color:red"> <?php echo $page['user_order']['gift_detail'];  ?></span>
         <?php }?>
        </td>      
    </tr>
    
    <tr>
        <td>是否优惠：</td>
        <td>
        <?php if($page['user_order']['is_gift']){ ?>
         享受了优惠：<span style="color:red"> <?php echo $page['user_order']['gift_detail'];  ?></span>
         <?php }else{?>
           无
         <?php }?>
        </td>
    </tr>
    
    <tr>
        <td  width="100">付款方式：</td>
        <td  class="alignleft">
        <?php echo vars::get_field_str('pay_type2',$page['user_order']['pay_type']); ?>
        </span>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">本站订单号：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['trade_no']; ?>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">支付结果：</td>
        <td  class="alignleft">
         <?php echo vars::get_field_str('order_state',$page['user_order']['order_state']); ?>
        </td>      
    </tr>
   
    <tr>
        <td  width="100">支付创建时间：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['create_time']==0?'':date('Y-m-d H:i:s',$page['user_order']['create_time']); ?>
        </td>      
    </tr>
    <tr>
        <td  width="100">支付完成时间：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['pay_time_complete']==0?'':date('Y-m-d H:i:s',$page['user_order']['pay_time_complete']); ?>
        </td>      
    </tr>
    <tr>
        <td  width="100">送餐时间段：</td>
        <td  class="alignleft">
         <?php  echo intval($page['user_order']['tohours']).':30'; ?>-<?php echo intval($page['user_order']['tohours']+1).':00'; ?>
        </td>      
    </tr>
    <tr>
        <td  width="100">备注：</td>
        <td  class="alignleft">
        <?php echo $page['user_order']['postscript']; ?>
        </td>      
    </tr>
    
    
   </table>
   
   <table class="tb mt6">
    <tr>
        <th colspan="7" class="alignleft">商品信息</th>
    </tr>
    <tr class="bg007">
        <th width="100">商品ID</th>
        <th>商品名称</th>
        <th>货号</th>
        <th>数量</th>
        <th>价格</th>
        <th>小计</th>
    </tr>
	<?php foreach ($page['order_goods']['goods_list'] as $r){?>
    <tr>
        <td width="100"><?php echo $r['goods_id'] ?></td>
        <td> <img src="<?php echo $r['goods_img']; ?>" width="60" height="50" align="middle"/>
              <a class="f6" target="_blank" href="#"><?php echo $r['goods_name']; ?></a></td>
        <td><?php echo $r['goods_sn'] ?></td>
        <td><?php echo $r['goods_number'] ?></td>
        <td>￥<?php echo $r['goods_price'] ?> 元</td>
        <td>￥<?php echo $r['goods_price']*$r['goods_number']; ?> 元</td>
    </tr>
	<?php }?>
  </table>  
  <table class="tb3 mt6">
    <tr>
        <th colspan="2" class="alignleft">收货人信息</th>
    </tr>
     <tr>
         <td width="100">收货人：</td><td><?php echo $page['user_order']['consignee']; ?></td>
     </tr>
     <tr>
         <td width="100">收货地址：</td><td><?php echo $page['user_order']['address']; ?></td>
     </tr>
     <tr>
         <td width="100">手机号码：</td><td><?php echo $page['user_order']['mobile']; ?></td>
     </tr>
     <tr>
         <td width="100">Email：</td><td><?php echo $page['user_order']['email']; ?></td>
     </tr>
  </table>
  <table class="tb3 mt6">
  <tr>
        <th colspan="2" class="alignleft">配送方式</th>
    </tr>
  <tr>
    <td><?php echo $page['user_order']['shipping_name']; ?> ￥<?php echo $page['user_order']['shipping_fee']; ?></td>
  </tr>
  </table>
  </div>
  <table class="tb3 mt6">
    <tr>
        <td></td>
        <td  class="alignleft">
        <input type="button" class="but" id="subtn" value="打印订单" onclick="window.open('user_order.php?m=print_order_detail&user_order_id=<?php echo $page['user_order']['user_order_id'];  ?>')" /> 
        <input type="button" class="but" value="返回" onclick="window.location='user_order.php?p=<?php echo $page['get']['p'];?>'" /></td>
    </tr>
</table>
</div>
<?php }?>
<?php 
function tpl__print_order_detail_bak(){
    global $page,$config,$category_top_host,$fields;
?>
<div class="main mbody">
<div id="print_box" class="print_box">
    <h1>订单详情</h1>
    <table width="100%" border="1"  class="tb6 mt6"> 
        <tr>
            <th colspan="2" class="alignleft">基本信息</th>
        </tr>
        
        <tr>
        <td  width="100">会员：</td>
        <td  class="alignleft">
        <?php 
		if($page['user_order']['uid']){
		    echo $page['user_order']['uid'].' ('.$page['user_order']['uname'].')';	
		}else{
		    echo '<font color="#666666">非会员</font>';	
		}
		?>
        </td>      
    </tr>
    <tr>
        <td  width="100">订单金额：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['order_money_count']; ?>
        </td>      
    </tr>
    
    <tr>
        <td>是否优惠：</td>
        <td>
        <?php if($page['user_order']['is_gift']){ ?>
         享受了优惠：<span style="color:red"> <?php echo $page['user_order']['gift_detail'];  ?></span>
         <?php }else{?>
           无
         <?php }?>
        </td>
    </tr>
    
    <tr>
        <td  width="100">付款方式：</td>
        <td  class="alignleft">
        <?php echo vars::get_field_str('pay_type2',$page['user_order']['pay_type']); ?>
        </span>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">本站订单号：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['trade_no']; ?>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">支付结果：</td>
        <td  class="alignleft">
         <?php echo vars::get_field_str('order_state',$page['user_order']['order_state']); ?>
        </td>      
    </tr>
   
    <tr>
        <td  width="100">支付创建时间：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['create_time']==0?'':date('Y-m-d H:i:s',$page['user_order']['create_time']); ?>
        </td>      
    </tr>
    <tr>
        <td  width="100">支付完成时间：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['pay_time_complete']==0?'':date('Y-m-d H:i:s',$page['user_order']['pay_time_complete']); ?>
        </td>      
    </tr>
   </table>
   
   <table width="100%" border="1"  class="tb6 mt6">
   <tr>
        <th colspan="6" class="alignleft">收货人信息</th>
    </tr>
    <tr class="bg007">
        <td  bgcolor="#cccccc">商品ID</td>
        <td  bgcolor="#cccccc">商品名称</td>
        <td  bgcolor="#cccccc">货号</td>
        <td  bgcolor="#cccccc">数量</td>
        <td  bgcolor="#cccccc">价格</td>
        <td  bgcolor="#cccccc">小计</td>
    </tr>
	<?php foreach ($page['order_goods']['goods_list'] as $r){?>
    <tr>
        <td width="100"><?php echo $r['goods_id'] ?></td>
        <td><?php echo $r['goods_name']; ?></td>
        <td><?php echo $r['goods_sn'] ?></td>
        <td><?php echo $r['goods_number'] ?></td>
        <td>￥<?php echo $r['goods_price'] ?> 元</td>
        <td>￥<?php echo $r['goods_price']*$r['goods_number']; ?> 元</td>
    </tr>
	<?php }?>
  </table>  
  <table width="100%" border="1"  class="tb6 mt6">
    <tr>
        <th colspan="2" class="alignleft">收货人信息</th>
    </tr>
     <tr>
         <td width="100">收货人：</td><td><?php echo $page['user_order']['consignee']; ?></td>
     </tr>
     <tr>
         <td width="100">收货地址：</td><td><?php echo $page['user_order']['address']; ?></td>
     </tr>
     <tr>
         <td width="100">手机号码：</td><td><?php echo $page['user_order']['mobile']; ?></td>
     </tr>
  </table>
  <table width="100%" border="1"  class="tb6 mt6">
  <tr>
        <th colspan="2" class="alignleft">配送方式</th>
    </tr>
  <tr>
    <td><?php echo $page['user_order']['shipping_name']; ?> ￥<?php echo $page['user_order']['shipping_fee']; ?></td>
  </tr>
  </table>
  </div>
  <div style="text-align:center; display:none;" class="mt10">
<input type="button" class="but" id="subtn" value="打印订单" onclick="window.print();" /> 
<input type="button" class="but" value="关闭" onclick="window.close();" />
  </div>
</div>
<?php 
if(isset($page['get']['print'])&&$page['get']['print']==1){
 ?>
 <script>
 $(document).ready(function(){
 /*try{
 window.external.Print(0,3);
 }catch(e){//alert('请使用IE浏览器，并且要装一个插件才能自动打印！');window.close();
 }*/
     Print();
 });
 </script>
 <script>
function Print() {  
	try{
	if (document.all.eprint.defaultPrinterName.length==0){
		alert("请先安装打印机，再执行此功能！");
		return;
	}
	
	document.all.eprint.InitPrint();
	document.all.eprint.Print(true);//不弹出打印对话框直接打印
	<?php if(isset($page['get']['task'])){ ?>
	window.opener.callback_sinle_print_order(<?php echo intval($page['get']['task']+1); ?>);
	<?php }?>
	window.close();
	}catch(e){window.opener.no_auto_print_activex();//window.close();
	}

}

	</script>
 <object id=eprint classid="clsid:CA03A5A8-9890-49BE-BA4A-8C524EB06441" codebase="eprintdemo.cab#Version=3,0,0,15" viewasext> </object>
 <?php	
}
?>
<?php }?>


<?php 
function tpl__print_order_detail(){
    global $page,$config,$category_top_host,$fields;
?>
<div class="main mbody">
<div id="print_box" class="print_box">
    <h1>订单详情</h1>
    <table width="100%" border="1"  class="tb6 mt6"> 
        <tr>
            <th colspan="2" class="alignleft">基本信息</th>
        </tr>
        
        <tr>
        <td  width="100">会员：</td>
        <td  class="alignleft">
        <?php 
		if($page['user_order']['uid']){
		    echo $page['user_order']['uid'].' ('.$page['user_order']['uname'].')';	
		}else{
		    echo '<font color="#666666">非会员</font>';	
		}
		?>
        </td>      
    </tr>
    <tr>
        <td  width="100">订单金额：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['order_money_count']; ?>
        </td>      
    </tr>
    
    <tr>
        <td>是否优惠：</td>
        <td>
        <?php if($page['user_order']['is_gift']){ ?>
         享受了优惠：<span style="color:red"> <?php echo $page['user_order']['gift_detail'];  ?></span>
         <?php }else{?>
           无
         <?php }?>
        </td>
    </tr>
    
    <tr>
        <td  width="100">付款方式：</td>
        <td  class="alignleft">
        <?php echo vars::get_field_str('pay_type2',$page['user_order']['pay_type']); ?>
        </span>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">本站订单号：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['trade_no']; ?>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">支付结果：</td>
        <td  class="alignleft">
         <?php echo vars::get_field_str('order_state',$page['user_order']['order_state']); ?>
        </td>      
    </tr>
   
    <tr>
        <td  width="100">支付创建时间：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['create_time']==0?'':date('Y-m-d H:i:s',$page['user_order']['create_time']); ?>
        </td>      
    </tr>
    <tr>
        <td  width="100">支付完成时间：</td>
        <td  class="alignleft">
         <?php echo $page['user_order']['pay_time_complete']==0?'':date('Y-m-d H:i:s',$page['user_order']['pay_time_complete']); ?>
        </td>      
    </tr>
   </table>
   
   <table width="100%" border="1"  class="tb6 mt6">
   <tr>
        <th colspan="6" class="alignleft">收货人信息</th>
    </tr>
    <tr class="bg007">
        <td  bgcolor="#cccccc">商品ID</td>
        <td  bgcolor="#cccccc">商品名称</td>
        <td  bgcolor="#cccccc">货号</td>
        <td  bgcolor="#cccccc">数量</td>
        <td  bgcolor="#cccccc">价格</td>
        <td  bgcolor="#cccccc">小计</td>
    </tr>
	<?php foreach ($page['order_goods']['goods_list'] as $r){?>
    <tr>
        <td width="100"><?php echo $r['goods_id'] ?></td>
        <td><?php echo $r['goods_name']; ?></td>
        <td><?php echo $r['goods_sn'] ?></td>
        <td><?php echo $r['goods_number'] ?></td>
        <td>￥<?php echo $r['goods_price'] ?> 元</td>
        <td>￥<?php echo $r['goods_price']*$r['goods_number']; ?> 元</td>
    </tr>
	<?php }?>
  </table>  
  <table width="100%" border="1"  class="tb6 mt6">
    <tr>
        <th colspan="2" class="alignleft">收货人信息</th>
    </tr>
     <tr>
         <td width="100">收货人：</td><td><?php echo $page['user_order']['consignee']; ?></td>
     </tr>
     <tr>
         <td width="100">收货地址：</td><td><?php echo $page['user_order']['address']; ?></td>
     </tr>
     <tr>
         <td width="100">手机号码：</td><td><?php echo $page['user_order']['mobile']; ?></td>
     </tr>
  </table>
  <table width="100%" border="1"  class="tb6 mt6">
  <tr>
        <th colspan="2" class="alignleft">配送方式</th>
    </tr>
  <tr>
    <td><?php echo $page['user_order']['shipping_name']; ?> ￥<?php echo $page['user_order']['shipping_fee']; ?></td>
  </tr>
  </table>
  </div>
  <div style="text-align:center; display:none;" class="mt10">
<input type="button" class="but" id="subtn" value="打印订单" onclick="window.print();" /> 
<input type="button" class="but" value="关闭" onclick="window.close();" />
  </div>
</div>
<?php 
if(isset($page['get']['print'])&&$page['get']['print']==1){
 ?>
 <script>
 $(document).ready(function(){
 /*try{
 window.external.Print(0,3);
 }catch(e){//alert('请使用IE浏览器，并且要装一个插件才能自动打印！');window.close();
 }*/
     Print();
 });
 </script>
 <script>
function Print() {  
	try{
	if (document.all.eprint.defaultPrinterName.length==0){
		alert("请先安装打印机，再执行此功能！");
		return;
	}
	
	document.all.eprint.InitPrint();
	document.all.eprint.Print(true);//不弹出打印对话框直接打印
	<?php if(isset($page['get']['task'])){ ?>
	window.opener.callback_sinle_print_order(<?php echo intval($page['get']['task']+1); ?>);
	<?php }?>
	window.close();
	}catch(e){window.opener.no_auto_print_activex();//window.close();
	}

}

	</script>
 <object id=eprint classid="clsid:CA03A5A8-9890-49BE-BA4A-8C524EB06441" codebase="eprintdemo.cab#Version=3,0,0,15" viewasext> </object>
 <?php	
}
?>
<?php }?>

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