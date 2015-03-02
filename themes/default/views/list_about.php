<?php include("common/inc.php");?>
<?php include("common/head.php");?>
<body>
<div class="com-head">
    <div class="m-cd pr clrfix">
        <a class="logo-s" href="/"></a>
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
<script type="text/javascript">var www_host = 'http://www.water58.com';</script><script type="text/javascript">$('#mn_about a').addClass('on');</script>
<div class="pro-m clrfix">
    <div class="pro-ml">
        <div class="w-box yahei">
            <h3 class="news-t"><?php echo $page['cate']['cname'];?><i><?php echo $page['cate']['cname_en'];?></i></h3>
            <div class="contact-c  mrt-20">
            	
                <?php if($page['cate']['single']){?>
        			<?php foreach($page['listdata']['list'] as $r){?>
        			<?php echo $r['info_body'];break;?>
        			<?php }?>
	        	<?php }else{?>
					<?php include(dirname(__FILE__)."/common/listvar/".$page['cate']['csetting']['templates_list']); ?>
	    		<?php }?> 
            </div>
        </div>
    </div>
    <div class="pro-mr">
        <a href="http://www.water58.com/corp/join.html" class="r-ad-img"><img src="http://www.water58.com/images/water58/join.jpg" alt="水网之家-联系我们"/></a>
        <div class="sh-bk mrt-10">
            <p class="st-p"><i></i>促销信息</p>
                    </div>
    </div>
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2&ak=ivBiSr5m2WAbGWME8TYrRbGf"></script>

    <script type="text/javascript">
        var map = new BMap.Map("div_map");
        var mPoint = new BMap.Point('114.105849', '22.565676');
        map.centerAndZoom(mPoint, 17);
        map.enableScrollWheelZoom();
        map.addOverlay(new BMap.Marker(mPoint));
    </script>
<?php include("common/foot.php");?>
</body>
</html>