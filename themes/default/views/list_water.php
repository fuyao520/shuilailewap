<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<?php include("common/global-bar.php");?>

<?php include("common/nav.php");?>
<script type="text/javascript">var www_host = 'http://www.water58.com';</script><script type="text/javascript">$('#mn_product a').addClass('on');</script>
<div class="pro-m clrfix">
    <div class="pro-ml">
        <div class="section">
            <div class="sec-bk">
                <span class="sec-t">配送地区：</span>
                <p class="sec-p">
                <a href="<?php echo g_s_url('area')?>">不限</a>
                <?php $a=Linkage::model()->get_linkage_data(1,0,$this->now_city['linkage_id']);?>
                <?php foreach($a as $r){?>
                                       <a <?php if(isset($page['areaId'])&&$page['areaId']==$r['linkage_id'])echo 'class="current"';?> href="<?php echo g_s_url('area',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a> 
                                     <?php }?>
                                    </p>
                 <?php if(isset($page['areaId'])){?>                   
                <p class="sec-p sec-childred"><strong>街道：</strong>
                	<a href="<?php echo g_s_url('area',$page['areaId'])?>">全部</a>
                	<?php $a=Linkage::model()->get_linkage_data(1,5,$page['areaId']);?>
                	<?php foreach($a as $r){?>
                                       <a <?php if(isset($page['streetId'])&&$page['streetId']==$r['linkage_id'])echo 'class="current"';?> href="<?php echo g_s_url('area',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a> 
                                     <?php }?>	               
                
                </p>
                <?php }?>
                <?php if(isset($page['streetId'])){?>
                <p class="sec-p sec-childred mrt-10"><strong>社区：</strong>
                <a href="<?php echo g_s_url('area',$page['streetId'])?>">全部</a>
                <?php $a=Linkage::model()->get_linkage_data(1,6,$page['streetId']);?>
                	<?php foreach($a as $r){?>
                                       <a <?php if(isset($page['communityId'])&&$page['communityId']==$r['linkage_id'])echo 'class="current"';?> href="<?php echo g_s_url('area',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a> 
                                     <?php }?>
                </p>                   
                <?php }?> 
                                            </div>
                                    
                                            
            <div class="sec-bk">
                <span class="sec-t">规　　格：</span>
                <p class="sec-p">
                                            <a href="<?php echo g_s_url('guige')?>">不限</a>
                                            <a href="<?php echo g_s_url('guige',1)?>" >桶装水</a>
                                            <a href="<?php echo g_s_url('guige',2)?>" >支装水</a>
                                    </p>
            </div>
            <div class="sec-bk s-brank">
                <span class="sec-t" style="*left:8px;">品　　牌：</span>
                <p class="sec-p">
                                            <a href="<?php echo g_s_url('brand')?>">不限</a>
                                            <?php foreach($brand_cates as $r){?>
                                            <a href="<?php echo g_s_url('brand',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a>
                                            <?php }?>
                                    </p>
                <a href="javascript:;" s="h" class="sec-more">更多<b class="fa fa-angle-down"></b> </a>
            </div>
        </div>
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