<?php 
/*{
"name":"默认显示图文列表"
}*/
?>

<div class="listnew02">
    <ul>
	<?php $i=0;foreach($page['listdata']['list'] as $r){$i++;?>
         <li class="clearfix<?php echo $i%2?'':' jianbg'; ?>">
         <?php if($r['info_img']){ ?>
         <a href="<?php echo $r['url']; ?>" class="listleftimg"><img src="<?php echo $r['info_img']; ?>" /></a>
         <?php }?>
         <span class="tit090"><a href="<?php echo $r['url']; ?>"><?php echo $r['info_title']; ?></a></span>
         <span class="tit089"><i>发布时间：<?php echo date('Y-m-d',$r['create_time']); ?></i></span>
		 
         <p><?php echo $r['info_desc']; ?></p>
         </li>
    <?php 	} ?>
    </ul>
	<div class="clear"></div>
</div>
<div class="pagebar clearfix"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>

