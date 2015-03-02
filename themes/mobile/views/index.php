<?php include(dirname(__FILE__)."/head.php"); ?>
<div class="sj-nav width">
  <ul class="clearfix">
    <li><a href="/" class="on">首页</a></li>
    <?php $i=0;foreach(Cms::model()->categorys as $r){$i++;?>
    <li><a href="<?php echo $r['surl'];?>"><?php echo $r['cname'];?></a></li>
    <?php }?>
  </ul>
</div>
<div class="clear"></div>

<?php echo Cms::model()->get_ad_code(138);?>

<?php $i=0;foreach(Cms::model()->categorys as $r){if($r['nav_show']==0)continue;$i++;if($i==11)break;?>
<div class="sj-cen2 width">
<h2><?php echo $r['cname'];?><a href="<?php echo $r['surl'];?>">更多</a></h2>
<?php $a=Cms::model()->info_list(array('cate_id'=>$r['cate_id'],'pagesize'=>5));?>
<?php foreach($a['list'] as $r2){?>
<div class="neirong2"><a href="<?php echo $r2['url'];?>" title="<?php echo $r2['title'];?>"><?php echo $r2['title'];?></a></div>
<?php }?>
</div> 
<?php }?>



<div class="sj-cen15 width">
<?php include(dirname(__FILE__)."/foot.php"); ?>
</div>
</body>
</html>
