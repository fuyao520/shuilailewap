<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">系统 »  企业	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value="删除选中" onclick="set_some('<?php echo $this->createUrl('companyUser/delete'); ?>?ids=[@]','确定删除吗？');" />
           <input type="button" class="but2" value="停用帐号" onclick="set_some('<?php echo $this->createUrl('companyUser/changeState'); ?>?ids=[@]&ustate=1','确定停用吗？');" />
           <input type="button" class="but2" value="启用帐号" onclick="set_some('<?php echo $this->createUrl('companyUser/changeState'); ?>?ids=[@]&ustate=0','确定启用吗？');" />
           <input type="button" class="but2" value="添加企业" onclick="location='<?php echo $this->createUrl('companyUser/update'); ?>'" />
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
        <th align='center'>	<?php echo helper::field_paixu(array('url'=>''.$this->createUrl('companyUser/index').'?p='.$_GET['p'].'','field_cn'=>'企业ID','field'=>'uid')); ?></th>
        <th  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('companyUser/index').'?p='.$_GET['p'].'','field_cn'=>'手机','field'=>'uphone')); ?><span class="gray">（<?php echo helper::field_paixu(array('url'=>''.$this->createUrl('companyUser/index').'?p='.$_GET['p'].'','field_cn'=>'登录帐号','field'=>'uname')); ?>）</span></th>
        <th>真实名称</th>
        <th>公司名称</th>
		<th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('companyUser/index').'?p='.$_GET['p'].'','field_cn'=>'地区','field'=>'city_name')); ?></th>
		<th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('companyUser/index').'?p='.$_GET['p'].'','field_cn'=>'注册时间','field'=>'reg_date')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('companyUser/index').'?p='.$_GET['p'].'','field_cn'=>'状态','field'=>'a.ustate')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('companyUser/index').'?p='.$_GET['p'].'','field_cn'=>'审核','field'=>'a.audit')); ?></th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td>
        <input type="checkbox" class="cklist" value="<?php echo $r['uid']; ?>" />
        </td>
        <td><?php echo $r['uid']; ?></td>
        <td class="alignleft"><div><?php echo $r['uphone']; ?><span class="gray">（<?php echo $r['uname']; ?>）</span></div></td>
        <td><?php echo $r['uname_true']; ?></td>
        <td><?php echo $r['company_name']; ?></td>
		<td><?php echo $r['city_name']; ?></td>
        <td><?php echo date('Y-m-d',$r['reg_date']); ?></td>
        <td><?php 
		if($r['ustate']==0){
		    echo '<span class=green>正常</span>';	
		}else if($r['ustate']==1){
		    echo '<span class=red>停用</span>';	
		}
		?></td>
		<td><?php 
		if($r['audit']==0){
			echo '<span class=red>暂未审核</span>';	    
		}else if($r['audit']==1){
		    echo '<span class=green>通过审核</span>';
		}
		?></td>
        
        
        <td>
		
       <a href="<?php echo $this->createUrl('companyUser/update'); ?>?id=<?php echo $r['uid'];  ?>&p=<?php echo $_GET['p'];  ?>">修改</a>
 
        </td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>