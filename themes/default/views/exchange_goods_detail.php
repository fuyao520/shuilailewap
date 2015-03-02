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
<script>
$.getJSON("<?php echo Yii::app()->params['basic']['siteurl']; ?>/post.php?m=add_info_visitors&info_id=<?php echo $page['info']['info_id']; ?>&cate_id=<?php echo $page['info']['last_cate_id']; ?>");
</script>
<body>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<div class="width breadnav">
<a href="/">首页</a> » 
<a href="<?php echo url::encode('exchange_list'); ?>">积分商城</a> » <a href="<?php echo $page['info']['exchange_url']; ?>"><?php echo $page['info']['info_title']; ?></a>
</div>

<div class="wrap width mt10 clearfix">
    <div class="wrap_content l">
  	    <?php if(count($page['info']['resource'])==0){$page['info']['resource'][0]['resource_url']=$page['info']['info_img'];$page['info']['resource'][0]['thumb']=$page['info']['info_img'];} ?>
        <div class="clearfix">
            <div class="l goods_photo_slide">
            <table width="100%" height="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="middle" align="center">
                       <?php foreach($page['info']['resource'] as $r){ ?>
                         <a  id="zoom1"  class="cloud-zoom"  href="<?php echo $r['resource_url']; ?>" rel="zoomWidth:400,zoomHeight:320, adjustY:0, adjustX:0"><img src="<?php echo $r['resource_url']; ?>" onload="resizeImage(this,300,400);" /></a>
                     <?php break;}?>  
                    </td>
                </tr>
                <tr>
                	<td>
                       <div class="goods_photo_small_box"> 
                        <table cellspacing="10" cellpadding="0">
                        	<tr>
                            <?php foreach($page['info']['resource'] as $r){ ?>
								<td valign="middle" align="center"><a href="<?php echo $r['resource_url']; ?>" class='cloud-zoom-gallery' rel="useZoom:'zoom1',smallImage:'<?php echo $r['resource_url']; ?>'"><img src="<?php echo $r['thumb']; ?>" onload="resizeImage(this,50,50)"/> 
                                <span style="display:inline-block;"></span>
                                </a>
                                </td>
							<?php }?>
                                
                            </tr>
                        </table>
                        </div>
                    </td>
                </tr>
            </table>
            
            
            </div>
            <div class="goods_photo_right_box l">
            	<h1 class="goods_h1"><?php echo $page['info']['info_title']; ?></h1>
                <div class="goods_sn">货号：<?php echo $page['info']['goods_sn']; ?></div>
                <div class="goods_visisalebox">
                    有 <?php echo get_goods_evaluate_total($page['info']['info_id']); ?> 条评价， 浏览 <?php echo $page['info']['info_visitors']; ?> 次
                </div>
                <div class="goods_total">共售出 <?php echo $page['info']['sales']; ?> 份  （剩余 <?php echo $page['info']['goods_total']; ?> 份）  </div>
                <div class="goods_now_price">原价：<span class="goods_now_price_num"><?php echo $page['info']['now_price']; ?></span></div>
                <div class="goods_now_price">所需积分：<span><?php echo $page['info']['exchange_point']; ?></span></div>
                <div class="goods_shop_bar_box">   
                    <div><a  href="/get_order.php?type=exchange_goods&goods_id=<?php echo $page['info']['info_id']; ?>" class="btnB" >立即兑换</a>
                    </div>
            	</div>
            </div>
        </div>
        
        
        <div class="detailbody">        
        	<?php echo $page['info']['info_body']; ?>
        </div>
       
        <div class="evaluate_box mt10">
			<?php include(dirname(__FILE__)."/common/evaluate.php"); ?>  
        </div>
        
    </div>
</div>

<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>

</body>
</html>