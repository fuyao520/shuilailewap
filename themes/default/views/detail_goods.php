<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<?php include("common/global-bar.php");?>

<?php include("common/nav.php");?>
<script type="text/javascript">var www_host = 'http://www.water58.com';</script><script type="text/javascript">
    var mn_name = 'mn_product';
    $('#'+mn_name+' a').addClass('on');
</script>
<div class="pro-m clrfix">
    <div class="pro-ml yahei">
        <form id="form1" method="post" action="/order/cart.html?do=add" onsubmit="return post_submit(this);">
        <div class="w-box" id="product-intro">
            <div id="preview">
                <div id="spec-n1">
                    <img src="<?php echo $page['info']['info_img'];?>" alt="景田桶装纯净水" onerror="this.src='/static/default/images/nopic.jpg'"/>
                </div>
            </div>
            <div id="name" class="info-dl">
                <h1><?php echo $page['info']['title'];?></h1>
                <strong>"太空水"</strong> 
            </div>
            <div class="info-dl mrt-15">
                <ul id="summary">
                    <li class="clrfix">
                        <div class="dt">价　　格：</div>
                        <div class="dd"><strong class="p-price">￥<?php echo $page['info']['now_price'];?></strong>/<?php echo $page['info']['unit'];?>（<span class="col_red">不含桶价格</span>）</div>
                    </li>
                    <li class="clrfix">
                        <div class="dt">订货要求：</div>
                        <div class="dd">1桶起订</div>
                    </li>
                    <li class="clrfix">
                        <div class="dt">包装规格：</div>
                        <div class="dd"><?php echo $page['info']['packing'];?></div>
                    </li>
                    <li class="clrfix">
                        <div class="dt">配&nbsp;&nbsp;送&nbsp;至：</div>
                        <div class="dd">
                            <span id="span_area">
                                <select class="input select slt" disabled><option value="">广东省</option></select>
                                <select class="input select slt" disabled><option value="">深圳市</option></select>
                                
                                <span id="t_s_area"></span>
                <span id="t_s_area_load"></span> 
                   <script>cg_edit_sele_cc("0","area[]","t_s_area","1","112083",3);</script>
                            </span>
                        </div>
                    </li>
                    <li class="clrfix">
                        <div class="dt">购买数量：</div>
                        <div class="dd clrfix">
                            <div class="wrap-input clrfix">
                                <a class="ico numBtn btn-reduce" href="javascript: void(0);" onclick="decrease()"></a>
                                <a class="ico numBtn btn-add" href="javascript:void(0);" onclick="increase()"></a>
                                <input class="text" onkeyup="return buyNum(1,this);" maxlength="3" id="number008" name="num" required="required" value="1" />
                            </div>
                        </div>
                    </li>
                    <li>
                        <input type="hidden" name="type_id" id="type_id" value="0"/>
                        <button class="btn1 addcart fl r3" type="button" id="post_cart"  onclick="addcart(<?php echo $page['info']['info_id'];?>,$('#number008').val(),0,1);" ><i class="icon-plus"></i>加入购物车</button>
                        <button class="btn1 addbuy fl r3" type="button" id="post_buy" onclick="return go_get_order(this,'#number008','get_goods_attr')" class="btn_add_cart" href="<?php echo $this->createUrl('order/index');?>?type=immediately_buy&goods_id=<?php echo $page['info']['info_id'];?>&num=1" ><i class="icon-plus"></i>立即购买</button>
                    </li>
                </ul>
            </div>
            <div class="clr"></div>
        </div>
        </form>
        <div class="float-nav-wrap mrt-15" id="tabs">
            <ul class="tab">
                <li class="cur" title="details"><a href="javascript:;" onclick="tabs(this);">产品介绍</a></li>
                <li title="comment"><a href="javascript:;" onclick="tabs(this);">相关评论</a></li>
            </ul>
        </div>
        <div class="w-box">
            <ul class="detail-list">
                <li>商品名称：景田桶装纯净水</li>
                                <li>上架时间：<?php echo date('Y-m-d',$page['info']['create_time']);?> </li>
                                                                                                <li>商品产地：<?php echo Linkage::model()->get_name($page['info']['origin'],1)?></li>
                                                                                                                    <li>类别：<?php echo $page['cate']['cname'];?></li>
                                                </ul>
            <div class="deltail-content mrt-20">
                <?php echo $page['info']['info_body'];?>
                
            </div>
        </div>
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