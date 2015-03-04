<?php include_once(dirname(__FILE__).'/common/head.php');?>
</head>

<body>

<div id="page">
    <header id="header" >
        <div class="header_l"> <a class="ico_02" href="#menu"> 菜单栏 </a> </div>
        <h1> ECSHOP模板堂 </h1>
        <div class="header_r"> <a class="ico_01" href="/index.php?m=default&c=flow&a=cart"> 购物车 </a> </div>
    </header>
</div>


<div id="focus" class="focus region">
    <div class="hd">
        <ul>
        </ul>
    </div>
    <div class="bd">
        <ul>
            <li><a href='/index.php?m=default&c=affiche&a=index&ad_id=1&uri='
                   target='_blank'><img src='http://ectouch.cn/data/assets/images/ectouch_ad1.jpg' width='360' height='168'
                                        border='0' /></a></li>
            <li><a href='/index.php?m=default&c=affiche&a=index&ad_id=2&uri='
                   target='_blank'><img src='http://ectouch.cn/data/assets/images/ectouch_ad2.jpg' width='360' height='168'
                                        border='0' /></a></li>
        </ul>    </div>
</div>
<div class="blank2"> </div>
<script type="text/javascript">
    TouchSlide({
        slideCell:"#focus",
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell:".bd ul",
        effect:"leftLoop",
        autoPlay:true,//自动播放
        autoPage:true //自动分页
    });
</script>




<div id=content class="wrap">

<header class=region>
    <div class=content>
        <div id=fake-search>
            <div class="fakeInput box1 radius15">
                <button class="text" id="get_search_box" style="color:silver;">搜本站商品</button>
                <div class="search ico_03"> </div>
            </div>
        </div>
    </div>
</header>

<div class="region row row_category">
    <ul class="flex flex-f-row">

        <li class="flex_in"> <a href="index.php?c=category&amp;a=all" title="全部分类"> <img src="/static/wap/images/02df0da6aa93ee7f699b841889436f59.png" /> </a>
            <p> 全部分类 </p>
        </li>
        <li class="flex_in"> <a href="index.php?m=default&amp;c=article&amp;a=art_list" title="帮助中心"> <img src="/static/wap/images/e690d2f750c99d2bdfaedecab03257a6.png" /> </a>
            <p> 帮助中心 </p>
        </li>
        <li class="flex_in"> <a href="index.php?m=default&amp;c=user&amp;a=index" title="个人中心"> <img src="/static/wap/images/718c978e55d5df62cdce00bb5d004efe.png" /> </a>
            <p> 个人中心 </p>
        </li>
        <li class="flex_in"> <a href="index.php?m=default&amp;c=ectouch&amp;a=share" title="分享"> <img src="/static/wap/images/cc22237e30f4bb85b14f1e390b082cee.png" /> </a>
            <p> 分享 </p>
        </li>
    </ul><ul class="flex flex-f-row">
        <li class="flex_in"> <a href="index.php?m=default&amp;c=ectouch&amp;a=contact" title="联系我们"> <img src="/static/wap/images/5008c3c35f8c23efda762be38b16332d.png" /> </a>
            <p> 联系我们 </p>
        </li>
        <li class="flex_in"> <a href="http://bbs.ecmoban.com/forum.php?mod=forumdisplay&amp;fid=36" title="论坛"> <img src="/static/wap/images/e90072633f5b080c0857e8d51bb557fb.png" /> </a>
            <p> 论坛 </p>
        </li>
        <li class="flex_in"> <a href="http://download.ecmoban.com/app/ecmoban.apk" title="客户端"> <img src="/static/wap/images/58dfce991fb57f4843a56f33427b6761.png" /> </a>
            <p> 客户端 </p>
        </li>
        <li class="flex_in"> <a href="http://www.ecmoban.com/?pc" title="电脑板"> <img src="/static/wap/images/02eda173b8093d0c8066b4ff8ba43a30.png" /> </a>
            <p> 电脑板 </p>
        </li>
    </ul>
</div>


<style type="text/css">
    .picScroll3{margin:10px auto; text-align:center;}
    .picScroll3 .bd ul{width:100%;  float:left; padding-top:10px;}
    .picScroll3 .bd li{width:33%; float:left; font-size:14px; text-align:center;}
    .picScroll3 .bd li a{-webkit-tap-highlight-color:rgba(0, 0, 0, 0); /* 取消链接高亮 */}
    .picScroll3 .bd li img{width:100px; height:100px;}
    .picScroll3 .hd{display:None}
</style>
<div class="blank2"></div>
<div class="item_show_box2 box1 region" style="overflow:hidden">

    <div class="flex flex-f-row">
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=408">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/408_thumb_G_1412040867989.png" alt="大京东——最佳行业解决方案 最新升级版2.0" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥98000元 </span>
                <br>大京东——最佳行业解决方...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=479">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/479_thumb_G_1412040907515.png" alt="ECSHOP商创版-首款企业级多用户商城系统_ECSC" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥23000元 </span>
                <br>ECSHOP商创版-首款...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=497">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/497_thumb_G_1412041095843.png" alt="ECSHOP模板堂新京东2014全网最强旗舰版+团购" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥5500元 </span>
                <br>ECSHOP模板堂新京东...            </div>
        </div>
    </div><div class="flex flex-f-row">                <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=500">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/500_thumb_G_1412041119545.png" alt="ECSHOP模板堂天猫商城升级旗舰版+团购" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥6800元 </span>
                <br>ECSHOP模板堂天猫商...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=467">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/467_thumb_G_1412041073289.png" alt="ECSHOP模板堂唯品会2014全网首发+团购(品牌特卖)" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥6800元 </span>
                <br>ECSHOP模板堂唯品会...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=510">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/510_thumb_G_1413396146885.png" alt="ECSHOP模板堂21Cake全网首发模板" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥3800元 </span>
                <br>ECSHOP模板堂21C...            </div>
        </div>
    </div><div class="flex flex-f-row">            </div>

    <div class="position_a_lt">
        <div> </div>
        <a href="/index.php?m=default&c=category&a=index&type=best">
            <p> 精品 </p>
            <p class="ico_04"> </p>
        </a> </div>
    <div class="position_a_rb">
        <div> </div>
        <a href="/index.php?m=default&c=category&a=index&type=best">
            <p class="ico_04_b"> </p>
            <p> 更多 </p>
        </a> </div>
</div>

<script type="text/javascript">
    TouchSlide({
        slideCell:"#picScroll3",
        titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        autoPage:true, //自动分页
        pnLoop:"false", // 前后按钮不循环
        //switchLoad:"_src" //切换加载，真实图片路径为"_src"
    });
</script>


<div class="blank2"></div>
<section class="item_show_box1 box1 region">
    <header>
        <span>
            ECSHOP模板        </span>
        <a href="/index.php?m=default&c=Category&a=index&id=9" class="ico_04 more">
        </a>
    </header>
    <div class="flex flex-f-row">
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=408">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/408_thumb_G_1412040867989.png" alt="大京东——最佳行业解决方案 最新升级版2.0" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥98000元 </span>
                <br>大京东——最佳行业解决方...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=479">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/479_thumb_G_1412040907515.png" alt="ECSHOP商创版-首款企业级多用户商城系统_ECSC" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥23000元 </span>
                <br>ECSHOP商创版-首款...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=497">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/497_thumb_G_1412041095843.png" alt="ECSHOP模板堂新京东2014全网最强旗舰版+团购" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥5500元 </span>
                <br>ECSHOP模板堂新京东...            </div>
        </div>
    </div><div class="flex flex-f-row">                <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=500">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/500_thumb_G_1412041119545.png" alt="ECSHOP模板堂天猫商城升级旗舰版+团购" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥6800元 </span>
                <br>ECSHOP模板堂天猫商...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=546">
                <img src="http://upfile.ecmoban.com/images/201411/thumb_img/546_thumb_G_1416246038733.png" alt="ECSHOP模板堂美丽说最新模板 瀑布流+团购" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥6000元 </span>
                <br>ECSHOP模板堂美丽说...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=467">
                <img src="http://upfile.ecmoban.com/images/201409/thumb_img/467_thumb_G_1412041073289.png" alt="ECSHOP模板堂唯品会2014全网首发+团购(品牌特卖)" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥6800元 </span>
                <br>ECSHOP模板堂唯品会...            </div>
        </div>
    </div><div class="flex flex-f-row">            </div>
    <div class="item_tags clearfix">
    </div>
</section>


<div class="blank2"></div>
<section class="item_show_box1 box1 region">
    <header>
        <span>
            收费插件        </span>
        <a href="/index.php?m=default&c=Category&a=index&id=24" class="ico_04 more">
        </a>
    </header>
    <div class="flex flex-f-row">
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=322">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/322_thumb_G_1413324940404.png" alt="ECSHOP模板堂礼品卡-提货插件" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥2500元 </span>
                <br>ECSHOP模板堂礼品卡...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=428">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/428_thumb_G_1413329869825.png" alt="ECSHOP模板堂仿京东商品对比插件" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥1800元 </span>
                <br>ECSHOP模板堂仿京东...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=372">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/372_thumb_G_1413327379561.png" alt="ECSHOP模板堂商品多城市多仓库插件震撼上市" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥3500元 </span>
                <br>ECSHOP模板堂商品多...            </div>
        </div>
    </div><div class="flex flex-f-row">                <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=326">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/326_thumb_G_1413324986316.png" alt="ECSHOP模板堂价格分隔符插件" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥600元 </span>
                <br>ECSHOP模板堂价格分...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=321">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/321_thumb_G_1413324874089.png" alt="ECSHOP模板堂指定送货时间插件" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥1000元 </span>
                <br>ECSHOP模板堂指定送...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=317">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/317_thumb_G_1413324858035.png" alt="ECSHOP模板堂注册送红包插件" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥800元 </span>
                <br>ECSHOP模板堂注册送...            </div>
        </div>
    </div><div class="flex flex-f-row">            </div>
    <div class="item_tags clearfix">
    </div>
</section>


<div class="blank2"></div>
<section class="item_show_box1 box1 region">
    <header>
        <span>
            ecshop手机端        </span>
        <a href="/index.php?m=default&c=Category&a=index&id=34" class="ico_04 more">
        </a>
    </header>
    <div class="flex flex-f-row">
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=588">
                <img src="http://upfile.ecmoban.com/images/201502/thumb_img/588_thumb_G_1422900171207.png" alt="O2O Mobile手机APP系统（含授权+源码）" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥7999元 </span>
                <br>O2O Mobile手机...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=381">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/381_thumb_G_1413246186871.png" alt="ECmobile V3.0商业授权（ecshop原生APP）" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥4999元 </span>
                <br>ECmobile V3....            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=517">
                <img src="http://upfile.ecmoban.com/images/201410/thumb_img/517_thumb_G_1413253605675.png" alt="ECTouch商业授权——买授权即得微商城" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥5000元 </span>
                <br>ECTouch商业授权—...            </div>
        </div>
    </div><div class="flex flex-f-row">                <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=579">
                <img src="http://upfile.ecmoban.com/images/201501/thumb_img/579_thumb_G_1421188111480.png" alt="ECSHOP模板堂ECJia iPhone" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥10000元 </span>
                <br>ECSHOP模板堂ECJ...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=549">
                <img src="http://upfile.ecmoban.com/images/201411/thumb_img/549_thumb_G_1415227688553.png" alt="模板堂paypal手机支付插件（PC手机均支持）" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥100元 </span>
                <br>模板堂paypal手机支...            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=544">
                <img src="http://upfile.ecmoban.com/images/201501/thumb_img/544_thumb_G_1421192842040.png" alt="模板堂ECJia APP Android端" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥10000元 </span>
                <br>模板堂ECJia APP...            </div>
        </div>
    </div><div class="flex flex-f-row">            </div>
    <div class="item_tags clearfix">
    </div>
</section>


<div class="blank2"></div>
<section class="item_show_box1 box1 region">
    <header>
        <span>
            空间域名        </span>
        <a href="/index.php?m=default&c=Category&a=index&id=33" class="ico_04 more">
        </a>
    </header>
    <div class="flex flex-f-row">
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=595">
                <img src="http://upfile.ecmoban.com/images/201502/thumb_img/595_thumb_G_1423016759362.png" alt="万网轻云服务器" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥550元 </span>
                <br>万网轻云服务器            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=594">
                <img src="http://upfile.ecmoban.com/images/201502/thumb_img/594_thumb_G_1423016018184.png" alt="阿里云服务器-香港B型" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥6530元 </span>
                <br>阿里云服务器-香港B型            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=593">
                <img src="http://upfile.ecmoban.com/images/201502/thumb_img/593_thumb_G_1423015975681.png" alt="阿里云服务器-香港A型" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥2740元 </span>
                <br>阿里云服务器-香港A型            </div>
        </div>
    </div><div class="flex flex-f-row">                <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=592">
                <img src="http://upfile.ecmoban.com/images/201502/thumb_img/592_thumb_G_1423015811736.png" alt="阿里云服务器-豪华B型" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥5750元 </span>
                <br>阿里云服务器-豪华B型            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=591">
                <img src="http://upfile.ecmoban.com/images/201502/thumb_img/591_thumb_G_1423015564956.png" alt="阿里云服务器-标准A型" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥2740元 </span>
                <br>阿里云服务器-标准A型            </div>
        </div>
        <div class="goodsItem flex_in">
            <a href="/index.php?m=default&c=goods&a=index&id=590">
                <img src="http://upfile.ecmoban.com/images/201502/thumb_img/590_thumb_G_1423013831735.png" alt="万网云虚拟主机服务器" />
            </a>
            <div style="text-align:center">

                <span class="price_s"> ￥288元 </span>
                <br>万网云虚拟主机服务器            </div>
        </div>
    </div><div class="flex flex-f-row">            </div>
    <div class="item_tags clearfix">
    </div>
</section>



</div>

<div id="content" class="footer mr-t20">
    <div class="in">
        <div class="search_box">
            <form method="post" action="/index.php?m=default&c=category&a=index" name="searchForm" id="searchForm_id">
                <input name="keywords" type="text" id="keywordfoot" />
                <button class="ico_07" type="submit" value="搜索" onclick="return check('keywordfoot')"> </button>
            </form>
        </div>
        <a href="./" class="homeBtn"> <span class="ico_05"> </span> </a> <a href="#top" class="gotop"> <span class="ico_06"> </span> <p> TOP </p>
        </a>
    </div>
    <p class="link region"> <a href="http://itunes.apple.com/cn/app/ecshop-mo-ban-tang/id773051406?ls=1&mt=8"> 苹果客户端 </a> <a class="http://download.ecmoban.com/app/ecmoban.apk"> Android客户端 </a> <a href="http://www.ecmoban.com/?pc"> 电脑版 </a> </p>
    <p class="region">

        &copy; 2005-2015 ECSHOP模板堂 版权所有，并保留所有权利。 </p>
    <div class="favLink region"> <a href="http://www.ecmoban.com"> powered by ecmoban </a> </div>
</div>


<link href="<?php echo Yii::app()->params['basic']['cssurl'];?>wap/style/global_nav.css?v=20140408" type="text/css" rel="stylesheet"/>

<div class="global-nav">
    <div class="global-nav__nav-wrap">
        <div class="global-nav__nav-item">
            <a href="./" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-index">&#xf0001;</i>
                <span class="global-nav__nav-tit">首页</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="/index.php?m=default&c=category&a=all" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-category">&#xf0002;</i>
                <span class="global-nav__nav-tit">分类</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="javascript:get_search_box();" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-search">&#xf0003;</i>
                <span class="global-nav__nav-tit">搜索</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="/index.php?m=default&c=flow&a=cart" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-shop-cart">&#xf0004;</i>
                <span class="global-nav__nav-tit">购物车</span>
                <span class="global-nav__nav-shop-cart-num" id="carId">0</span>
            </a>
        </div>
        <div class="global-nav__nav-item">
            <a href="/index.php?m=default&c=user&a=index" class="global-nav__nav-link">
                <i class="global-nav__iconfont global-nav__icon-my-yhd">&#xf0005;</i>
                <span class="global-nav__nav-tit">用户中心</span>
            </a>
        </div>
    </div>
    <div class="global-nav__operate-wrap">
        <span class="global-nav__yhd-logo"></span>
        <span class="global-nav__operate-cart-num" id="globalId">0</span>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl'];?>wap/js/zepto.min.js?v=20140408"></script>
<script type="text/javascript">
    Zepto(function($){
        var $nav = $('.global-nav'), $btnLogo = $('.global-nav__operate-wrap');
        //点击箭头，显示隐藏导航
        $btnLogo.on('click',function(){
            if($btnLogo.parent().hasClass('global-nav--current')){
                navHide();
            }else{
                navShow();
            }
        });

        var navShow = function(){
            $nav.addClass('global-nav--current');
        }

        var navHide = function(){
            $nav.removeClass('global-nav--current');
        }

        $(window).on("scroll", function() {
            if($nav.hasClass('global-nav--current')){
                navHide();
            }
        });
    })
    function get_search_box(){
        try{
            document.getElementById('get_search_box').click();
        }catch(err){
            document.getElementById('keywordfoot').focus();
        }
    }
</script>

<div id="main-search" class="main-search">
    <div class="hd"> <span class="ico_08 close"> 关闭 </span> </div>
    <div class="bd">
        <div class="search_box">
            <form action="/index.php?m=default&c=category&a=index" method="post" id="searchForm" name="searchForm">
                <div class="content">
                    <input class="text" type="search" name="keywords" id="keywordBox" autofocus />
                    <button class="ico_07" type="submit" value="搜 索" onclick="return check('keywordBox')"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function(){
        $('#menu').css('display','');
    }
    $(function() {
        $('nav#menu').mmenu();
        $('#get_search_box').click(function(){
            $(".mm-page").children('div').hide();
            $("#main-search").css('position','fixed').css('top','0px').css('width','100%').css('z-index','999').show();
            //$('#keywordBox').focus();
        })
        $("#main-search .close").click(function(){
            $(".mm-page").children('div').show();
            $("#main-search").hide();
        })
    });
</script>
</body>
</html>