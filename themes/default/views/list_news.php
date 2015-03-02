<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<?php include("common/global-bar.php");?>

<?php include("common/nav.php");?>
<script type="text/javascript">var www_host = 'http://www.water58.com';</script><div class="pro-m clrfix">
    <div class="pro-ml">
        <div class="w-box yahei">
            <h3 class="news-t">新闻资讯<i>NEWS</i></h3>
            
            <?php foreach($page['listdata']['list'] as $r){?>
                        <div class="news-list">
                <a href="<?php echo $r['url'];?>" class="news-a">
                    <img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" onerror="this.src='/static/default/images/nopic.jpg'"/>
                    <p class="p-t"><?php echo $r['title'];?></p>
                    <p class="p-c"></p>
                    <i class="data"><?php echo date('Y-m-d',$r['create_time']);?></i>
                </a>
            </div>
            <?php }?>
         	<?php echo $page['listdata']['pagearr']['pagecode'];?>       
         </div>
    </div>
    <div class="pro-mr">
        <a href="http://www.water58.com/corp/join.html" class="r-ad-img"><img src="http://www.water58.com/images/water58/join.jpg" alt="水网之家-新闻资讯"/></a>
        <div class="sh-bk mrt-10">
            <p class="st-p"><i></i>促销信息</p>
                    </div>
    </div>
</div>
<?php include("common/foot.php");?>
</body>
</html>