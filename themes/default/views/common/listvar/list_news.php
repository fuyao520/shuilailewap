<?php 
/*{
"name":"普通新闻列表"
}*/
?>

<div class="listnews01">
    <ul>
<?php foreach($page['listdata']['list'] as $r){?>
        <li class="clearfix"><span><?php echo date('Y-m-d',$r['create_time']); ?></span><a href="<?php echo $r['url']; ?>"><?php echo $r['info_title']; ?></a></li>
<?php 	} ?>
    </ul>
</div>

<div class="clearfix">
<div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
</div>