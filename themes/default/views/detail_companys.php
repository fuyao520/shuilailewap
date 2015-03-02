<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<div class="com-head">
    <div class="m-cd pr clrfix">
        <a class="logo-s" href="http://www.water58.com"></a>
        <div class="search">
            <input class="inp" type="text" placeholder="请输入小区名称或地址" id="k1" value="" code="" xy="" />
            <input class="inp" type="text" placeholder="请输入水的品牌" id="k2" value="" brdid="" />
            <input class="s-btn" type="button" id="btnSearch"/>
            <div id="suggest_wrapper" style="width:282px;display:none;"></div>
            <div id="brand_wrapper" class="pc_brank no-idx" style="width:392px;top:46px;margin-left:292px;display:none;">
                <ul class="word-l yahei">
                <?php foreach($brand_cates as $r){?>
                     <li class="aw" title="<?php echo $r['linkage_name'];?>" brdid="1" style="color:#000000"><?php echo $r['linkage_name'];?></li>
                <?php }?>
                 </ul>
            </div>
        </div>
    </div>
</div>
<?php include("common/nav.php");?>
<script type="text/javascript">var www_host = 'http://www.water58.com';</script><script type="text/javascript">$('#mn_service a').addClass('on');</script>
<div class="pro-m clrfix">
    <div class="pro-ml yahei">
        <div class="s-title">
            <div class="w-boxs s-mes">
                <div class="s-info">
                    <p class="t"><?php echo $page['company']['company_name'];?><span>关注度：<i class="follow-num">1004</i></span></p>
                </div>
                <div class="c-info mrt-15 pr">
                    <p><strong>经营品牌：</strong>
                	<?php $i=0;foreach($page['company']['business_product_data'] as $id){$i++;?>
                		<?php echo Linkage::model()->get_name($id);?> <?php if($i!=count($page['company']['business_product_data'])) echo ',';?> 
                	<?php }?>
                    </p>
                    <p><strong>送水范围：</strong>
                    <?php $i=0;foreach($page['region_business_data'] as $r){$i++;?>
                  			<?php echo $r['name'];?> <?php if($i!=count($page['region_business_data'])) echo ',';?> 
                  			<?php }?>
                    </p>
                    <p><strong>地　　址：</strong><?php echo $page['company']['company_address'];?></p>
                </div>
            </div>
            <div class="s-img">
                <img src="<?php echo $page['company']['company_logo'];?>" alt="社区福景路3号" onerror="this.src='/static/default/images/nopic.jpg'">
            </div>
            <div class="clr"></div>
        </div>
                <div class="w-box mrt-15 cxpp">
            <p class="st-p pr"><i></i>畅销产品 <a class="see-all" href="<?php echo Cms::model()->categorys[117]['surl'];?>">[查看全部品牌]</a></p>
            <div class="cxpp-lts clrfix mrt-15">
            
            		<?php foreach($page['listdata']['list'] as $r){?>
                                    <div class="cxpp-lt">
                        <p class="img-p buyW">
                            <a class="ia" href="<?php echo $r['url'];?>"><img src="<?php echo $r['thumb'];?>" alt="景田桶装纯净水" onerror="this.src='/static/default/images/nopic.jpg'"></a>
                            <a href="<?php echo $r['url'];?>" class="now-buy"><i class="ico"></i></a>
                        </p>
                        <p class="price-p"> <span class="now">￥<?php echo $r['now_price'];?></span><em>包配送</em><del>原价<?php echo $r['market_price'];?></del></p>
                        <p class="pro-name"><?php echo $r['info_title'];?></p>
                    </div>
                    <?php }?>
                            </div>
                            
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
            <p class="st-p"><i></i>同区域其它服务点</p>
            <div class="t-list">
                                    <div class="t-lt"> <a href="info-568.html"><i>&gt;</i> 福华社区岗厦东二坊站</a></div>
                                    <div class="t-lt"> <a href="info-589.html"><i>&gt;</i> 福田新村</a></div>
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
        $(function(){
            $("#up_marquee").marquee({ direction: "up", step: 1, pause: 2000 });
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