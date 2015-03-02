<?php 
/*{
"name":"投票列表"
}*/
?>
<?php foreach($page['votedatas']['list'] as $r){?>
<a href="<?php echo $r['url']; ?>"><?php echo $r['subject']; ?></a> <span class="gray"><?php echo date('Y-m-d',$r['create_time']); ?></span><br>
<?php 	} ?>
<div class="pagebar"><?php echo $page['votedatas']['pagecode']; ?></div>

