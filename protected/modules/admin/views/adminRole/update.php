<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['role_id']='';
	$page['info']['role_name']='';
}
?>
<div class="main mhead">
    <div class="snav">系统功能 »  
    角色管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('adminRole/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['role_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['role_id']?'修改角色':'添加角色' ?></th>
    </tr>   

    
    <tr>
        <td  width="100">角色名称：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="role_name"   name="role_name" value="<?php echo $page['info']['role_name']; ?>"/> 

        </td>      
    </tr>
 </table>   
  <div style="text-indent:10px;" class="mt10"><strong>组权限：</strong></div>
   <?php
   $c=0;
foreach(struct::$menu_left as $menu){if(isset($menu['hide'])&&$menu['hide']==1)continue; 
?>
<table class="tb mt10 tb4">
<tr>
<th><label><input type="checkbox" <?php  checked($page,$menu['auth_tag']); ?>  name="role_levels[]" value="<?php echo $menu['auth_tag']; ?>"/> <?php echo $menu['title']; ?></label></th>
</tr>
<tr>
<td><div class="less2">
<?php
 foreach($menu['smenu'] as $menu2){$c++;if(isset($menu2['hide'])&&$menu2['hide']==1)continue;  ?>
<div class="wwwd_<?php echo $c; ?>">
 <label><input  type="checkbox" onclick="$('.wwwd_<?php echo $c; ?>').find('.chs').attr('checked',true)" <?php  checked($page,$menu2['auth_tag']); ?> name="role_levels[]" value="<?php echo $menu2['auth_tag']; ?>"/> <strong><?php echo $menu2['title'] ;?></strong></label> 
<?php
    if(isset($menu2['auth_func'])){
    foreach($menu2['auth_func'] as $menu3){ ?>
 <label><input class="chs" type="checkbox" <?php  checked($page,$menu3['auth_tag']); ?> name="role_levels[]" value="<?php echo $menu3['auth_tag']; ?>"/> <?php echo $menu3['name'] ;?></label><?php }} ?> 
</div>

<?php } ?>
</div>
</td>
</tr>
</table>
<?php 
}
?><br />  
    

  <input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('adminRole/index'); ?>?p=<?php echo $_GET['p'];?>'" />
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>
<?php 
function checked($page,$myvalue){
	$arr=is_array($page['role_auth'])?$page['role_auth']:array();
	foreach($arr as $r){
	    if($r==$myvalue){
		    echo ' checked ';	
		    break;
		}
			
	}
}

?>
