<?php include(dirname(__FILE__)."/head.php"); ?>
<?php $a=Cms::model()->cate_son($page['cate']['cate_id']);?>
<?php if(count($a)){?>
<div class="sj-nav width">
  <ul class="clearfix">
    <li><a href="/" class="on">首页</a></li>
    
    <?php foreach($a as $r){?>
    <li><a href="<?php echo $r['surl'];?>"><?php echo $r['cname'];?></a></li>
    <?php }?>
  </ul>
</div>
<?php }?>
<div class="dbox box-sha txtsha1">
	<div class="location">当前位置：
		<a href="/">首页</a><code> &gt; <?php echo $page['snav'];?>
	</div>
</div>

<div class="sj-cen2 width listimg01">
<?php foreach($page['listdata']['list'] as $r){?>
<div class="neirong2 flow-item"><a href="<?php echo $r['url'];?>" title="<?php echo $r['title'];?>"><?php echo $r['title'];?></a></div>
<?php }?>

</div> 

<div class="page" style="display:none;">
	<?php echo $page['listdata']['pagearr']['pagecode'];?>
</div>
<?php if($page['listdata']['pagearr']['totalpage']>1){?>
<div class="flow_btn00001" ><a href="javascript:void(0);">点击加载更多</a></div>
<?php }?>
<div class="loading" style="text-align:center;"></div>	




<div class="sj-cen15 width">
<?php include(dirname(__FILE__)."/foot.php"); ?>
</div>

<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/js/jquery-1.7.1.min.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/js/jquery.masonry.min.js"></script>
<script src="<?php echo Yii::app()->params['basic']['cssurl']; ?>lib/jquery.infinitescroll/jquery.infinitescroll.click.js?2"></script>
<script>


$(function(){
	
	var $container=$('.listimg01');

	
	$container.infinitescroll({
	    navSelector : '.page', //分页导航的选择器
	    nextSelector : '.pageNextBtn', //下页连接的选择器
	    itemSelector : '.flow-item', //你要检索的所有项目的选择器
	  // extraScrollPx: 150, //滚动条距离底部多少像素的时候开始加载，默认150    
	    //bufferPx     : 2000,//载入信息的显示时间，时间越大，载入信息显示时间越短
	    animate:true,
	    loadingImg:'/static/mobile/images/load9.gif', //loading图片
	    loadingText  : "Loading new posts...",
	    errorCallback: function(){}   ,                          //加载完数据后的回调函数，可选    
		loading: {
	        msgText: "",
			img:"/static/mobile/images/load9.gif",
	        finishedMsg: '没有新数据了',
	        selector: '.loading' // 显示loading信息的div
		        
	    }
	},
	
	//作为回调函数触发masonry
	function( newElements ) {
	//当加载时隐藏所有新项目
		 
		var $newElems = $( newElements );
		$container.append($newElems);
		$(".flow_btn00001").show();
		    
		    
	}
	);
	
});


</script>

</body>
</html>
