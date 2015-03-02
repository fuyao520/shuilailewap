<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
function get_select_branch(jsonstr){
   //alert(jsonstr);
   try{
	   var data=$.evalJSON(jsonstr);
	   $("#forcity").html(data.branch_province+'-'+data.branch_city); 
	   $("#branch_id").val(data.branch_id); 
	   $("#branch_name").html(data.branch_name);   
   }catch(e){alert(e.message);}
}
</script>
<?php 
if(!isset($page['info'])){
	$page['info']['uid']='';
	$page['info']['group_id']='';
	$page['info']['uname']='';
	$page['info']['upass']='';
	$page['info']['uname_true']='';
	$page['info']['uemail']='';
	$page['info']['uphone']='';

}
?>

<div class="main mhead">
    <div class="snav">系统 »  
    会员会员 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('user/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['uid']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['uid']?'修改会员':'添加会员' ?></th>
    </tr> 
    <tr>
        <td  width="100">会员组：</td>
        <td  class="alignleft">
        <select name="group_id">
		<?php echo helper::get_option(array('table_name'=>'user_group','id_field_name'=>'group_id','txt_field_name'=>'group_name','select_value'=>$page['info']['group_id'])); ?>
        </select>
        </td>      
    </tr>
    <tr>
        <td  width="100">帐号：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="uname" autocomplete="off"   name="uname" value="<?php echo $page['info']['uname']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">密码：</td>
        <td  class="alignleft">
        <input type="password"  class="ipt"  id="upass" autocomplete="off"    name="upass" value=""/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">会员电话：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="uphone"   name="uphone" value="<?php echo $page['info']['uphone']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">会员邮箱：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="uemail"   name="uemail" value="<?php echo $page['info']['uemail']; ?>"/> 
        </td>      
    </tr>      
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('user/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>