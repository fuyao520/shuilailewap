<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  充值管理	</div>
     
     <div class="mt10">
     	<form action="<?php echo $this->createUrl('nlink/index'); ?>">
	    <select id="search_type" name="search_type">
	        <option value="keys" <?php echo $this->get('search_type')=='keys'?'selected':''; ?>>关键字</option>
	        <option value="id" <?php echo $this->get('search_type')=='id'?'selected':''; ?>>ID</option>
	    </select>&nbsp;
	    <input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" >
	    <input type="submit" class="but" value="查询"  >
    	</form>
    </div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('userPay/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'user_pay_del')); ?>
           
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center' width="80">
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'编号','field'=>'pay_id')); ?>
        </th>
        <th align='center'>	
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'本站订单号','field'=>'trade_no')); ?>
        </th>
        <th align='center'>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'第三方流水号','field'=>'pay_trade_no')); ?>
        	</th>
         <th align='center'>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'支付方式','field'=>'pay_type')); ?>
        	</th>   
        <th align='center' width="80">
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'会员','field'=>'a.uid')); ?>
        	</th>	
        <th align='center' width="80">
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'付款金额','field'=>'money')); ?>
        	</th>
        
        <th>
        <?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'付款时间','field'=>'pay_time')); ?>
        
        </th>
        <th><?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'支付完成时间','field'=>'pay_time_complete')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'&p='.$_GET['p'].'','field_cn'=>'支付状态','field'=>'pay_state')); ?></th>
     
        
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['pay_id']; ?>" /></td>
        <td><?php echo $r['pay_id']; ?></td>
        <td><?php echo $r['trade_no']; ?></td>
        <td><?php echo $r['pay_trade_no']; ?></td>
        <td><?php echo vars::get_field_str('pay_type',$r['pay_type']); ?></td>
        <td><?php echo $r['uname']; ?></td>
        <td><?php echo $r['money']; ?></td>        
     	<td><?php echo date('Y-m-d H:i:s',$r['pay_time']); ?></td>
     	<td><?php echo $r['pay_time_complete']==0?'-':date('Y-m-d H:i:s',$r['pay_time_complete']); ?></td>
        <td>
        <?php 
        if($r['pay_state']==0){
			echo '<font color=#999>等待付款</span>';
		}else if($r['pay_state']==1){
			echo '<font color=green>付款成功</font>';
			
		}else{
			echo '<font color=red>付款失败</span>';
		}
        
        ?>
        </td>
        
        <td><a href="<?php echo $this->createUrl('userPay/update');?>?id=<?php echo $r['pay_id'];  ?>&p=<?php echo $_GET['p'];  ?>">修改</a></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
  <div class="mt10">
   （合计：<span class="red2">￥</span>）    
  </div>
  
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>