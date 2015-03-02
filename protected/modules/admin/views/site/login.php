<?php $page['doctype']=1; ?>
<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<style>
body{ background:#fbfbfb;}
.html_login{ border:1px solid #ccc; background:#fff;-webkit-box-shadow: 0px 4px 10px -1px #ccc;-moz-box-shadow: 0px 4px 10px -1px #ccc;box-shadow:0px 4px 10px -1px #ccc;behavior: url(/css/admin/ie-css3.htc); height:300px;}
</style>
<table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0">
    <tr><td align="center">

<div class="html_login">
   <div  class="tit"><?php echo Yii::app()->params['management']['name']; ?></div>
   <div style="height:20px;"></div>
   <div>
   <form method="post" action="<?php echo $this->createUrl("site/login") ?>">
      <table cellspacing="0" cellpadding="0" width="280" align="center" border="0">
        <tr>
            <td width="50" height="50">账号：</td>
            <td>&nbsp;<input type="text" id="uname" name="uname" value="" class="ipt ipt_uname" ></td>
        </tr>
        <tr>
            <td height="50">密码：</td>
            <td>&nbsp;<input type="password" id="upass" name="upass" value="" class="ipt ipt_upass" ></td>
        </tr>
        <tr>
            <td height="50">验证码：</td>
            <td>&nbsp;<input type="rancode" style="width:100px;" id="upass" name="rancode" value="" class="ipt" >
            <img class="imgcode" src="<?php echo $this->createUrl('post/VerifyCode')?>" onClick="refresh_code(this)" width="90" height="26" />
            </td>
        </tr>
        <tr>
            <td height="50">&nbsp;</td>
            <td>&nbsp;<input type="submit" id="admin_login" class="btn_login" value="">&nbsp;</td>
        </tr>
    </table>
    </form>
   </div>
</div>
</td>
</tr>
</table>
<script>

if(window.top != window.self ){
    window.top.location=window.location;
}


$(document).ready(function(){
	//refresh_code('.imgcode');
})
function refresh_code(eobj){
	var url=$(eobj).attr("src");
	var v=Math.random();
    if(url.match(/\?/)){
        url=url+'1'; 
    }else{
    	url=url+'?'+'1'; 
    } 
    $(eobj).attr("src",url)
}
</script>

</body>
</html>