<?php include(dirname(__FILE__)."/head.php")?>
<style>
.gray{color:#999;}
</style>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<div class="width-u">
    <div class="clearfix mt10">
        <a href="/" class="logo">企业中心</a>
    </div>
    
	<div class="user_form2">
	<?php if($page['connect_data']['type']){?>
			  	<div class="media-user-box">
			  	  <img src="<?php echo $page['connect_data']['tou_img'];?>" width=30 height=30>	<?php echo $page['connect_data']['nickname'];?>，您已经登陆<?php echo $page['connect_data']['name'];?>，注册成功将会绑定本账号
			  	</div>
			  	<?php }?>	
	  <form id="form_reg" method="post" autocomplete="off"  onsubmit="if(!check_agree_xieyi()){return false;}return ck_company_reg()" autocomplete="off">
      	  <h3 class="user-reg-tit">账户信息</h3>
          
	      
	      <div><span class="zc"> <font class="tips-need">*</font>帐　　号：</span><input type="text" class="inputBg"  id="uname" autocomplete="off" onkeyup="check_uname();"/>
	      	<span id="uname-state"></span>
	      	<span class="gray"> 请取一个与公司名相关的、便于记忆的登录名。5-15位字符，支持 英文、数字、下划线</span>
	      </div>
	      
	      <div><span class="zc"><font class="tips-need">*</font>密　　码：</span><input type="password" class="inputBg" id="upass" autocomplete="off"/> <span class="gray"> 6-20位，建议不要过于简单噢~</span></div>
	      <div><span class="zc"><font class="tips-need">*</font>确认密码：</span><input type="password" class="inputBg" id="upass2" autocomplete="off"/> <span class="gray">  请再次输入</span></div>
	      
          <h3 class="user-reg-tit">联系方式</h3>
          <div><span class="zc"><font class="tips-need">*</font>真实姓名：</span><input type="text" class="inputBg"  id="uname_true"/> 
          	   <input type="radio" value="1"> 先生  <input type="radio" value="2"> 女士    	
          </div>
          <div><span class="zc"><font class="tips-need">*</font>区域网点：</span>
          		<span id="t_s_area"></span>
                <span id="t_s_area_load"></span> 
                   <script>cg_edit_sele_cc("0","area[]","t_s_area","1","112083",3);</script>
          </div>
          <div><span class="zc"><font class="tips-need">*</font>邮　　箱：</span><input type="text" class="inputBg" id="uemail"/></div>
          <div><span class="zc"><font class="tips-need">*</font>手机号码：</span><input type="text" class="inputBg"  id="cellphone"/></div>
          <div><span class="zc"><font class="tips-need">*</font>手机验证码：</span><input type="text" class="inputBg"  id="cellphone_rancode" style="width:100px;"/>   <input type="button" value="点击获取" id="clickgetbtn01" onclick="sent_cellphone_message(1);" autocomplete="off" /> <span id="cellstate"></span> <span id="trysendtimebox"></span></div> 
          <div><span class="zc"><font class="tips-need">*</font>QQ号码：</span><input type="text" class="inputBg" id="uqq"/></div>
          
          <h3 class="user-reg-tit">水站信息</h3>
          <div><span class="zc"><font class="tips-need">*</font>水站名称：</span><input type="text" class="inputBg" id="company_name"/> <span class=gray> 请提供在工商注册的公司全称</span></div>
          <div><span class="zc"><font class="tips-need">*</font>座机电话：</span><input type="text" class="inputBg" id="company_tel"/></div>
          
          
          <div><span class="zc">验证码：</span><input type="text"  class="inputBg size100"  name="reg_rancode" id="reg_rancode" size="10"   style="width:100px;"/>
	      <img src="<?php echo $this->createUrl('verifyCode/index');?>?type=get_reg_rancode" onClick="refresh_rancode('img0022')" id="img0022" />
           看不清？<a href="#" onClick="refresh_rancode('#img0022')">换一张</a>
          </div>
          <div><span class="zc"></span><span  id="reg_state"></span> </div>
	      <div><span class="zc"></span><input type="submit"  id="sub01" class="btn0101" value="确定注册" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/images/zhuce.jpg"  />
	      <a href="<?php echo $this->createUrl('site/login');?>"> 我要登录 »</a></div>
	      
	      <div>
	      	<span class="zc"></span>
	      	 <input type=checkbox id="agree_xieyi"  > 我已阅读并同意<a href="#" target=_blank>《使用协议》</a>
	      </div>
	  </form>
	</div>
</div>



<?php include(dirname(__FILE__)."/foot.php")?>
<script>
function check_uname(){
	var uname=encodeURIComponent($("#uname").val());
	$.get("<?php echo $this->createUrl('site/checkUname');?>?uname="+uname,function(jsonstr){
		var json=eval('('+jsonstr+')');
		if(json.state<=0){
			$("#uname-state").html('<span class="ico ng">'+json.msgwords+'</span>');
		}else{
			$("#uname-state").html('<span class="ico ok">'+json.msgwords+'</span>');
		}
	})
}
function check_agree_xieyi(){
	if(!$("#agree_xieyi").attr("checked")){
		art.dialog({content:"请勾选阅读并同意《使用协议》",lock:true});
		return false;
	}
	return true;
}
</script>

</body>
</html>