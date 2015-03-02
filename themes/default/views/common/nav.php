<div class="menu">
	<div class="width menu-main">
            <ul class="menu-ul clearfix">
                <li><a href="/" class="ma idx-a on">主页</a></li>
                <li><a href="<?php echo Cms::model()->categorys[117]['surl'];?>" class="ma pro-a">饮水品牌</a><em></em>
                	<ul class="brandullist clearfix">
                		<?php foreach($brand_cates as $r){?>
                		<li><a href="<?php echo g_s_url('brand',$r['linkage_id']);?>"><?php echo $r['linkage_name'];?></a></li>
                		<?php }?>
                	</ul>
                </li>
                
                <li><a href="<?php echo $this->createUrl('/companys/index');?>" class="ma ser-a">服务点</a></li>
                <li><a href="<?php echo Cms::model()->categorys[118]['surl'];?>" class="ma eqi-a">周边设备</a><em></em>
                	<ul class="clearfix">
                		<?php $a=Cms::model()->cate_son(118);?>
                		<?php foreach($a as $r){?>
                		<li><a href="<?php echo $r['surl'];?>"><?php echo $r['cname'];?></a></li>
                		<?php }?>
                	</ul>
                </li>
                <li><a href="<?php echo Cms::model()->categorys[124]['surl'];?>" class="ma eqi-a">生鲜直供</a><em></em>
                	<ul class="clearfix">
                		<?php $a=Cms::model()->cate_son(124);?>
                		<?php foreach($a as $r){?>
                		<li><a href="<?php echo $r['surl'];?>"><?php echo $r['cname'];?></a></li>
                		<?php }?>
                	</ul>
                </li>
                <li><a href="<?php echo Cms::model()->categorys[127]['surl'];?>" class="ma eqi-a">超值钜惠</a><em></em>
                	<ul class="clearfix">
                		<?php $a=Cms::model()->cate_son(127);?>
                		<?php foreach($a as $r){?>
                		<li><a href="<?php echo $r['surl'];?>"><?php echo $r['cname'];?></a></li>
                		<?php }?>
                	</ul>
                </li>
                <li><a href="<?php echo $this->createUrl('/companys/index');?>" class="ma ser-a">服务点</a></li>
                <li><a href="<?php echo $this->createUrl('/company/site/index');?>" class="ma ser-a">水站加盟</a></li>
                <li><a href="<?php echo Cms::model()->categorys[122]['surl'];?>" class="ma eqi-a">企业采购</a></li>
            </ul>
    </div>
 </div>   
    
   <script>
var userinfo={"isGuest":1,"uname":""};
check_login();

$(".menu-ul>li").hover(
		function(){
			var liobj=$(this);
			$(this).find("ul").show();	
			$(this).find("em").rotate({
				angle:0, 
	      		animateTo:180,
				callback: setTimeout("rotation()",3000)
			});
			//$(this).find("em").addClass('on');
		},
		function(){
			var liobj=$(this);
			liobj.find("em").rotate({animateTo:0});
			$(this).find("ul").hide();	
			//$(this).find("em").removeClass('on');
		}
	);
</script> 