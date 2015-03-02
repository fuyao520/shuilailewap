<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Yii::app()->params['basic']['sitename']; ?></title>
<link href="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/clud_zoom/clud_zoom.css" />
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/js/common.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.external.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/clud_zoom/cloud_zoom.1.0.2.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/artDialog4.1.7/artDialog.js?skin=idialog"></script>
</head>
<body>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<div class="width breadnav">
<a href="/">首页</a> » 
积分商城
</div>

<div class="wrap width mt10 clearfix">
    <div class="wrap_content r">        
        <div class="goods_list_box clearfix">
            <?php $a=get_exchange_goods_list(array('pagesize'=>10,'p'=>$page['get']['p'])); ?>
			<?php foreach($a['list'] as $r){?>
            <div class="goods_list_block">
                <p class="pttxt01"><a href="<?php echo $r['url']; ?>"><img src="<?php echo $r['info_img']; ?>" alt="<?php echo $r['title']; ?>" class="goodimg" /></a></P>
                <p class="pttxt02"><a href="<?php echo $r['url']; ?>" title="<?php echo $r['title']; ?>"><?php echo $r['title']; ?></a></p>
                <p class="pttxt03">原价：￥<?php echo $r['now_price']; ?>元</p>
                <p class="pttxt03"><?php echo $r['exchange_point']; ?>积分</p>
                <p class="pttxt05">
                    <a href="<?php echo $r['url']; ?>" >我要兑换</a>
                </p>
            </div>
            <?php }?>
        </div>
        
        <div class="clear"></div>
        <div class="pagebar clearfix"><?php echo $a['pagecode']; ?></div>
    </div>
</div>

<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>

</body>
</html>