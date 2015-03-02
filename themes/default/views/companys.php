<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<?php include("common/global-bar.php");?>

<?php include("common/nav.php");?>
<script type="text/javascript">var www_host = 'http://www.water58.com';</script><script type="text/javascript">$('#mn_service a').addClass('on');</script>
<div class="pro-m clrfix">
    <div class="pro-ml">
        <div class="section">
            <div class="sec-bk">
                <span class="sec-t">配送地区：</span>
                <p class="sec-p">
                <a href="<?php echo c_s_url('area')?>">不限</a>
                <?php $a=Linkage::model()->get_linkage_data(1,0,$this->now_city['linkage_id']);?>
                <?php foreach($a as $r){?>
                                       <a <?php if(isset($page['areaId'])&&$page['areaId']==$r['linkage_id'])echo 'class="current"';?> href="<?php echo c_s_url('area',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a> 
                                     <?php }?>
                                    </p>
                 <?php if(isset($page['areaId'])){?>                   
                <p class="sec-p sec-childred"><strong>街道：</strong>
                	<a href="<?php echo c_s_url('area',$page['areaId'])?>">全部</a>
                	<?php $a=Linkage::model()->get_linkage_data(1,5,$page['areaId']);?>
                	<?php foreach($a as $r){?>
                                       <a <?php if(isset($page['streetId'])&&$page['streetId']==$r['linkage_id'])echo 'class="current"';?> href="<?php echo c_s_url('area',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a> 
                                     <?php }?>	               
                
                </p>
                <?php }?>
                <?php if(isset($page['streetId'])){?>
                <p class="sec-p sec-childred mrt-10"><strong>社区：</strong>
                <a href="<?php echo c_s_url('area',$page['streetId'])?>">全部</a>
                <?php $a=Linkage::model()->get_linkage_data(1,6,$page['streetId']);?>
                	<?php foreach($a as $r){?>
                                       <a <?php if(isset($page['communityId'])&&$page['communityId']==$r['linkage_id'])echo 'class="current"';?> href="<?php echo c_s_url('area',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a> 
                                     <?php }?>
                </p>                   
                <?php }?> 
                                            </div>
       
            <div class="sec-bk s-brank">
                <span class="sec-t" style="*left:8px;">品　　牌：</span>
                <p class="sec-p">
                                            <a href="<?php echo c_s_url('brand')?>">不限</a>
                                            <?php foreach($brand_cates as $r){?>
                                            <a href="<?php echo c_s_url('brand',$r['linkage_id'])?>"><?php echo $r['linkage_name'];?></a>
                                            <?php }?>
                                    </p>
                <a href="javascript:;" s="h" class="sec-more">更多<b class="fa fa-angle-down"></b> </a>
            </div>
        </div>
                <div class="s-wp mrt-15">
            <div class="s-tt">
                <span class="fr">共有 <strong style="color:#bc1913;"><?php echo $page['listdata']['total'];?></strong> 家服务点</span>
            </div>
            <div class="clr"></div>
            
              <?php foreach($page['listdata']['list'] as $r){?>
                            <div class="s-bk clrfix">
                    <a class="s-fc" href="/companys/detail?id=<?php echo $r['company_id']; ?>">
                        <img src="<?php echo $r['company_logo']?>" alt="福华社区华强南站" onerror="this.src='/static/default/images/nopic.jpg'"/>
                    </a>
                    <div class="s-o">
                        <div class="s-do">
                            <a href="/companys/detail?id=<?php echo $r['company_id']; ?>" class="tle-p"><?php echo $r['company_name'];?></a>
                            <p><strong>经营品牌：</strong>
                            <?php $business_data=json_decode($r['business_products'],1);?>
                            <?php if(is_array($business_data)){foreach($business_data as $r2){?>
                            <?php echo $brand_cates[$r2]['linkage_name'];?>
                            <?php }}?>
                            </p>
                            <p><strong>送水范围：</strong>
                            <?php $region_business_data=CompanyRegionBusiness::model()->get_regions($r['company_id'],1);?>
                            <?php $i=0;foreach($region_business_data as $r2){$i++;?>
                  			<?php echo $r2['name'];?> <?php if($i!=count($region_business_data)) echo ',';?> 
                  			<?php }?>
                            </p>
                            <p><strong>地　　址：</strong><?php echo $r['company_address'];?></p>
                        </div>
                    </div>
                    <div class="s-r">
                        <p>好评度：<b class="ico star b-s5"></b></p>
                        <p>关注度：<strong class="follow-num">994</strong></p>
                        <p>评论：<strong class="discuss-num">-</strong></p>
                    </div>
                </div>
                <?php }?>
                          
                        
                        
                 	<div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode'];?></div>       
                  </div>
            </div>
    <div class="pro-mr">
        <div class="sh-bk">
            <p class="st-p"><i></i>促销信息</p>
            <div class="t-list">
                            </div>
        </div>
                    <div class="sh-bk mrt-15">
                <p class="st-p"><i></i>热卖水</p>
                <div class="i-list">
                <?php $a=Cms::model()->info_list(array('cate_id'=>117,'pagesize'=>4,'andwhere'=>"and l.flag_c=1"));?>
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
        if($(".s-brank").find("p").height() > 120){
            $(".s-brank").addClass("sec-brank");
        };
        $(".sec-more").click(function(){
            var s =$(this).attr("s");
            var oH = $(".s-brank").find("p").height();
            if(s == "h"){
                $(this).attr("s","s").html('收起<b class="fa fa-angle-up"></b>');
                $(".s-brank").stop().animate({height:oH});
            }else{
                $(this).attr("s","h").html('更多<b class="fa fa-angle-down"></b>');
                $(".s-brank").stop().animate({height:"120px"});
            }
        });
    </script>
<?php include("common/foot.php");?>

<script type="text/javascript">
    $(function(){
        var oF;
        var w = $(window).width();
        var h = $(window).outerHeight(true);
        $(".buyW").hover(
            function(){
                var oT = $(this);
                oF = setTimeout(function(){oT.find(".now-buy").stop().animate({height:"40px"},300);},500);
            },
            function(){$(this).find(".now-buy").stop().animate({height:"0"},300);clearTimeout(oF); }
        );
        $(window).scroll(function(){
            var sTop = $(window).scrollTop();
            if(!window.XMLHttpRequest){
                $(".fwm").css({"top":$(window).scrollTop()+$(window).height()-180});
            }
        });
        $(".fwm").css("top",$(window).height()-180).hover(
            function(){$(".pwm").show();},
            function(){$(".pwm").hide();}
        );
    });
</script>
</body>
</html>