<script>
$(document).ready(function(){
	try{
	show_evaluate(1);
	$("#comment_sub").bind('click',function(){post_evaluate();})	
	}catch(e){alert(e.message)};
})
function show_evaluate(p){
	if(!p) p=1;
    $.getJSON("<?php echo $config['basic']['siteurl'] ?>/post.php?m=get_evaluate&p2="+p+"&cate_id=<?php echo $page['info']['last_cate_id']; ?>&info_id=<?php echo $page['info']['info_id']; ?>&jsoncallback=?",function(json){
		try{
			var list='';
			$("#comment_total02").html(json.total);
			var pagecode='<div class=pagebar_easy>'+decodeURIComponent(json.pagecode)+'</div>';
			for(var i=0;i<json.data.length;i++){
			    list+='<li class="word">'+
				'<font class="f2">'+(json.data[i].uname?json.data[i].uname:'匿名')+'</font> <font class="f3">('+getLocalTime(json.data[i].create_time)+' )</font><br>'+
				'<img alt="" src="<?php echo $config['basic']['cssurl']; ?><?php echo $config['basic']['tpl']; ?>/images/stars'+json.data[i].comment_rank+'.gif">'+
				'<p>'+json.data[i].content+'</p>'+
				(json.data[i].reply?'<div class="reply_box02">'+json.data[i].reply+'</div>':'')+
				'</li>';
			}
			list='<ul class="comments">'+list+'</ul>';
			$("#evaluate_main").html(list+pagecode);
		}catch(e){alert(e.message);}
	})	
}
function post_evaluate(type){
    var content=$("#comment_content").val();
	if(content.replace(/\s*/,'').length<2){
	    alert('长度应为2-1000');
		return false;	
	}
	$("#comment_content").val('');
	try{
	var comment_rank=$(".comment_rank::checked").val();
	$.getJSON("<?php echo $config['basic']['siteurl'] ?>/post.php?m=save_evaluate&cate_id=<?php echo $page['info']['last_cate_id']; ?>&info_id=<?php echo $page['info']['info_id']; ?>&content="+encodeURIComponent(content)+"&comment_rank="+encodeURIComponent(comment_rank)+"&jsoncallback=?",function(json){
		try{
		if(json.code<1){
		    alert(json.statewords);
			return;	
		}else{	
		$("#evaluate_main").html('评论加载中... ');	
		show_evaluate();
		}
		}catch(e){alert(e.message);}
	})
	}catch(e){alert(e.message)}
	
}
function getLocalTime(nS) {   
   return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");     
}  
</script>

      <div class="site-title">用户评论<span class="text">(共<font class="f1" id="comment_total02"></font>条评论)</span></div>
      <div style="height:1%;" class="boxCenterList clearfix">
       <div id="evaluate_main" class="evaluate_main">
       </div>      
      <div class="evaluateformbox">
     <form id="commentForm" name="commentForm" method="post" onsubmit="return post_evaluate()" action="javascript:;">
         <div>评价等级：
          <input type="radio" value="1" class="comment_rank" name="comment_rank"> 非常不满意
          <input type="radio"  value="2" class="comment_rank" name="comment_rank">不满意
          <input type="radio"  value="3" class="comment_rank" name="comment_rank"> 一般
          <input type="radio"  value="4" class="comment_rank" name="comment_rank"> 满意
          <input type="radio" checked="checked" class="comment_rank" value="5" name="comment_rank"> 非常满意
          </div>
          <div>
         评论内容：
          <textarea style="height:50px; width:620px;" class="inputBorder" id="comment_content"></textarea>
         </div>
         <div class="evaluatetijiaobox">
          <input type="submit"  class="btnB" value="提交评论">
         </div>
      </form>
      </div>
      
      </div>
  