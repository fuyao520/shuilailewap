<?php include(dirname(__FILE__)."/head.php")?>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?> 
<script type="text/javascript" src="<?php echo Yii::app()->params['basic']['cssurl']; ?>default/js/jquery.jcarousellite.js"></script>  
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>
        <div class="fr comp_main border-out">
            <div class="border-in conrbox" >
            	<div class="clearfix index-info-box">
            		<div class="fl">
            			<img src="<?php echo $page['company']['company_logo'];?>" width=70 height=70 style="padding:3px;border:1px solid #ccc;margin-right:5px;">
            		</div>
            		<div class="fl" style="line-height:18px;">
            		<span style="font-size:16px;font-weight:bold;"><?php echo Yii::app()->company_user->company_name;?></span>  （<?php echo Yii::app()->company_user->uname;?>），欢迎您！  
            		 <br>
            		<span class="umyphone-box"> 
            			<?php if($page['company_user']['uphone_verify']==0){?>
            				手机号：<?php echo $page['company_user']['uphone'];?>
            				<a href="<?php echo $this->createUrl('account/bindMobile');?>"><span style="color:#f30;">未绑定，点击绑定</span></a>
            			<?php }else{?>
            			  手机号：<span style="font-size:14px;font-weight:bold;color:green;"><?php echo $page['company_user']['uphone'];?></span>
            			<?php }?>
            		</span><br>
            		公司电话： <?php echo $page['company']['company_tel'];?><br />
            		
            		传真： <?php echo $page['company']['company_fax'];?>   地址： <?php echo $page['company']['company_address'];?><br />
            		</div>
            		<div class="fr">
            			我的积分：<span class="points_icon"><?php echo $page['points_total'];?></span>
            		</div>
            	</div>
            	
            	
            	
            	<div class="global07-tit mt10">
					            <a href="javascript:void(0);" class="current">快捷操作</a>            	
					        </div>
            	<div class="border">
            		<div style="padding:10px;">
            		<a href="<?php echo $this->createUrl('points/index');?>" class="user-publish-btn01"><em>我的积分</em></a>
            		<a href="<?php echo $this->createUrl('companyProfile/index');?>" class="user-publish-btn01"><em>基本资料</em></a>
            		<a href="<?php echo $this->createUrl('pmList/index');?>" class="user-publish-btn01"><em>消息通知</em></a>
            		</div>
            	</div>
            	
			    
            	
            	
            </div>
        </div>
    </div>

</div>

<?php include(dirname(__FILE__)."/foot.php")?>

</body>
</html>