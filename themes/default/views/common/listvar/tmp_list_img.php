<?php 
/*{
"name":"图片列表"
}*/
?>
<?php foreach($page['listdata']['list'] as $r){?>
<a href="<?php echo $r['url']; ?>"><img src="<?php echo $r['info_img']; ?>" width=80 height="80"> <p><?php echo $r['info_title']; ?></p></a><br>
<?php 	} ?>
<div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>