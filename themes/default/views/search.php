<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Yii::app()->params['basic']['sitename']; ?></title>
<meta name="keywords" content="<?php echo Yii::app()->params['basic']['seo_keyword']; ?>"/>
<meta name="description" content="<?php echo Yii::app()->params['basic']['seo_description']; ?>"/>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/style.css">
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery.external.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/common.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?><?php echo Yii::app()->params['basic']['tpl']; ?>/js/common.js"></script>
</head>
<body>
<?php include(dirname(__FILE__)."/common/head.php"); ?>
<div class="width breadnav">
   当前位置： <a href="<?php echo Yii::app()->params['basic']['siteurl']; ?>">首页</a> » 搜索
</div>

<div class="width clearfix mt10">
    <div class="framebox01 l border01">
        <div class="sepagesebox">
        <form method="get" action="/index.php">
            <input type="hidden" name="m" value="search" />
            <input type="hidden" name="t" value="<?php echo $page['get']['t']; ?>"/>
            <input type="text" name="kw" id="kw" class="txtse" value="<?php echo $page['get']['kw']; ?>" />
			<input type="submit" class="btnse" value="立即搜索" name="">
		</form>
        <?php if(!$page['get']['kw']){ ?>
        <script>
          $("#kw").focus();
        </script>
        <?php }?>
        </div>
        <div class="searchtypebox mt10">
            <ul class="clearfix">
            <?php foreach(vars::$fields['search_type'] as $r){ ?>
                <li><a href="/index.php?m=search&t=<?php echo $r['value']; ?>&kw=<?php echo $page['get']['kw']; ?>" <?php if($r['value']==$page['get']['t']){echo 'class="current"'; } ?>><?php echo $r['txt']; ?></a></li>
            <?php }?>
            </ul>
        </div>
        <?php if(isset($page['infos']['list'][0])){ ?>
        <div class="searchstate_box mt10">
            <div class="condefaultpx">
            搜索 “<?php echo $page['get']['kw']; ?>” 共找到 <?php echo $page['infos']['total']; ?> 条相关结果
            </div>
        </div>
        
        <div class="listnew02 mt10">
            <ul>
            <?php foreach($page['infos']['list'] as $r){?>
                 <li class="clearfix">
                 <?php if($r['info_img']){ ?>
                 <a href="<?php echo $r['url']; ?>" class="listleftimg"><img src="<?php echo $r['info_img']; ?>" /></a>
                 <?php }?>
                 <span class="tit089"><a href="<?php echo $r['url']; ?>"><?php echo str_replace($page['get']['kw'],'<font color=red>'.$page['get']['kw'].'</font>',$r['info_title']); ?></a></span>
                 <div>发布时间：<?php echo date('Y-m-d H:i:s',$r['create_time']); ?></div>
                 <p><?php echo str_replace($page['get']['kw'],'<font color=red>'.$page['get']['kw'].'</font>',$r['info_desc']); ?></p>
                 </li>
            <?php 	} ?>
            </ul>
        </div>
        <div class="pagebar clearfix"><?php echo $page['infos']['pagecode']; ?></div>
        <?php }else{?>
            <div class="titsemsg">
               很抱歉，没有搜索到您想要搜索的，请尝试其他关键词
            </div>
        <?php }?>
    </div>
    
</div>

<div class="foot mt10">
<?php include(dirname(__FILE__).'/common/foot.php'); ?>
</div>


</body>
</html>