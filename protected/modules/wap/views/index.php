
<?php
    var_dump($pages);
    die;
?>
<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
			<div class="help_rig">
				<div class="laction"><h2>您好！<em><?php echo Yii::app()->user->uname;?></em></h2> <span style="display:none;">您的上次登录时间：2014-09-05 12:00</span></div><!--laction end-->
			  <div class="help_con">
					<div class="grxx">
						<a href="<?php echo $this->createUrl('userProfile/update');?>" class="img"><img src="<?php echo $page['user']['tou_img']?$page['user']['tou_img']:'/static/default/images/nophoto.jpg';?>">
						<em>编辑个人资料</em></a>
						<div class="rig_box">
							<span class="wdjf">我的积分<a href="<?php echo $this->createUrl('points/index');?>">：<em><?php echo $page['points_total'];?></em></span>
						</div><!--rig_box end-->
					</div><!--grxx end-->
					
					
			  </div><!--help_con end-->
			</div><!--help_rig end-->
		</div><!--bzzx end-->
  </div><!--main end-->
</div><!--regmain end-->

<?php include(dirname(__FILE__)."/common/foot.php")?>
<script>
$(".zjlr .bli h2").hover(
	function(){
		$(".zjlr .bli").removeClass('on');
		$(this).parent().addClass('on');
	},
	function(){
	
	}
)
$(document).ready(function(){
	$(".collect_btn").click(function(){
		if(userinfo.isGuest==1){
			alert('必须先登录才能使用该功能噢~');
			return false;
		}
		var model=$(this).attr('data-model');
		var info_id=$(this).attr('data-id');
		add_collect(model,info_id);	
	})
});

</script>
<style>
.regmain .main .bzzx .help_rig .help_con .zjlr ul .bli ul{display:none}
.regmain .main .bzzx .help_rig .help_con .zjlr ul .on ul{display:block;}
</style>

</body>
</html>