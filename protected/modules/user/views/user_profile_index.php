<?php $page['cate']['cate_id']='user';?>
<?php include(dirname(__FILE__).'/common/inc.php'); ?>
<?php include(dirname(__FILE__).'/common/head.php'); ?>
<body>
<?php include(dirname(__FILE__).'/common/global-bar.php'); ?>
<?php include(dirname(__FILE__).'/common/nav.php'); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['birth_day']='';
    $page['info']['sex']='';
    $page['info']['constellation']='';
    $page['info']['signature']='';
    $page['info']['occupation']='';
}
?>
   
<div class="regmain">
	<div class="main">
		<div class="bzzx">
			<?php include(dirname(__FILE__).'/common/sider.php'); ?>
        <div class="help_rig">
			<div class="laction"><h2>基本信息设置</h2> <span></span></div><!--laction end-->
	<div class="help_con">
   <table class="tb_up mt10">
  
            <tr>
                <td class="zctd">账号：</td>
                <td><?php echo Yii::app()->user->uname; ?></td>
            </tr>
            
            <tr>
                <td class="zctd">头像：</td>
                <td><img src="<?php echo $page['info']['tou_img']; ?>" width=80 height=80></td>
            </tr>
                       
            <tr>
                <td class="zctd">性别：</td>
                <td><?php echo $page['info']['sex']==1?'男':''; ?><?php echo $page['info']['sex']==2?'女':''; ?></td>
            </tr>
            
            <tr>
                <td class="zctd">生日：</td>
                <td><?php echo $page['info']['birth_day']?date('Y-m-d',$page['info']['birth_day']):'-'; ?></td>
            </tr>
            
            <tr>
                <td class="zctd">星座：</td>
                <td><?php echo vars::get_field_str('constellations', $page['info']['constellation']); ?></td>
            </tr>
            
            <tr>
                <td class="zctd">职业：</td>
                <td><?php echo $page['info']['occupation']; ?></td>
            </tr>
            
            <tr>
                <td class="zctd">个性签名：</td>
                <td><?php echo $page['info']['signature']; ?></td>
            </tr>
            
          
            

            <tr>
                <td class="zctd"></td>
                <td>
                	<input type="button" class="btn06" value="修改" onclick="location='<?php echo $this->createUrl('userProfile/update');?>'" />
                </td>
            </tr>
            
		</table>
		
		</div>
		
		   
           
            
        </div>
    </div>

</div>

<?php include(dirname(__FILE__)."/common/foot.php")?>
<script>
</script>


</body>
</html>