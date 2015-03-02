<?php include(dirname(__FILE__)."/head.php")?>
<?php 
if(!isset($page['company'])){
	$page['company']['company_name']='';
	   $page['company']['domain_py']='';
	   $page['company']['seo_title']='';
	   $page['company']['seo_keywords']='';
	   $page['company']['seo_description']='';
	   $page['company']['company_tel']='';
	   $page['company']['email']='';
	   $page['company']['contact']='';
	   $page['company']['company_address']='';
	   $page['company']['info_body']='';
	   $page['company']['company_fax']='';
	   $page['company']['company_about']='';
	   $page['company']['company_logo']='';
	   $page['company']['erweima']='';
	   $page['company']['weibo']='';
	   $page['company']['hours']='';
	   $page['company']['qq']='';
	   $page['company']['business']='';
	   $page['company']['scale']='';
	   $page['company']['reg_assets']='';
	   $page['company']['company_banner']='';
	   $page['company']['year']='';
	   $page['company']['qq']='';
	   $page['company']['url']='';
	   $page['company']['business_products']='';
	   $page['company']['business_stones']='';
	   		
}
?>

<style>
.tb_02 tr th{height:40px;line-height:40px;background:#eee;}
</style>
<body>
<?php include(dirname(__FILE__)."/global-bar.php")?>
<?php include(dirname(__FILE__)."/nav.php")?>     
<div class="width mt10 mb10">
    <div class="usBox mb10  clearfix">
         <?php include(dirname(__FILE__)."/sider.php")?>	
        <div class="fr comp_main border-out">
            
            <div class="site-title">
            基本信息设置
			</div>
	<div class="contentdefault05">
   <table class="tb_up mt10">
  			<tr>
  			<th colspan=2>水站资料</th>
            </tr>
            
            <tr>
                <td class="zctd">水站名称：</td>
                <td><?php echo $page['company']['company_name']; ?></td>
            </tr>
            <tr>
                <td class="zctd">门店照片：</td>
                <td>
                
                <img src="<?php echo $page['company']['company_logo']; ?>" width=80 height=80></td>
            </tr>
            
            <tr>
                <td class="zctd">主营品牌：</td>
                <td>
                    <?php $a2=$page['company']['business_products']?json_decode($page['company']['business_products'],1):array();?>
                	<?php $i=0;foreach($a2 as $id){$i++;?>
                		<?php echo Linkage::model()->get_name($id);?> <?php if($i!=count($a2)) echo ',';?> 
                	<?php }?>
                </td>
            </tr>
            <tr>
                <td class="zctd">送水范围：</td>
                <td>
                    <?php $i=0;foreach($page['region_business'] as $r){$i++;?>
                  			<?php echo $r['name'];?> <?php if($i!=count($page['region_business'])) echo ',';?> 
                  			<?php }?>
                </td>
            </tr>
            
            
            <tr>
  				<th colspan=2>联系方式</th>
            </tr>          
           
            
            <tr>
                <td class="zctd">联系电话：</td>
                <td><?php echo $page['company']['company_fax']; ?></td>
            </tr>
            <tr>
                <td class="zctd">QQ：</td>
                <td><?php echo $page['company']['qq']; ?></td>
            </tr>
           
            
            <tr>
                <td class="zctd">联系人：</td>
                <td><?php echo $page['company']['contact']; ?></td>
            </tr>
            <tr>
                <td class="zctd">联系地址：</td>
                <td><?php echo $page['company']['company_address']; ?></td>
            </tr>
            <tr>
  				<th colspan=2>水站介绍</th>
            </tr> 
            <tr>
                <td class="zctd"></td>
                <td><?php echo $page['company']['company_about']?$page['company']['company_about']:'暂未填写'; ?></td>
            </tr>

            <tr>
                <td class="zctd"></td>
                <td>
                	<input type="button" class="btn02" value="修改" onclick="location='<?php echo $this->createUrl('companyProfile/update');?>'" />
                </td>
            </tr>
            
		</table>
		</div>
		
		   
           
            
        </div>
    </div>

</div>

<?php include(dirname(__FILE__)."/foot.php")?>
<script>
</script>


</body>
</html>