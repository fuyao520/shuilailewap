<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['csno']='';
	$page['info']['groupid']='';
	$page['info']['csname']='';
	$page['info']['cspwd']='';
	$page['info']['csname_true']='';
	$page['info']['csemail']='';
	$page['info']['csmobile']='';
	$page['info']['csname_true']='';
}
?>
<div class="main mhead">
    <div class="snav">系统功能 »  
    管理员管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('adminUser/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['csno']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['csno']?'修改管理员':'添加管理员' ?></th>
    </tr>
    <tr>
        <td  width="100">所属管理组：</td>
        <td  class="alignleft">
        <select name="groupid">
        <?php $a=AdminGroup::model()->get_groups(); ?>
        <?php foreach($a as $r){ ?>
		<option value="<?php echo $r['groupid']; ?>" <?php if($r['groupid']==$page['info']['groupid'])echo 'selected';?>><?php echo $r['groupname'];?></option>
        <?php }?>
        </select>
        </td>      
    </tr>      
    <tr>
    	<td>所属角色：</td>
    	<td>
    	<?php foreach($page['roles'] as $r){?>
    	<label><input type="checkbox" name="roles[]" value="<?php echo $r['role_id'];?>" <?php echo $r['checked']?'checked':'';?> ><?php echo $r['role_name']; ?></label>
    	<?php }?>
    	</td>
    </tr>
    <tr>
        <td  width="100">帐号：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="csname" autocomplete="off"   name="csname" value="<?php echo $page['info']['csname']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">真实姓名：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="csname_true" autocomplete="off"   name="csname_true" value="<?php echo $page['info']['csname_true']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">密码：</td>
        <td  class="alignleft">
        <input type="password"  class="ipt"  id="cspwd" autocomplete="off"    name="cspwd" value=""/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">管理员电话：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="csmobile"   name="csmobile" value="<?php echo $page['info']['csmobile']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">管理员邮箱：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="csemail"   name="csemail" value="<?php echo $page['info']['csemail']; ?>"/> 
        </td>      
    </tr>  
    
    
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('adminUser/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
