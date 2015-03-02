<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
function comment_reply(comment_id,reply_content){
	$("#reply_content").val(reply_content);
	var dialog=art.dialog({
		title:'回复',
		lock:true,
		content:document.getElementById('reply_box'),
		button:[
		  {
			   name:"保存",
			   focus:true,
			   callback:function(){
				   this.button({name:"保存",disabled:true});
				   var data='comment_id='+comment_id+'&reply_content='+encodeURIComponent($("#reply_content").val());
				   $.post("<?php echo $this->createUrl('comment/saveReply');?>",data,function(jsonstr){
					   try{
					   var json=eval('('+jsonstr+')');
					   if(json.code<=0){
						   alert(json.statewords);	  
					   }else{
						   art.dialog({title:'提示',content:'保存成功',icon:'succeed',time:1,close:function(){dialog.close();window.location.reload();}});	 					   
					   }
					   }catch(e){alert(e.message);}
					   dialog.button({name:"保存",disabled:false});
				   })
				   
				   return false;
			   }
		  },
		  {
			   name:'取消'  
		  }
		  ]
	});
		
}

</script>


<div class="main mhead">
    <div class="snav">系统设置 »  <?php if(isset($_GET['comments_type'])){echo vars::get_field_str('comments_types',$_GET['comments_type']);} ?>评论管理 </div>
    
    <div class="mt10">
 		<form action="<?php echo $this->createUrl('comment/index'); ?>">
	    <select id="search_type" name="search_type">
	        <option value="keys" <?php echo $this->get('search_type')=='keys'?'selected':''; ?>>关键字</option>
	        <option value="id" <?php echo $this->get('search_type')=='id'?'selected':''; ?>>ID</option>
	    </select>&nbsp;
	    <input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" >
	    <input type="submit" class="but" value="查询"  >
    	</form>
    </div>
    <div class="mt10 clearfix">
        <div class="l">
    
           <input type="button" class="but2" value="删除选中" onclick="set_some('<?php echo $this->createUrl('comment/delete');?>?&ids=[@]','确定删除吗？');" />
           <input type="button" class="but2" value="审核通过" onclick="set_some('<?php echo $this->createUrl('comment/audit');?>?comments_type=<?php echo $this->get('comments_type'); ?>&ischeck=1&ids=[@]','none');" />
           <input type="button" class="but2" value="审核不通过" onclick="set_some('<?php echo $this->createUrl('comment/audit');?>?comments_type=<?php echo $this->get('comments_type'); ?>&ischeck=2&ids=[@]','none');" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="?m=save_order" name="form_order" method="post">
<table class="tb">
    <tr>
        <th><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th align='center'>ID</th>
        <th width="400"  class="alignleft">评论内容</th>
        <th>昵称</th>
        <th>评论时间</th>
         <th>IP</th>
        <th width=70>状态</th>
        <th>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['comment_id']; ?>" /></td>
        <td><?php echo $r['comment_id']; ?></td>
        <td class="alignleft"><div style="height:24px; line-height:24px; width:400px; overflow:hidden;"><span class="ccc">[来自：<?php echo $r['fromid']; ?>]</span><?php echo $r['comment']; ?></div></td>
        <td>
		<?php if($r['uid']){ ?>
		<?php echo $r['uname']; ?>
        <?php }else{?>
       <font color="#999999"> <?php echo $r['uname']; ?></font>
        <?php }?>
        </td>
        <td title="<?php echo date('Y-m-d H:i:s',$r['create_date']); ?>"><?php echo date('Y-m-d',$r['create_date']); ?></td>
        <td><?php echo $r['ipaddr']; ?></td>	
        <td><?php echo $r['ischeck']==1?'<span class="green">审核成功</span>':'<span class="red">审核失败</span>'; ?></td>	
        <td><a href="javascript:void(0);" onclick="comment_reply(<?php echo $r['comment_id']; ?>,'<?php echo htmlspecialchars($r['reply']); ?>');" title="<?php echo htmlspecialchars($r['reply']); ?>" <?php if($r['reply']){echo 'style="color:red;"';} ?>>回复</a></td>
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<div id="reply_box" style="display:none;">
	回复内容：<textarea style="width:400px; height:100px;" id="reply_content"></textarea>
</div>

<?php require(dirname(__FILE__)."/../common/foot.php"); ?>