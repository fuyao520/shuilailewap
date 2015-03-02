<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">系统 »  
    欢迎页 </div>
</div>
<div class="main mbody">
    <div class="welcome_box">
         <div><h1>欢迎使用<?php echo Yii::app()->params['management']['name']?Yii::app()->params['management']['name']:Yii::app()->params['basic']['sitename']; ?> 。</h1></div>
         <p class="desc009">准备了几个链接供您开始：</p>
         <strong>开始使用</strong><br />
         <?php $this->check_u_menu(array('code'=>'<li class="bccc"><span class=icspan></span><a href="'.$this->createUrl('setting/index').'" class="but33">系统参数</a></li>','auth_tag'=>'setting')); ?>
    </div>
    <div class="list08 clearfix">
        
        <?php foreach(struct::$menu_left as $menu){?>
        <?php if(isset($menu['hide'])&&$menu['hide']==1)continue; ?>
        <ul>
			<?php $this->check_u_menu(array('code'=>'<li class="accc"><span class=icspan2></span><a href="javascript:void(0);" >'.$menu['title'].'</a></li>','auth_tag'=>$menu['auth_tag'])); ?>
            <?php foreach($menu['smenu'] as $menu2){ ?>
            <?php if(isset($menu2['hide'])&&$menu2['hide']==1)continue; ?>
                <?php $this->check_u_menu(array('code'=>'<li class="bccc"><span class=icspan></span><a href="'.$menu2['url'].'"  target="main">'.$menu2['title'].'</a></li>','auth_tag'=>$menu2['auth_tag'])); ?>
            <?php }?>
            </ul> 
		<?php }?>
        
    </div>

</div>

<?php require(dirname(__FILE__)."/../common/foot.php"); ?>