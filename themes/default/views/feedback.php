<!DOCTYPE html>
<html> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<title><?php echo Yii::app()->params['basic']['seo_title'] ?></title>
<meta name="keywords" content="<?php echo Yii::app()->params['basic']['seo_keyword'] ?>" />
<meta name="description" content="<?php echo Yii::app()->params['basic']['seo_description'] ?>" />
<link rel="stylesheet" href="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/formly.css?f4925942fa13cdd2" type="text/css" />
<link rel="stylesheet" href="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/colorbox.css?f4925942fa13cdd2" />
<!--styles for IE -->
<!--[if lte IE 7]><link rel="stylesheet" href="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/ie.css" type="text/css" media="screen" /><![endif]-->
<!--styles -->
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.external.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/common.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/js/common.js"></script>
<script language="javascript" type="text/javascript" src="/css/lib/nbspslider-1.1/jquery.nbspSlider.1.1.js" ></script>
<link href="/css/lib/nbspslider-1.1/css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	
});
</script>
</head>
<body>
<?php include(dirname(__FILE__)."/common/head.php"); ?>


<div class="list width">
  <div class="row bg bordertxt01">
    <div class="twelvecol">
      <div class="my-login">
        <div class="feedback_container formlyWrapper-Base">  
            <form action="post.php?m=message01" method="post" onSubmit="return ck_message01();">
      <script>
      function ck_message01(){
		 try{
			 var data="username="+$("#username").val()+
					 "&mobile="+$("#mobile").val()+
					  "&content="+$("#content").val()
					  ;
			$.post("/post/message",data,function(data){//alert(data);
			    try{
				    var json=$.evalJSON(data);
					if(json.code<1){
						alert(json.words);
					}else{
						alert(json.words);
						window.location.reload();
					}	
				}catch(e){alert(e.message);}	
			});
			return false;
		 }catch(e){alert(e.message);return false;}  
	  }
	  
      </script>
        <?php $page['formdatas']=$c->form_list(array('table'=>'liuyan','cate_id'=>$page['cate']['cate_id'],'p'=>$page['get']['p'],'pagesize'=>12)) ?>
        <?php foreach($page['formdatas']['list'] as $r ){ ?>
       <ul class="feedback_loop">
        <li class="feedback_message">
	        <div class='feedback_content'>
				<div class='feedback_un l'><?php echo $r['username']; ?></div>
				<div class='feedback_ut l'><?php echo date('Y-m-d H:i:s',$r['create_time']); ?></div>
				<div class="clear"></div>
				<div class="feedback_con"> <?php echo $r['content']; ?></div>
	        </div>
        </li>
        <?php if($r['reply']){ ?>
        <li class="feedback_reply">
           
                        <p><b>回复：</b></p>
            <span><p>
	<?php echo $r['reply']; ?>
</p></span>
                    </li>
        <?php }?>
        </ul>
          <?php }?>
		<div class="feedback_page">
       		<div class="pagebar">  <?php echo $page['formdatas']['pagecode']; ?></div>
		</div>
		
		 <div class="lybox">
                  <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                    <tr class="tabtxt01">
						<td>称　　呼 ：</td>
						<td><input type="text" size="15" name="username" id="username" class="ipu" autocomplete="off"    ></td>
					</tr>
                    
					<tr class="tabtxt01">
						<td>手机号码 ：</td>
						<td><input type="text" size="20" name="mobile" id="mobile" class="ipu" autocomplete="off"    ></td>
					</tr>
                    <tr class="tabtxt02">
                      <td class="zc" width="69">留言内容：</td>
                      <td style="padding:2px 0 0px;" colspan="3"><textarea rows="2" cols="70" name="content" id="msg_content" class="ipu1" autocomplete="off"    ></textarea></td>
                    </tr>
                    <tr class="tabtxt01">
                      <td>&nbsp;</td>
                      <td style="padding:5px 0;" colspan="3"><input type="submit" value="提交留言" class="inp2">  <span style="color:red; font-size:12px;" id="msgstate"></span> </td>
                    </tr>
                  </tbody></table>
                </div>
      </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include(dirname(__FILE__)."/common/foot.php"); ?>
</body>
</html>