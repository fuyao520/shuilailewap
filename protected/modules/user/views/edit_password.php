<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
        <div class="help_rig">
			<div class="laction"><h2>修改密码</h2> <span></span></div><!--laction end-->
            <div class="help_con">
				<div class="jfjl">
		        
				<form method="post" id="form_resetpassword"  name="form_resetpassword"   autocomplete="off"   onsubmit="return ck_edit_password();">     
				<table class="tb_up mt10">
				      <tbody>
				      <tr>
				    <td class="zctd">原始密码：</td>
				    <td><label>
				      <input type="password" id="old_password" name="old_password" class="inputBg">
				    *</label></td>
				    </tr>
				    
				  <tr>
				    <td  class="zctd">新密码：</td>
				    <td><label>
				    <input type="password" id="new_password" name="new_password" class="inputBg">
				    *</label></td>
				    </tr>
				  <tr>
				    <td  class="zctd">确认密码：</td>
				    <td><label>
				    <input type="password" id="new_password2" name="new_password2" class="inputBg">
				    *</label></td>
				    </tr>
				  <tr>
				    <td  class="zctd">&nbsp;</td>
				    <td><label>
				    <input type="submit" value="保存修改" id="editpassword_sub" name="button" class="btn02" >
				    </label><span id="editpassword_state_inner" style="color:red;"></span></td>
				  </tr>
				</tbody></table>
				      </form>
		        </div>
		    </div>
       </div>
 </div>

<?php include(dirname(__FILE__)."/common/foot.php")?>
<script>

</script>


</body>
</html>
