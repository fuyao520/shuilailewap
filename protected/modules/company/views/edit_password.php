<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>    
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            
            <div class="site-title">
            基本信息设置
			</div>
            <div style="height:484px; overflow:hidden; overflow-y:auto;"> 
		        <div class="marindefault">
		        
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
				    <td class="zctd">新密码：</td>
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
				    <td class="zctd">&nbsp;</td>
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

<?php include(dirname(__FILE__)."/foot.php")?>
<script>

</script>


</body>
</html>
