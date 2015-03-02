<?php $page['id']='home';?>
<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body style="overflow:hidden;">
<div class="m-d1 dwh" id="index">
    <img id="bgImg" s class="bg-img" src="/static/default/images/idx_top_bg_b.jpg?2" alt="水网之家" style="z-index:1;"/>
   

    <div class="m-cd">
        <a class="logo" href="http://www.water58.com"></a>
        <div class="search clrfix">
            <div class="fl pr">
                <input class="inp" type="text" placeholder="请输入小区名称或地址" id="k1" value="" code="" xy="" />
            </div>
            <div  class="fl pr brandD">
                <input class="inp brandInp" type="text" placeholder="请输入水的品牌" id="k2" value="" brdid="" />
            </div>
            <input class="s-btn" type="button" id="btnSearch"/>
            <div id="suggest_wrapper" class="wp-pop"></div>
            <div id="brand_wrapper" class="wp-pop pc_brank">
                <ul class="word-l yahei">
                <?php foreach($brand_cates as $r){?>
                                            <li class="aw" title="<?php echo $r['linkage_name'];?>" brdid="1" style="color:#000000"><?php echo $r['linkage_name'];?></li>
                             <?php }?>
                                    </ul>
            </div>
        </div>
    </div>
</div>
<div class="menu-wp">
    <?php include("common/nav.php");?>
</div>
<div class="fwm">
    <img class="iewm" src="/static/default/images/ewm.jpg" alt="水网之家"/>
    <p class="pwm yahei">扫一扫抢鲜体验手机订水</p>
</div>


<script type="text/javascript">
    $(function(){
       scr_resize();
       $(window).resize(scr_resize);
    })
    function scr_resize(){
        var w = $(window).width();
        var h = $(window).outerHeight(true);
        
        $('.bg-img').width(w).height(h-62);
        $('.dwh').width(w);
        $('.m-cd').css({
            'left':(w-760)/2,
            'top':(h-$('.m-cd').height())/2-80
        });
        $(".fwm").css("top",$(window).height()-220);
        if($(window).width()<1200){
            $("html").addClass("w1000");
        }else{
            $("html").removeClass("w1000");
        }
        if(!window.XMLHttpRequest){
            $(".brandInp").siblings("label").remove();
        }
    }
    
    
</script>
</body>
</html>
