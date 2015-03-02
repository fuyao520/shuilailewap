// JavaScript Document
//检查登陆状态
function check_login(){
	$.getJSON("/user/post/checkLogin?jsoncallback=?",function(json){
	    try{
		if(json.islogin){
		    /*
			$("#welcome_box0003").html(
			' 亲爱的'+json.uname+'，'+
			'<a href="/user/site/index/"> <span class="red">管理中心</span> </a>'+
			'<a href="/user/site/logout/"> [退出] </a>'+
			'');	
			*/
			$("#welcome_box0003").show();
			$("#nologin_box003").css({"display":"none"});
			
			userinfo.isGuest=0;
			userinfo.uname=json.uname;
			//userinfo.company_name=json.company_name;
			$("#index-u-nologin_box003").css({"display":"none"});
			$("#index-u-uname,#welcome_uname").html(json.uname);
			$("#index-u-welcome_box0003").css({"display":""});
			$(".commentnickname").val(json.uname);
		}else{
			$("#nologin_box003").css({"display":""});			
		}	
		}catch(e){alert(e.message);}  
	});
}
//退出

function logout(jump_url){
	var postdata={"time":1};
	$.post("/user/site/logout",postdata,function(){
		window.location=jump_url;
	})
	return false;
	
	
}


//弹出登陆框
function show_login(){
	$.getJSON("/user/site/dialogLogin?jsoncallback=?",function(json){
		if(json.state==2){
			return;
		}		
		art.dialog({id:"111",content:json.data,lock:true,width:"800px"});
	});
	
}

//弹出登陆框，登陆成功之后的回调
function dialog_login_ok(){
	check_login();
	art.dialog.list[111].close();
	
}



//会员登录
function ck_user_login(connect_type,callback){
    try{
	$("#sublogin").attr("disabled",true);
	var data="uname="+$("#login_uname").val()+"&upass="+$("#login_upass").val()+"&rancode="+$("#login_rancode").val();
	$.post('/user/site/login?connect='+connect_type,data,function(data){
		//alert(data);
		var jsondata=$.evalJSON(data);
	    if(jsondata.state<1){
			$("#sublogin").attr("disabled",false);
		    $("#login_state").html('<span class="ico ng">'+jsondata.msgwords+'</span>');	
		}else{
		    $("#login_state").html('<span class="ico ok">'+jsondata.msgwords+'</span>');	
			setTimeout(function(){
				if($("#history_url").val()){
					window.location=$("#history_url").val();
				}else{
					if(!callback){
				    	window.location='/user/site/index';
					}else{
						callback=callback.replace(/__/g,"'");
					    eval(callback);
						return false;	
					}
					
				}
			},1000);
		}
	})
	return false;
	}catch(e){alert(e.message);return false;}	
}
function ck_user_reg(connect_type,callback){
    try{
	$("#sub01").attr("disabled",true);
	var data="uname="+$("#uname").val()+"&email="+$("#email").val()+
			 "&upass="+$("#upass").val()+
			 "&upass2="+$("#upass2").val()+
			 "&uemail="+$("#uemail").val()+
			 "&uphone="+$("#uphone").val()+
			 "&uname_true="+$("#uname_true").val()+
			 "&uqq="+$("#uqq").val()+
			 "&rancode="+$("#reg_rancode").val();
	$.post('/index.php/user/site/reg?connect='+connect_type,data,function(data){
		//alert(data);
		var jsondata=$.evalJSON(data);
	    if(jsondata.state<1){
			$("#sub01").attr("disabled",false);
		    $("#reg_state").html('<span class="ico ng">'+jsondata.msgwords+'</span>');	
		}else{
		    $("#reg_state").html('<span class="ico ok">'+jsondata.msgwords+'</span>');	
			if(!callback){
				setTimeout(function(){
					window.location='/index.php/user/site/regok';
				},1000);
			}else{
				eval(callback+'()');
				return false;	
			}
			
		}
	})
	return false;
	}catch(e){alert(e.message);return false;}	
}

function ck_edit_password(){
	var old_password=$("#old_password");
	var new_password=$("#new_password");
	var new_password2=$("#new_password2");
	var sub_btn=$("#editpassword_sub");	
	var state_inner=$("#editpassword_state_inner");
	
	sub_btn.attr("disabled",true);
	state_inner.html('');
	
	if(old_password.val().replace(/\s*/,'')==''){
		old_password.focus();
		state_inner.html('请输入您的密码');
		sub_btn.attr("disabled",false);
		return false;
	}
	if(new_password.val().match(/^(\w){6,20}$/)==null){
		new_password.focus();
		state_inner.html('新的密码格式不正确');
		sub_btn.attr("disabled",false);
		return false;
	}
    if(new_password.val()!=new_password2.val()){
		new_password2.focus();
		state_inner.html('确认密码输入不一致');
		sub_btn.attr("disabled",false);
		return false;
	}
	var postdata='old_password='+old_password.val()+'&new_password='+new_password.val();
	$.post('/index.php/user/site/editPassword',postdata,function(jsondata){
		try{
			var re=$.evalJSON(jsondata);
			if(re.state<=0){
				sub_btn.attr("disabled",false);
				state_inner.html(re.msgwords); 	
			}else if(re.state>0){			
				sub_btn.attr("disabled",true);
				state_inner.html('<span class="ico ok">'+re.msgwords+'</span>'); 
				
				
			}
		}catch(e){alert(e.message)}
		
	});
	return false;	
}

//忘记密码
function ck_forgetpassword(){
	var email=$("#forgetmail");
	var randcode=$("#forancode");
	var sub_btn=$("#forgetpassword_sub");
	
	var mail_state_inner=$("#mail_forget_state_inner");
	var rancode_state_inner=$("#racode_forget_state_inner");
	var state_inner=$("#forget_state_inner");
	
	sub_btn.attr("disabled",true);
	rancode_state_inner.html('');
	state_inner.html('');
	mail_state_inner.html('');
	if(email.val().match(/[\w]*@[\w]*\.[\w]*/)==null){
		mail_state_inner.html('<span class="ico ng">邮箱格式不正确</span>');
		sub_btn.attr("disabled",false);
		return false;
	}
    if(randcode.val().replace(/\s*/g,'')==''){
		rancode_state_inner.html('<span class="ico ng">验证码不能为空</span>');
		sub_btn.attr("disabled",false);
		return false;
	}
    state_inner.html('<span style="color:blue;">处理中...</span>'); 
	var postdata='rancode='+randcode.val()+'&email='+email.val();
	$.post('forgetpasswordCheck',postdata,function(jsondata){
		try{
			var re=eval('('+jsondata+')');
			if(re.state<=0){
				sub_btn.attr("disabled",false);
				state_inner.html('<span class="ico ng">'+re.msgwords+'</span>'); 	
			}else{				
				sub_btn.attr("disabled",true);
				state_inner.html('<span class="ico ok">'+re.msgwords+'</span>'); 
				setTimeout(function (){
				   // window.location='member.php?m=forgetpassword_sendemail_ok';	
				},1000)
				
				
			}
		}catch(e){alert('数据出错！');console.logs(e.message);}
		
	});
	  
	 
	
	 
  	return false;
}
//忘记密码-重置
function ck_reset_password(){
	var resetpassword=$("#resetpassword");
	var resetpassword2=$("#resetpassword2");
	var sub_btn=$("#resetpassword_sub");
	
	var resetpassword_state_inner=$("#resetpassword_msg_inner");
	var resetpassword2_state_inner=$("#resetpassword2_msg_inner");
	var state_inner=$("#resetpassword_state_inner");
	
	sub_btn.attr("disabled",true);
	resetpassword_state_inner.html('');
	resetpassword2_state_inner.html('');
	state_inner.html('');
	
	if(resetpassword.val().match(/^(\w){6,20}$/)==null){
		resetpassword_state_inner.html('<span class="ico ng">密码格式不正确</span>');
		sub_btn.attr("disabled",false);
		return false;
	}
    if(resetpassword.val()!=resetpassword2.val()){
		resetpassword2_state_inner.html('<span class="ico ng">两次密码输入不一致</span>');
		sub_btn.attr("disabled",false);
		return false;
	}
    state_inner.html('<span style="color:blue;">处理中...</span>'); 
	var postdata='forget_pass_code='+$("#forget_pass_code").val()+'&uid='+$("#uid").val()+'&password='+resetpassword.val();
	$.post('forgetpasswordResetSave',postdata,function(jsondata){
		try{
			var re=eval('('+jsondata+')');
			if(re.state<=0){
				sub_btn.attr("disabled",false);
				state_inner.html('<span class="ico ng">'+re.msgwords+'</span>'); 	
			}else{
				sub_btn.attr("disabled",true);
				state_inner.html('<span class="ico ok">'+re.msgwords+'</span>'); 
				setTimeout(function (){
				    window.location='login';	
				},3000)
				
				
			}
		}catch(e){alert('数据出错！');console.logs(e.message);}
		
	});
	return false;	
}


//全选反选勾选框
//name 为 $('') 选择符号
function check_all(name){
	$(name).each(function(){
		if($(this).attr('checked')=='checked'){$(this).attr({'checked':false});}else{$(this).attr({'checked':true});}
	});
}

//通用 提交 选中 的 checkbox 到指定页面
//url 中  用 [@]  代替  需要传入的 id 的集合，words 是 提示的文字，默认是 "确定吗"，如果传入的是none，的话，为不提示
function set_some(url,words,method,data){
    var idarr=get_group_checked('.cklist');
	words=words?words:'确定吗';
	if(idarr.length==0){alert('请选中至少一个');return false;}
	if(words.match(/none/)==null){
		if(!confirm(words)){
			return false;	
		}
	}
	
	var idarrs=idarr.join(',');
	var data=data.replace('[@]',idarrs);
	var url=url.replace('[@]',idarrs);
	//alert(url);
	if(method=='post'){
		$.post(url,data,function(jsonstr){
		     try{
			  var json=$.evalJSON(jsonstr);
			  if(json.code<1){
				  alert(json.msgwords);
				  return false;
			  }else{
				  window.location=window.location.href;
				  return false;
			  }	
		  }catch(e){alert(e.message);$("#sub01").attr("disabled",false);}	    	
		});
	}else{
		window.location=url;
	}
}


//手机验证码发送，点击发送验证码
function sent_cellphone_message(postfile){
	var cellphone=$("#cellphone").val();
	var cellphone_rancode=$("#cellphone_rancode").val();
	if(cellphone.match(/^1\d{10}$/)==null){
	    $("#cellstate").html('<span style="color:red;">请输入正确的手机号码</span> ');
		return false;	
	}
	$("#clickgetbtn01").attr("disabled",true);
	var data="cellphone="+cellphone+"&cellphone_rancode="+cellphone_rancode;
	$.post("/index.php/user/account/sentMobileMessage",data,function(data){
		try{
		var json=$.evalJSON(data);
		if(json.state>0){
			$("#cellstate").html('<span class="ico ok"> '+json.msgwords+'</span> ');
			try{
			var n=60;
			var trysendtime=setInterval(function(){
				n--;	
				$("#trysendtimebox").html(n+" 秒后可再次发送");
				if(n==0){
				    $("#clickgetbtn01").attr("disabled",false);
					$("#trysendtimebox").html('');
					clearInterval(trysendtime);	
				}
			},1000);
			}catch(e){alert(e.message);return false;}
			return;
		}else{
			$("#clickgetbtn01").attr("disabled",false);
			$("#cellstate").html('<span style="color:red;">'+json.msgwords+'</span> ');
			return false;
		}
		}catch(e){
			alert(e.message);
			//alert('请登录后使用收藏功能');
			//window.location='/member.php?url='+document.URL;
		}	
	})
	return false;
}

//检查手机验证码是否正确以及绑定手机
function bind_cellphone(){
	var cellphone=$("#cellphone").val();
	var cellphone_rancode=$("#cellphone_rancode").val();
	var cellphone_verify_code=$("#cellphone_verify_code").val();
	if(cellphone.match(/^1\d{10}$/)==null){
	    $("#verifystate").html('<span style="color:red;">请输入正确的手机号码</span> ');
		return false;	
	}
	if(cellphone_rancode.match(/^[\w]{4}$/)==null){
	    $("#verifystate").html('<span style="color:red;">请输入图片验证码</span> ');
		return false;	
	}
	if(cellphone_verify_code.match(/^[\w]{6}$/)==null){
	    $("#verifystate").html('<span style="color:red;">请输入六位数的短信验证码</span> ');
		return false;	
	}
	var data="cellphone="+cellphone+"&cellphone_rancode="+cellphone_rancode+"&cellphone_verify_code="+cellphone_verify_code;
	$.post("/index.php/user/account/bindMobile",data,function(data){
		try{
		var json=$.evalJSON(data);
		if(json.state>0){
			$("#verifystate").html('<span class="ico ok">验证成功！</span>  ');
			window.location=window.location.href;
			window.location.reload();			
			return;
		}else{
			$("#verifystate").html('<span style="color:red;">'+json.msgwords+'</span> ');
			return false;
		}
		}catch(e){
			alert(e.message);
			//alert('请登录后使用收藏功能');
			//window.location='/member.php?url='+document.URL;
		}	
	})
	return false;
	
}

//邮箱验证码发送，点击发送验证码
function sent_email_message(){
	var email=$("#uemail").val();
	var email_rancode=$("#email_rancode").val();
	if(!email){
	    $("#cellstate").html('<span style="color:red;">请输入正确的邮箱</span> ');
		return false;	
	}
	$("#clickgetbtn01").attr("disabled",true);
	var data="email="+email+"&email_rancode="+email_rancode;
	$.post("/index.php/user/account/sentEmailMessage",data,function(data){
		try{
		var json=$.evalJSON(data);
		if(json.state>0){
			$("#cellstate").html('<span class="ico ok"> '+json.msgwords+'</span> ');
			try{
			var n=10;
			var trysendtime=setInterval(function(){
				n--;	
				$("#trysendtimebox").html(n+" 秒后可再次发送");
				if(n==0){
				    $("#clickgetbtn01").attr("disabled",false);
					$("#trysendtimebox").html('');
					clearInterval(trysendtime);	
				}
			},1000);
			}catch(e){alert(e.message);return false;}
			return;
		}else{
			$("#clickgetbtn01").attr("disabled",false);
			$("#cellstate").html('<span style="color:red;">'+json.msgwords+'</span> ');
			return false;
		}
		}catch(e){
			alert(e.message);
			//alert('请登录后使用收藏功能');
			//window.location='/member.php?url='+document.URL;
		}	
	})
	return false;
}


//检查邮箱验证码是否正确以及绑定邮箱
function bind_email(){
	var email=$("#uemail").val();
	var email_rancode=$("#email_rancode").val();
	var email_verify_code=$("#email_verify_code").val();
	if(email.match(/^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$/)==null){
	    $("#verifystate").html('<span style="color:red;">请输入正确的手机号码</span> ');
		return false;	
	}
	if(email_rancode.match(/^[\w]{4}$/)==null){
	    $("#verifystate").html('<span style="color:red;">请输入图片验证码</span> ');
		return false;	
	}
	if(email_verify_code.match(/^[\w]{6}$/)==null){
	    $("#verifystate").html('<span style="color:red;">请输入六位数的短信验证码</span> ');
		return false;	
	}
	var data="email="+email+"&email_rancode="+email_rancode+"&email_verify_code="+email_verify_code;
	$.post("/index.php/user/account/bindEmail",data,function(data){
		try{
		var json=$.evalJSON(data);
		if(json.state>0){
			$("#verifystate").html('<span class="ico ok">验证成功！</span>  ');
			window.location=window.location.href;
			window.location.reload();			
			return;
		}else{
			$("#verifystate").html('<span style="color:red;">'+json.msgwords+'</span> ');
			return false;
		}
		}catch(e){
			alert(e.message);
			//alert('请登录后使用收藏功能');
			//window.location='/member.php?url='+document.URL;
		}	
	})
	return false;
	
}
//加入收藏
function add_collect(model,info_id,obj){
	var postdata={"model":model,"info_id":info_id};
	$.post("/index.php/user/collect/save",postdata,function(data){
		try{
		var json=$.evalJSON(data);
		if(json.state>0){
			var num=parseInt($(obj).parent().find(".dsrxh b").html());
			if(!num) num=0;
			num++;
			$(obj).parent().find(".dsrxh b").html(num);
			$(obj).removeClass('xh');
			$(obj).addClass('nxh');
			//art.dialog({content:'收藏成功',time:1,cancel:false,icon: "succeed",follow:obj});
		}else{
			//art.dialog({content:json.msgwords,lock:true,time:1,cancel:false,icon: 'warning'});
			
			//art.dialog({content:'收藏成功',time:1,cancel:false,icon: "succeed",follow:obj});
			//去取消收藏
			if($(obj).hasClass('xh')){
				var num=parseInt($(obj).parent().find(".dsrxh b").html());
				if(!num) num=0;
				num++;
				$(obj).parent().find(".dsrxh b").html(num);
				$(obj).removeClass('xh');
				$(obj).addClass('nxh');
				return;
			}
			$.post("/index.php/user/collect/cancel",postdata,function(data){
				var num=parseInt($(obj).parent().find(".dsrxh b").html());
				num--;
				if(!num||num<0) num=0;
				$(obj).parent().find(".dsrxh b").html(num);
				$(obj).removeClass('nxh');
				$(obj).addClass('xh');
			})
		}
		}catch(e){
			//alert(e.message);
			//alert('请登录后使用收藏功能');
			userinfo={"isGuest":1,"uname":""};
			show_login();
		}	
	})
}

//加关注
function savefans(uid2){
	var postdata={"uid2":uid2};
	$.post("/index.php/user/fans/save",postdata,function(data){
		try{
		var json=$.evalJSON(data);
		if(json.state>0){
			art.dialog({content:'关注成功',lock:true,time:2,cancel:false,icon: "succeed"});
		}else{
			art.dialog({content:json.msgwords,lock:true,time:2,cancel:false,icon: 'warning'});
		}
		}catch(e){
			alert(e.message+data);
			//alert('请登录后使用收藏功能');
			
		}	
	})
}
