<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['pay_id']='';
	$page['info']['uid']='';
	$page['info']['trade_no']='';
	$page['info']['pay_trade_no']='';
	$page['info']['pay_time']='';
	$page['info']['pay_time_complete']='';
	$page['info']['money']='';
	$page['info']['pay_type']=1;
	$page['info']['pay_state']=0;
	$page['info']['order_get_id']='';
	$page['info']['info_order_id']='';
	
		$page['info']['info_title']='';
		$page['info']['trade_no']='';
		$page['info']['order_get_id']='';
		$page['info']['uid']='';
		$page['info']['info_id']='';
		$page['info']['company_name']='';
	
}

if(isset($page['from_data'])){

	$page['info']['info_title']=isset($page['from_data']['info_title'])?$page['from_data']['info_title']:'';
	$page['info']['trade_no']=isset($page['from_data']['info_title'])?$page['from_data']['order_no']:'';
	$page['info']['order_get_id']=isset($page['from_data']['id'])?$page['from_data']['id']:'';
	$page['info']['uid']=isset($page['from_data']['uid'])?$page['from_data']['uid']:'';
	$page['info']['info_order_id']=isset($page['from_data']['info_id'])?$page['from_data']['info_id']:'';
	$page['info']['company_name']=isset($page['from_data']['company_name'])?$page['from_data']['company_name']:'';
}
?>
<div class="main mhead">
    <div class="snav">用户中心 »  
    会员充值管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('userPay/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['pay_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['pay_id']?'修改付款':'添加付款' ?></th>
    </tr>
    <?php if($page['info']['uid']){?>
    <tr>
        <td  width="100">公司名称：</td>
        <td  class="alignleft">
        <?php echo $page['info']['company_name'];?>
        </td>      
    </tr>
    <tr>
    	<td  width="100">订单标题：</td>
        <td  class="alignleft">
        <?php echo $page['info']['info_title'];?>
        </td> 
    </tr>
    <?php }?>
    <tr>
        <td  width="100">公司ID：</td>
        <td  class="alignleft">
        <input type="text" size="10"  class="ipt"  id="uid"   name="uid" value="<?php echo $page['info']['uid']; ?>"/>  <span class="red"> * 直接填写会员的ID号 </span>

        </td>      
    </tr>
    <tr>
        <td  width="100">抢单的ID：</td>
        <td  class="alignleft">
        <input type="text" size="10"  class="ipt"  id="uid"   name="order_get_id" value="<?php echo $page['info']['order_get_id']; ?>"/>  <span class="red"> *  </span>

        </td>      
    </tr>
    <tr>
        <td  width="100">订单ID：</td>
        <td  class="alignleft">
        <input type="text" size="10"  class="ipt"  id="info_order_id"   name="info_order_id" value="<?php echo $page['info']['info_order_id']; ?>"/>  <span class="red"> *  </span>

        </td>      
    </tr>
    <tr>
        <td  width="100">充值金额：</td>
        <td  class="alignleft">
        <input type="text" size="5"  class="ipt"  id="money"   name="money" value="<?php echo $page['info']['money']; ?>"/>  <span class="red"> * 必须是数字或小数</span>

        </td>      
    </tr>
    <tr>
        <td  width="100">支付方式：</td>
        <td  class="alignleft">
        <?php echo vars::input_str(array('node'=>'pay_type','type'=>'radio','default'=>$page['info']['pay_type'],'name'=>'pay_type')); ?>
        </span>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">本站订单号：</td>
        <td  class="alignleft">
         <input type="text"  class="ipt"  id="pay"   name="trade_no" value="<?php echo $page['info']['trade_no']; ?>"/>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">第三方流水号：</td>
        <td  class="alignleft">
         <input type="text"  class="ipt"  id="pay"   name="pay_trade_no" value="<?php echo $page['info']['pay_trade_no']; ?>"/>
        </td>      
    </tr>
    <tr style="display:none;">
        <td  width="100">支付结果：</td>
        <td  class="alignleft">
         <?php echo vars::input_str(array('node'=>'pay_state','type'=>'radio','default'=>$page['info']['pay_state'],'name'=>'pay_state')); ?>
        </td>      
    </tr>
    <tr>
        <td  width="100">付款时间：</td>
        <td  class="alignleft">
         <input type="text"  class="ipt"  id="pay_time"   name="pay_time" value="<?php echo $page['info']['pay_time']==0?'':date('Y-m-d H:i:s',$page['info']['pay_time']); ?>" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})"/>
        </td>      
    </tr>


 
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('userPay/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>