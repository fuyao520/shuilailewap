<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['ad_id']='';
	$page['info']['area_id']=$this->get('search_type')=='area_id'?intval($this->get('search_txt')):0;
	$page['info']['ad_words']='';
	$page['info']['ad_title']='';
	$page['info']['ad_url']='';
	$page['info']['ad_img']='';
	$page['info']['ad_url']='';
	$page['info']['words_setting']='';
	$page['info']['ad_code']='';
	$page['info']['start_date']=strtotime(date("Y-m-d"));
	$page['info']['expire_date']=strtotime(date("Y-m-d"))+3600*24*365*5;
	$page['info']['show_type']=2;
	$page['info']['city_id']=0;

}
?>

<div class="main mhead">
    <div class="snav">内容中心 »  
    广告管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('ad/update'); ?>?p=<?php echo $_GET['p'];?>&search_type=<?php echo $this->get('search_type');?>&search_txt=<?php echo $this->get('search_txt');?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['ad_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['ad_id']?'修改广告':'添加广告' ?></th>
    </tr>
    
    <tr>
        <td  width="100">广告位置：</td>
        <td  class="alignleft">
        <select name="area_id" id="area_id">
        <?php echo helper::get_option(array('table_name'=>'ad_area','id_field_name'=>'area_id','txt_field_name'=>'area_name','select_value'=>$page['info']['area_id'])); ?>
        </select>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">选择区域：</td>
        <td  class="alignleft">
        	<select name="city_id">
        		<option vlaue=0>默认</option>		
        	<?php echo vars::input_str(array('type'=>'select','node'=>'direction_types','default'=>$page['info']['city_id'],'name'=>'city_id'));?>
			</select>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">广告标题：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="ad_title"   name="ad_title" value="<?php echo $page['info']['ad_title']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">生效时间：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="start_date"   name="start_date" value="<?php echo date('Y-m-d',$page['info']['start_date']); ?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">到期时间：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="expire_date"   name="expire_date" value="<?php echo date('Y-m-d',$page['info']['expire_date']); ?>"  onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">展现方式：</td>
        <td  class="alignleft"> 
            <?php echo vars::input_str(array('node'=>'ad_show_types','type'=>'radio','default'=>$page['info']['show_type'],'name'=>'show_type')); ?>
        </td>      
    </tr>
    <tr>
        <td  width="100">文字内容：</td>
        <td  class="alignleft">
 		<textarea  id="ad_words" style="width:400px; height:60px;"    name="ad_words"><?php echo htmlspecialchars(stripslashes($page['info']['ad_words'])); ?></textarea>
        </td>      
    </tr>
    <tr>
        <td  width="100">广告图片：</td>
        <td  class="alignleft">
         <div class="l">
            <input type="text" class="ipt" id="ad_img" name="ad_img" value="<?php echo $page['info']['ad_img']; ?>"/>
        </div>
        <div class="l" style="margin:0px 10px;" id="ad_img_span">
        <?php echo $page['info']['ad_img']?'<img src="'.$page['info']['ad_img'].'" width=24 height=24>':'' ?>
        </div>
        <div class="l" >
           <script>create_upload_iframe('{"func":"callback_upload","Eid":"ad_img"}');</script>
        </div>

        </td>      
    </tr>
    <tr>
        <td  width="100">链接地址：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="ad_url"   name="ad_url" value="<?php echo $page['info']['ad_url']; ?>"/> 
         <select id="url_cate_id" name="url_cate_id">
        <option value="0">≡ 用栏目作为链接地址 ≡</option>
		<?php echo $page['categorys']; ?>
        </select>
         
        </td>      
    </tr>
    <tr>
        <td  width="100">广告代码：</td>
        <td  class="alignleft">
        <textarea  id="ad_code" style="width:98%; height:300px;"    name="ad_code"><?php echo htmlspecialchars($page['info']['ad_code']); ?></textarea>
		<script>//$("#ad_code").xheditor({"skin":"nostyle",internalScript:true,inlineScript:true });</script>
        </td>      
    </tr>
    
    <tr>
        <td></td>
        <td  class="alignleft">
        <input type="submit" class="but" id="subtn" value="确定" />
         <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('ad/index'); ?>?p=<?php echo $_GET['p'];?>&search_type=<?php echo $this->get('search_type');?>&search_txt=<?php echo $this->get('search_txt');?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>