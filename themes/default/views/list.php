<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<div class="wrap width mt10 clearfix">
    <div class="wrap_sider fl">
        <div class="catetop"><h2><?php echo $page['relation_cate_top']['cname']; ?></h2></div>
        <ul class="catelist">
		<?php foreach($page['relation_cates'] as $r){ ?>
        	<li><a href="<?php echo $r['surl']; ?>"><?php echo $r['cname']; ?></a></li>
        <?php }?>
        </ul>
    </div>
    <div class="wrap_content fr">
    	<div class="breadnav">
        	<strong>当前位置：</strong> <a href="/">首页</a> » <?php echo $page['snav']; ?>
        </div>
        <div class="mybody">
        	<?php if($page['cate']['single']){?>
        		<?php include(dirname(__FILE__)."/common/listvar/list_content.php"); ?>
        	<?php }else{?>
				<?php include(dirname(__FILE__)."/common/listvar/".$page['cate']['csetting']['templates_list']); ?>
    		<?php }?>
    	</div>
    </div>
</div>

<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>

</body>
</html>