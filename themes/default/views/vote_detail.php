<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $config['basic']['sitename']; ?></title>
<link href="<?php echo $config['basic']['cssurl']; ?>default/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo $config['basic']['cssurl']; ?>lib/clud_zoom/clud_zoom.css" />
<script src="<?php echo $config['basic']['cssurl']; ?>default/js/common.js"></script>
<script src="<?php echo $config['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo $config['basic']['cssurl']; ?>lib/js/jquery.external.js"></script>
<script src="<?php echo $config['basic']['cssurl']; ?>lib/clud_zoom/cloud_zoom.1.0.2.js"></script>
<script src="<?php echo $config['basic']['cssurl']; ?>lib/artDialog4.1.7/artDialog.js?skin=idialog"></script>

</head>

<body>
<?php include(dirname(__FILE__).'/common/head.php'); ?>



<div class="wrap width mt10">
<?php 
if(function_exists("tpl__".$page['get']['m'])){
   call_user_func("tpl__".$page['get']['m']);
}
?>

<?php function tpl__show_vote_result(){ 
    global $page,$config;
?>
<div style="font-size:14px;"><span style=" font-weight:bold;"><?php echo $page['vote']['subject']; ?></span>(票数：<?php echo $page['vote']['votenumber']; ?>)</div>
<?php $i=0;foreach($page['vote']['options'] as $a){$i++;?>
   <div style="margin:10px;">
   <span style="vertical-align: middle; font-size:14px; display:inline-block; width:100px; overflow:hidden;"><?php echo $i; ?> <?php echo $a['option']; ?><font color="#cccccc">（<?php echo $a['option_id']; ?>）</font></span>
   <span style="display:inline-block; vertical-align:middle; width:400px; background:#ddd; height:20px;  position:relative;">
   <span style=" position:absolute; background: #06C; left:0px; top:0px; height:20px; width:<?php echo $a['vote_bai'].'%'; ?>;"></span>
   </span>
   
   票数：<?php echo $a['votes'];?>  得票率： <?php echo $a['vote_bai'].'%'; ?>
   </div>
<?php }?>

<?php }?>


<?php function tpl__show_vote_form(){ 
    global $page,$config;
?>
<div id="voteformbox_<?php echo $page['vote']['subject_id']; ?>">
    <div style="font-size:14px; font-weight:bold;"><?php echo $page['vote']['subject']; ?></div>
    <?php $i=0;foreach($page['vote']['options'] as $a){$i++;?>
        <div style="margin:10px;">
        <label>
           <?php if($page['vote']['is_checkbox']==0){ ?>
               <input type="radio" class="veteoption" autocomplete="off" name="veteoption" value="<?php echo $a['option_id']; ?>" />
           <?php }else{?>
               <input type="checkbox" class="veteoption" autocomplete="off" name="veteoption[]" value="<?php echo $a['option_id']; ?>" />
           <?php }?>
            <?php echo $i; ?> <?php echo $a['option']; ?>
         </label>
        </div>
    <?php }?>
    <input type="button" autocomplete="off"   class="votesub" value="确定" onclick="vote.sub(<?php echo $page['vote']['subject_id']; ?>);" />
    <?php if($page['vote']['allowview']){ ?>
    <a href="<?php echo $page['vote']['result_url']; ?>"> 查看结果 &gt;&gt;</a>
    <?php }?>
</div>
<?php }?>


</div>

<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>
</body>
</html>