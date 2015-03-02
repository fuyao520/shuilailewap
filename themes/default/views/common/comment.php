 <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/style/comment.css">

<script type="text/javascript">
$(function(){
	$('#comment').val($('#comment')[0].defaultValue);
	$('#comment').live('focus',function(){
        var text=this.defaultValue.toString();
		if($(this).val()==text){$(this).val("").focus();}
		$(this).addClass('focus');
	}).live('blur',function(){
	    var text=this.defaultValue.toString();
		var t=$(this).val().replace(/[\r\n\s]/gim,'');
		if(t==""){
			$('#comment_sub').removeClass('obtn');
		    $(this).val(text);
		}
		$(this).removeClass('focus');
	}).live('keyup',function(e){
	    var t=$(this).val().replace(/[\r\n\s]/gim,'');
		if(t.length>=1 && t.length<=140){
		    $('#comment_sub').addClass('obtn');
		}
		else{$('#comment_sub').removeClass('obtn');}
		var s=140-t.length;
		if(s>=0){$('#fb-remind').html('还可以输入'+s+'字')}
		else{$('#fb-remind').html('已经超过<em">'+(-1*s)+'</em>字')}
	})
});
$(function(){
	try{
	show_comment(1);
	$("#comment_sub").bind('click',function(){post_comment();})	
	$("#comment_reply_sub").bind('click',function(){post_comment('reply');})	
	}catch(e){alert(e.message)};
})
function show_comment(p){
	if(!p) p=1;
    $.getJSON("<?php echo $this->createUrl('comment/getComment'); ?>?p2="+p+"&fromid=<?php echo $page['comment']['fromid']; ?>&jsoncallback=?",function(json){
		try{
			var pagecode=decodeURIComponent(json.pagecode);
			$("#c-main").html(decodeURIComponent(json.data)+pagecode);
			$("#c-all span").html(json.total);
		}catch(e){alert(e.message);}
	})	
}
function post_comment(type){
	var formid='';
	var pid=0;
	var commentnickname='';
	var comment_rancode='';
	if(type=='reply'){
		formid='comment_reply';
		pid=$("#comment_pid").val();
		commentnickname=$("#commentnickname_reply").val();
		comment_rancode=$("#comment_rancode_reply").val();
		
	}else{
		formid='comment';
		pid=0;
		commentnickname=$("#commentnickname").val();
		comment_rancode=$("#comment_rancode").val();
	}
	
    var comment=$("#"+formid).val();
	if(comment=='跪求大爷评论' && !type){
		alert('评论内容不能为空');
		return false;
	}
	if(comment.replace(/\s*/g,'').length<2 || comment.replace(/\s*/g,'').length>140){
	    alert('长度应为2-140');
		return false;	
	}
	if(commentnickname==''){
		alert('昵称不能为空');
		return false;	
	}	
	try{
	$.getJSON("<?php echo $this->createUrl('comment/saveComment'); ?>?pid="+pid+"&fromid=<?php echo $page['comment']['fromid']; ?>&comment="+encodeURIComponent(comment)+"&uname="+encodeURIComponent(commentnickname)+"&comment_rancode="+encodeURIComponent(comment_rancode)+"&jsoncallback=?",function(json){
		try{
		if(json.code<1){
		    alert(json.statewords);
			return;	
		}else{	
			$("#bak_reply_box").append($("#comment_reply_box"));
			$("#c-main").html('评论加载中... ');	
			show_comment();
			$("#"+formid).val('');
		}
		}catch(e){alert(e.message);}
	})
	}catch(e){alert(e.message)}
	
}
function ready_reply(comment_id){
	$("#comment_pid").val(comment_id);	
	$("#replay_frame_"+comment_id).append($("#comment_reply_box"));
	$("#comment_reply_box").css({"display":""});
	$("#comment_reply").focus();
	
}

//顶
function good_plus(comment_id,element){
	var comment_ids=C.cookie.get("comment_ids");
	var arr=[];
	if(comment_ids){
		arr=comment_ids.split('|');
	}
	for(var i=0;i<arr.length;i++){
		if(arr[i]==comment_id){
			alert('已经对该条评论顶or踩过');
			return false;	
		}	
	}
	$.getJSON("<?php echo $this->createUrl('comment/goodPlus'); ?>?comment_id="+comment_id+"&jsoncallback=?",function(json){
		try{
		if(json.code<1){
		    alert(json.statewords);
			return false;	
		}else{	
		
			arr.push(comment_id);
			var newcookie=arr.join('|');
			C.cookie.set('comment_ids',newcookie,24);
		    var gn=$(element).find(".goodnum");
			gn.html(parseInt(gn.html())+1);		
			
		}
		}catch(e){alert(e.message);}
		
	})
}
//顶
function bad_plus(comment_id,element){
	var comment_ids=C.cookie.get("comment_ids");
	var arr=[];
	if(comment_ids){
		arr=comment_ids.split('|');
	}
	for(var i=0;i<arr.length;i++){
		if(arr[i]==comment_id){
			alert('已经对该条评论顶or踩过');
			return false;	
		}	
	}
	$.getJSON("<?php echo $this->createUrl('comment/badPlus'); ?>?comment_id="+comment_id+"&jsoncallback=?",function(json){
		try{
		if(json.code<1){
		    alert(json.statewords);
			return false;	
		}else{	
		
			arr.push(comment_id);
			var newcookie=arr.join('|');
			C.cookie.set('comment_ids',newcookie,24);
		    var gn=$(element).find(".badnum");
			gn.html(parseInt(gn.html())+1);		
			
		}
		}catch(e){alert(e.message);}
		
	})
}
</script>

<div id="page-comment">
    <div class="hd">
        <h3 class="hd-title hd-icon-reply"><!--<img src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/icon/xgpp.png">--></h3>
        <div id="c-all" class="hd-more">共有<span></span>条评论</div>
    </div>
    <div class="c-box">
        <div id="c-main" class="c-main"> 评论加载中... </div>
        <div class="comment_form_box">
            <div id="showcommentstate"></div>
            <textarea id="comment" placeholder="跪求大爷评论"></textarea>
            <div class="fix c-login">
            <div class="fl checktxtbox"> <span id="fb-remind">还可以输入140字</span> </div>
            <div class="fr nick_sub_box"><label for="commentnickname">昵称：<input type="text" class="commentnickname" id="commentnickname" size="10" /></label>
                <label for="comment_rancode">验证码：<input size="6" type="text" class="commentrancode" id="comment_rancode" /></label>
                <img width="80" height="24" src="<?php echo $this->createUrl('verifyCode/index'); ?>?type=get_comment_rancode" onClick="refresh_rancode('#img0022')" id="img0022" />
                <button id="comment_sub" type="submit" class="comment_sub">提交评论</button>
            </div>
            </div>
        </div>
        <div id="bak_reply_box" style="display:none;"></div>
        <div class="comment_form_box" id="comment_reply_box" style="display:none;">
            <div class="replyclosebox"><a href="javascript:void(0);" onClick="$('#comment_reply_box').css({'display':'none'});">取消</a></div>
            <textarea id="comment_reply" placeholder="跪求大爷评论"></textarea>
            <input type="hidden"  id="comment_pid" value="0" />
            <div class="fix">
                <div class="fl commentdescbox"> </div>
                <div class="fr nick_sub_box"><label for="commentnickname_reply">昵称：<input type="text" class="commentnickname" id="commentnickname_reply" size="10" /></label>
                    <label for="comment_rancode_reply">验证码：<input size="6" type="text" class="commentrancode" id="comment_rancode_reply" /></label>
                    <img src="<?php echo $this->createUrl('verifyCode/index'); ?>?type=get_comment_rancode" onClick="refresh_rancode('#img0024')" id="img0024" />
                    <input type="button" value=" 回复评论 " id="comment_reply_sub" class="comment_sub"/>
                </div>
            </div>
        </div>
    </div>
</div>
