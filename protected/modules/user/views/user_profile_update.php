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
   $page['info']['tou_img']='';
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
				<div class="jfjl">
		        <form action="javascript:void(0);" onsubmit="return false;" id="user_setting_box">
		        <table class="tb_up">
		  
		            <tr>
		                <td class="zctd">账号：</td>
		                <td height=30>
		                <?php echo Yii::app()->user->uname; ?>
		                </td>
		            </tr>
		            <tr>
				        <td class="zctd">头像：</td>
				        <td  class="alignleft">
					         <div class="fl">
					            <input type="hidden" class="ipt" id="tou_img" name="tou_img" value="<?php echo $page['info']['tou_img']; ?>"/>
					         </div>
					         <div class="fl" style="margin:0px 10px;" id="tou_img_span">
					         <?php echo $page['info']['tou_img']?'<img src="'.$page['info']['tou_img'].'" width=50 height=50>':'' ?>
					         </div>
					         <div class="fl" >
					           <script>create_upload_iframe('{"func":"callback_upload","Eid":"tou_img"}');</script>
					         </div>
				
				        </td>      
				    </tr>
		            
		            			
		            <tr>
		                <td class="zctd">出生日期：</td>
		                <td><input type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" class="ipt" id="birth_day" value="<?php echo $page['info']['birth_day']?date('Y-m-d',$page['info']['birth_day']):''; ?>" /></td>
		            </tr>
		            
		            <tr>
		                <td class="zctd">性别：</td>
		                <td>
		                
		                <input type="radio"  name="sex" value="1" <?php echo $page['info']['sex']==1?'checked':''; ?>> 男
		                <input type="radio"  name="sex" value="2" <?php echo $page['info']['sex']==2?'checked':''; ?>> 女
		                
		                
		                </td>
		            </tr>
		            <tr>
		                <td class="zctd">星座：</td>
		                <td>
		                <select id="constellation" class="sels1">
		                	<?php echo vars::input_str(array('type'=>'select','node'=>'constellations','default'=>$page['info']['constellation']))?>
		                </select>
		                </td>
		            </tr>
		            
		           <tr>
		                <td class="zctd">职业：</td>
		                <td><input type="text" class="ipt" id="occupation" value="<?php echo $page['info']['occupation']; ?>" /></td>
		            </tr>
		            <tr>
		                <td class="zctd">个性签名：</td>
		                <td>
		                <textarea id="signature" style="width:400px; height:50px;"><?php echo htmlspecialchars(stripslashes($page['info']['signature'])); ?></textarea>
		               
		                </td>
		            </tr>
		            
		            <tr>
		                <td class="zctd"></td>
		                <td>
		                	<input type="button" class="btn06" value="提交" onclick="save_user_setting();" /> 
		                	<input type="button"  class="btn03" value="返回" onclick="window.location='<?php echo $this->createUrl('userProfile/index');?>'" />
		                </td>
		            </tr>
		            
		        </table>
		        </form>
		        </div>
		    </div>
       </div>
 </div>

<?php include(dirname(__FILE__)."/common/foot.php")?>
<script>

function save_user_setting(){	
    var postdata=C.form.get_form("#user_setting_box");
	//alert($.toJSON(postdata));	
	$.post("<?php echo $this->createUrl('userProfile/update')?>",postdata,function(restr){
	    try{
			var ret=eval("("+restr+")");
			if(ret.code<1){
			    alert(ret.statewords);
				return false;	
			}else{
			    window.location='<?php echo $this->createUrl('userProfile/index');?>';	
			}
		}catch(e){alert(e.message+restr);}	
	})	
}

</script>


</body>
</html>