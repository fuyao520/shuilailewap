<?php 
/*{
"name":"留言板列表"
}*/
?>
<?php $page['formdatas']=smartform::form_list(array('table'=>'message','cate_id'=>$_GET['cate_id'],'p'=>$_GET['p'],'pagesize'=>$page['cate']['csetting']['pagesize'])); ?>
<div style="padding:10px; margin:0 auto 10px; border-bottom:1px dotted #666666;">      
<?php foreach($page['formdatas']['list'] as $r ){ ?>
      <table width="100%" cellspacing="1" cellpadding="0" border="0" bgcolor="#ffffff" style="margin-top:10px;">
  <tbody>
  <tr>
    <td colspan="2"><span>昵称：</span><?php echo $r['username']; ?> <span>时间：</span><?php echo date('Y-m-d H:i:s',$r['create_time']); ?></td>
  </tr>
  <tr>
    <td >内容：</td>
    <td><?php echo $r['msg_content']; ?></td>
  </tr>
  <tr>
    <td>回复：</td>
    <td><?php echo $r['reply']; ?></td>
  </tr>
</tbody></table>
  <?php }?>
<div class="pagebar clearfix">  <?php echo $page['formdatas']['pagecode']; ?></div>
      </div>
      <form action="post.php?m=message01" method="post" onsubmit="return ck_message01();">
      <script>
      function ck_message01(){
		 try{
			 var data="username="+$("#username").val()+
					  "&mobile="+$("#mobile").val()+
					  "&msg_content="+$("#msg_content").val()
					  ;
			$.post("/post.php?m=message01",data,function(data){//alert(data);
			    try{
				    var json=$.evalJSON(data);
					if(json.code<1){
						alert(json.words);
					}else{
						alert(json.words);
						window.location='/';
					}	
				}catch(e){alert(e.message);}	
			});
			return false;
		 }catch(e){alert(e.message);return false;}  
	  }
	  
      </script>
       <div class="lybox">
                  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr>
                      <td class="zc">姓 名：</td>
                      <td><input type="text" size="10" name="username" id="username" class="ipu">
                        </td>
                    </tr>
                    <tr>
                      <td class="zc">手机号：</td>
                      <td><input type="text" size="10" name="mobile" id="mobile" class="ipu">
                        </td>
                    </tr>
                    <tr>
                      <td class="zc">留言内容：</td>
                      <td style="padding:8px 0 0px;" colspan="3"><textarea rows="5" cols="70" name="msg_content" id="msg_content" class="ipu1"></textarea></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td style="padding:15px 0;" colspan="3"><input type="submit" value="提交留言" >  <span style="color:red; font-size:12px;" id="msgstate"></span> </td>
                    </tr>
                  </tbody></table>
                </div>
      </form>