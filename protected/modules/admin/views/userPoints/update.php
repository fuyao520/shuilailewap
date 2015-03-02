<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['points_id']='';
	$page['info']['uid']='';
	$page['info']['points_reason']='';
	$page['info']['points']='';
}
?>

<div class="main mhead">
    <div class="snav">用户中心 »  
    会员积分管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('userPoints/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['points_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['points_id']?'修改积分':'添加积分' ?></th>
    </tr> 
    <tr>
        <td  width="100">会员的ID：</td>
        <td  class="alignleft">
        <input type="text" size="10"  class="ipt"  id="uid"   name="uid" value="<?php echo $page['info']['uid']; ?>"/>  <span class="red"> * 直接填写会员的ID号 </span>

        </td>      
    </tr>
    <tr>
        <td  width="100">积分数量：</td>
        <td  class="alignleft">
        <input type="text" size="5"  class="ipt"  id="points"   name="points" value="<?php echo $page['info']['points']; ?>"/>  <span class="red"> * 如果要扣除 请用 减号， 如 -20，增加 的话 直接填写数字 </span>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">积分产生原因：</td>
        <td  class="alignleft">
        <textarea style="width:400px; height:40px;" id="points_reason" name="points_reason"><?php echo $page['info']['points_reason']; ?></textarea>
        </td>      
    </tr>

    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('userPoints/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>