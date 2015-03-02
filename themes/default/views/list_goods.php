<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<?php include("common/global-bar.php");?>

<?php include("common/nav.php");?>
<script type="text/javascript">var www_host = 'http://www.water58.com';</script><script type="text/javascript">$('#mn_product a').addClass('on');</script>
<div class="pro-m clrfix">
    <div class="pro-ml">
        
        <div class="clrfix"></div>
                <div class="pro-lt mrt-15" style="padding:20px 15px 60px 15px;">
            <ul class="xm-goods-list clrfix">
            <?php foreach($page['listdata']['list'] as $r){?>
                                    <li class="buyW">
                        <div class="xm-goods-item">
                            <div class="item-thumb">
                                <a href="<?php echo $r['url'];?>" target="_blank">
                                    <img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" onerror="this.src='/static/default/images/nopic.jpg'"/>
                                </a>
                            </div>
                            <div class="item-info">
                                <h3 class="item-title"><a href="<?php echo $r['url'];?>" target="_blank"><?php echo $r['title'];?></a></h3>
                                <div class="item-price">
                                    <?php echo $r['now_price'];?>元<span class="sep">|</span><del><?php echo $r['market_price'];?>元</del>
                                </div>
                                <p class="item-title">包配送</p>
                            </div>
                        </div>
                        <!-- <a href="javascript:;" onclick="addcart(<?php echo $r['info_id'];?>,1,0,1);"  class="now-buy"><i class="ico"></i></a> -->
                    </li>
                   <?php }?>    
                            </ul>
            </div>
            <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode'];?></div>
            </div>
    <div class="pro-mr">
        <div class="sh-bk">
            <p class="st-p"><i></i>热卖排行</p>
            <div class="i-list">
            <?php $a=Cms::model()->info_list(array('cate_id'=>117,'pagesize'=>7,'ordersql'=>"order by l.sales desc"));?>
                <?php foreach($a['list'] as $r){?>
                                            <div class="i-lt">
                            <a href="<?php echo $r['url'];?>" class="i-face" target="_blank"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" title="<?php echo $r['title'];?>" 
                            onerror="/static/default/images/nopic.jpg'"/> </a>
                            <a href="<?php echo $r['url'];?>" class="name-a" target="_blank"><?php echo $r['title'];?></a>
                            <p class="o-p"><i>零售价：</i><em class="r"><?php echo $r['now_price'];?></em>/</p>
                            <p class="o-p"><i>已销售：</i><?php echo $r['sales'];?></p>
                        </div>
                 <?php }?>
                            </div>
        </div>
                                <div class="sh-bk mrt-15">
                <p class="st-p"><i></i>店家推荐</p>
                <div class="i-list">
                <?php $a=Cms::model()->info_list(array('cate_id'=>117,'pagesize'=>5,'andwhere'=>"and l.flag_c=1"));?>
                <?php foreach($a['list'] as $r){?>
                                            <div class="i-lt">
                            <a href="<?php echo $r['url'];?>" class="i-face" target="_blank"><img src="<?php echo $r['thumb'];?>" alt="<?php echo $r['title'];?>" title="<?php echo $r['title'];?>" 
                            onerror="/static/default/images/nopic.jpg'"/> </a>
                            <a href="<?php echo $r['url'];?>" class="name-a" target="_blank"><?php echo $r['title'];?></a>
                            <p class="o-p"><i>零售价：</i><em class="r"><?php echo $r['now_price'];?></em>/</p>
                            <p class="o-p"><i>已销售：</i><?php echo $r['sales'];?></p>
                        </div>
                 <?php }?>
                                    </div>
            </div>
                        </div>
</div>

    <script type="text/javascript">
        $(function(){
            if($(".s-brank").find("p").height() > 120){
                $(".s-brank").addClass("sec-brank");
            };
            $(".sec-more").click(function(){
                var s =$(this).attr("s");
                var oH = $(".s-brank").find("p").height();
                if(s == "h"){
                    $(this).attr("s","s").html('收起<b class="fa fa-angle-up"></b>');
                    $(".s-brank").height(oH);
                }else{
                    $(this).attr("s","h").html('更多<b class="fa fa-angle-down"></b>');
                    $(".s-brank").height("120px");
                }
            });
        });
      
    </script>

<?php include("common/foot.php");?>
<script type="text/javascript">
</script>
</body>
</html>