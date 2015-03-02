<?php include(dirname(__FILE__)."/head.php"); ?>
<?php $a=Cms::model()->cate_son(60);?>
<?php if(count($a)){?>
<div class="sj-nav width">
  <ul class="clearfix">
    <li><a href="/" class="on">首页</a></li>
    
    <?php foreach($a as $r){?>
    <li><a href="<?php echo $r['surl'];?>"><?php echo $r['cname'];?></a></li>
    <?php }?>
  </ul>
</div>
<?php }?>
<div class="dbox box-sha txtsha1">
	<div class="location">当前位置：
		<a href="/">首页</a><code> &gt; <?php echo $page['snav'];?>
	</div>
</div>


<div class="info_body">
	<h1 class="detailh1"><?php echo $page['info']['title'];?></h1>
	

	<div class="info-time"><?php echo date('Y-m-d H:i:s',$page['info']['create_time']);?></div>
	<?php echo Cms::model()->get_ad_code(140);?>
	<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a></div>
	<?php echo $page['info']['info_body'];?>
	<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a></div>
</div>



<div class="sj-cen15 width">
<?php include(dirname(__FILE__)."/foot.php"); ?>
</div>

<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
</body>
</html>
