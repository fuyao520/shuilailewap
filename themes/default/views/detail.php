<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<div class="width breadnav">
    <a href="/">首页</a> » 
    <?php echo $page['snav']; ?>
</div>

<div class="wrap width mt10 clearfix">
    <div class="wrap_sider fl">
        <div class="catetop"><?php echo $page['relation_cate_top']['cname']; ?></div>
        <ul class="catelist">
		<?php foreach($page['relation_cates'] as $r){ ?>
        	<li><a href="<?php echo $r['surl']; ?>"><?php echo $r['cname']; ?></a></li>
        <?php }?>
        </ul>
    </div>
    <div class="wrap_content fr">
		<h1 class="detailh1"><?php echo $page['info']['info_title']; ?></h1>
        <div class="detailattr">发布时间：<?php echo date('Y-m-d',$page['info']['create_time']); ?>  浏览量：<?php echo $page['info']['info_visitors']; ?></div>
        <div class="detailbody">
        <?php echo $page['info']['info_body']; ?>
        </div>
        <?php $page['comment']['fromid']=$page['cate']['model_table_name'].'-'.$page['info']['info_id']; ?>
        <?php include(dirname(__FILE__).'/common/comment.php'); ?>
    </div>
</div>

<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>

</body>
</html>