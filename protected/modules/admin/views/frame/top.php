<?php $_GET['layout']=isset($_GET['layout'])?$_GET['layout']:''; ?>
<?php 
$page['doctype']=1;
$page['body_extern']='style="overflow:hidden;" class="body_top"';
?>
<?php require(dirname(__FILE__)."/../common/head.php"); ?>


<script>
function set_admin_style(style_folder){
	$.cookie("admin_style",style_folder,{expires:1000,path:'/'});
	parent.location.reload();	
}
</script>
<style>
.stylebox a{ display:inline-block; width:15px; height:15px; margin-right:5px; overflow:hidden; text-indent:100px; line-height:100px; vertical-align:middle;}
</style>
<div style="height:30px;text-align:right;">
<div class="r" style=" padding:5px 10px 0 0;"><?php //print_r($_SESSION); ?>
<!--<a href="frame.php?layout=<?php echo $this->layout==''?2:''; ?>" target="_parent">[修改布局]</a>-->
<span class="stylebox">
<?php 
foreach($this->AdminStyleArray as $r){
    echo '<a href="javascript:void(0);" onclick="set_admin_style(\''.$r['style_folder'].'\');" style="background:'.$r['style_color'].';" title="'.$r['style_name'].'">'.$r['style_name'].'</a>';	
}
?>
</span>

<a href="<?php echo $this->createUrl("frame/welcome");?>" target="main">[系统主页]</a>
欢迎您的登录，<?php echo Yii::app()->admin_user->uname; ?>，您的级别 [<?php echo Yii::app()->admin_user->groupname; ?>]  
<a href="<?php echo $this->createUrl("site/editPassword");?>" target="main">修改密码</a>
<a href="/" target="_blank">网站主页</a>
<a href="<?php echo $this->createUrl('site/logout'); ?>" target=_parent>[退出]</a>
</div>
</div>
<?php if($this->layout==''){ ?>
<div class="topmenu">
<ul>
<?php 
foreach(C('menu_left') as $menu){
?>
<?php $this->check_u_menu(array('code'=>'<li><a href="'.$menu['url'].'"  target="left_frame">'.$menu['title'].'</a></li>','auth_tag'=>$menu['auth_tag'])); ?>
<?php 
}
?>
</ul>
</div>
<?php }?>
<div id="sound_box" style=" height:1px; overflow:hidden; position:relative; width:1px; position:absolute;"></div>

<?php require(dirname(__FILE__)."/../common/foot.php"); ?>