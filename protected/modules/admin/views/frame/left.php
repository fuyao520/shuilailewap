<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
$(document).ready(function(){
	
    $(".leftmenu ul li.menubig").click(function(){
	    var id=$(this).attr("id");
		$(".leftmenu ul li").each(function(){
			if(!$(this).attr("id")){
				<?php if(Yii::app()->params['management']['menu_open']==0){ ?>
				$(this).stop().hide('fast');
				<?php }?>
			}	
		})
		$("."+id).stop().slideToggle('fast');	
	})
	<?php if(Yii::app()->params['management']['menu_open']==0){ ?>
	$(".leftmenu ul li.menubig").eq(0).click();
	<?php }?>
	
})
</script>
<style>
html{ overflow:auto;}
body{ background:url(../img/menu-shadow.png) repeat-y right #f5f3f3;overflow:hidden;}
</style>
<div class="leftmenu">
<ul>
<?php if($this->layout==''){ ?>
	<?php
    $_GET['auth_tag']=isset($_GET['auth_tag'])?$_GET['auth_tag']:''; 
    foreach(struct::$menu_left as $menu){
    if($menu['auth_tag']==$_GET['auth_tag']){
    ?>
    <h3><?php echo $menu['title']; ?></h3>
    <?php foreach($menu['smenu'] as $menu2){ ?>
    <?php if(isset($menu2['hide'])&&$menu2['hide']==1)continue; ?>
    <?php $this->check_u_menu(array('code'=>'<li><a href="'.$menu2['url'].'"  target="main">'.$menu2['title'].'</a></li>','auth_tag'=>$menu2['auth_tag'])); ?>
    <?php }?>
    <?php 
    break;
    }
    }
    ?>

<?php }else{?>


	<?php 
    foreach(struct::$menu_left as $menu){
    ?>
    <?php if(isset($menu['hide'])&&$menu['hide']==1)continue; ?>
    <?php $this->check_u_menu(array('code'=>'<li class="menubig" id="menuss'.$menu['auth_tag'].'"><a href="'.(count($menu['smenu'])==0?$menu['url']:'javascript:void(0);').'"  target="main"><span class="structico struck_'.$menu['auth_tag'].'"></span>'.$menu['title'].'</a></li>','auth_tag'=>$menu['auth_tag'])); ?>
        <?php foreach($menu['smenu'] as $menu2){ ?>
        <?php if(isset($menu2['hide'])&&$menu2['hide']==1)continue; ?>
        <?php $this->check_u_menu(array('code'=>'<li '.(Yii::app()->params['management']['menu_open']==0?'style="display:none;"':'').' class="menuss'.$menu['auth_tag'].'"><a href="'.$menu2['url'].'"  target="main"><span class="structspace"></span>'.$menu2['title'].'</a></li>','auth_tag'=>$menu2['auth_tag'])); ?>
    <?php }?>
    <?php 
    }
    ?>
    
<?php }?>
</ul>
</div>
