// JavaScript Document
//企业会员登录
function ck_company_login(connect_type,callback){
    try{
	$("#sublogin").attr("disabled",true);
	var data="uname="+$("#login_uname").val()+"&upass="+$("#login_upass").val()+"&rancode="+$("#login_rancode").val();
	$.post('/company/site/login?connect='+connect_type,data,function(data){
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
				    	window.location='/company/site/index';
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
function ck_company_reg(connect_type,callback){
    try{
	$("#sub01").attr("disabled",true);
	var data="uname="+$("#uname").val()+"&email="+$("#email").val()+
			 "&upass="+$("#upass").val()+
			 "&upass2="+$("#upass2").val()+
			 "&uemail="+$("#uemail").val()+
			 "&uphone="+$("#cellphone").val()+
			 "&uphone_rancode="+$("#cellphone_rancode").val()+
			 "&uname_true="+$("#uname_true").val()+
			 "&uqq="+$("#uqq").val()+
			 "&company_name="+$("#company_name").val()+
			 "&company_fax="+$("#company_fax").val()+
			 "&company_type="+$("#company_type").val()+
			 "&rancode="+$("#reg_rancode").val();
	$.post('/index.php/company/site/reg?connect='+connect_type,data,function(data){
		//alert(data);
		var jsondata=$.evalJSON(data);
	    if(jsondata.state<1){
			$("#sub01").attr("disabled",false);
		    $("#reg_state").html('<span class="ico ng">'+jsondata.msgwords+'</span>');	
		}else{
		    $("#reg_state").html('<span class="ico ok">'+jsondata.msgwords+'</span>');	
			if(!callback){
				setTimeout(function(){
					window.location='/index.php/company/site/regok';
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
	$.post('/index.php/company/site/editPassword',postdata,function(jsondata){
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

//获取一组checkbox选中值，返回选中值的数组
function get_group_checked(name){
	var list=new Array();
	$(name).each(function(){
		if($(this).attr('checked')=='checked'){
			list.push($(this).val());
		}
	});
	return list;
}


//加入收藏
function add_collect(model,info_id){
	var postdata={"model":model,"info_id":info_id};
	$.post("/index.php/company/collect/save",postdata,function(data){
		try{
		var json=$.evalJSON(data);
		if(json.state>0){
			art.dialog({content:'收藏成功',time:2,cancel:false,icon: 'succeed'});
		}else{
			art.dialog({content:json.msgwords,time:2,cancel:false,icon: 'warning'});
		}
		}catch(e){
			//alert(e.message);
			//alert('请登录后使用收藏功能');
			window.location='/member.php?url='+document.URL;
		}	
	})
}



//手机验证码发送，点击发送验证码
function sent_cellphone_message(type){
	var cellphone=$("#cellphone").val();
	var cellphone_rancode=$("#cellphone_rancode").val();
	if(cellphone.match(/^1\d{10}$/)==null){
	    $("#cellstate").html('<span style="color:red;">请输入正确的手机号码</span> ');
		return false;	
	}
	$("#clickgetbtn01").attr("disabled",true);
	var data="cellphone="+cellphone+"&cellphone_rancode="+cellphone_rancode;
	var postfile='sentMobileMessage';
	if(type==1){
		postfile='regSentMobileMessage';
	}
	$.post("/index.php/company/account/"+postfile,data,function(data){
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
	$.post("/index.php/company/account/bindMobile",data,function(data){
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