<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<div class="main mhead">
    <div class="snav">内容中心 »  广告管理	</div>
     
     <div class="mt10">
    <form action="<?php echo $this->createUrl('ad/index'); ?>">
	    <select id="search_type" name="search_type">
	        <option value="keys" <?php echo $this->get('search_type')=='keys'?'selected':''; ?>>关键字</option>
	        <option value="id" <?php echo $this->get('search_type')=='id'?'selected':''; ?>>广告ID</option>
	        <option value="area_id" <?php echo $this->get('search_type')=='area_id'?'selected':''; ?>>广告位置ID</option>
	        <option value="k_expire_date" <?php echo $this->get('search_type')=='k_expire_date'?'selected':''; ?> ?>>快到期</option>
        <option value="z_expire_date" <?php echo $this->get('search_type')=='z_expire_date'?'selected':''; ?>  ?>>正常显示</option>
        <option value="y_expire_date" <?php echo $this->get('search_type')=='y_expire_date'?'selected':''; ?> ?>>已经到期</option>
	    </select>&nbsp;
	    <input type="text" id="search_txt" name="search_txt" class="ipt" value="<?php echo $this->get('search_txt'); ?>" >
	    <input type="submit" class="but" value="查询"  >
    </form>
 
    <div class="mt10 clearfix">
        <div class="l">
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="修改排序" onclick="document.form_order.submit();" />','auth_tag'=>'ad_edit')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="删除选中" onclick="set_some(\''.$this->createUrl('ad/delete').'?ids=[@]\',\'确定删除吗？\');" />','auth_tag'=>'ad_del')); ?>
           <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="广告位管理" onclick="location=\''.$this->createUrl('adArea/index').'\'" />','auth_tag'=>'ad_area_show')); ?>
		   <?php $this->check_u_menu(array('code'=>'<input type="button" class="but2" value="添加广告" onclick="location=\''.$this->createUrl('ad/update').'?search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'\'" />','auth_tag'=>'ad_add')); ?>          
           <input type="button" class="but2" value="全部广告" onclick="location='<?php echo $this->createUrl('ad/index');?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('ad/saveOrder'); ?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th width="80">排序</th>
        <th  width="80" ><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('ad/index').'?p='.$_GET['p'].'','field_cn'=>'广告ID','field'=>'a.ad_id')); ?></th>
        <th width="300"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('ad/index').'?p='.$_GET['p'].'','field_cn'=>'广告名称','field'=>'a.ad_title')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('ad/index').'?p='.$_GET['p'].'','field_cn'=>'图片','field'=>'a.ad_img')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('ad/index').'?p='.$_GET['p'].'','field_cn'=>'广告位置','field'=>'a.area_id')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('ad/index').'?p='.$_GET['p'].'','field_cn'=>'分布区域','field'=>'a.city_id')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('ad/index').'?p='.$_GET['p'].'','field_cn'=>'是否到期','field'=>'a.expire_date')); ?></th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['ad_id']; ?>" /></td>
        <td><input type="text" size="2" name="listorders[<?php echo $r['ad_id']; ?>]" value="<?php echo $r['ad_order']; ?>" /></td>
        <td><?php echo $r['ad_id']; ?></td>
        <td class="alignleft"><?php echo $r['ad_title']; ?></td>
        <td>
        <?php if( $r['ad_img']){ ?>
        <img class="slider-simage" src="<?php echo $r['ad_img']; ?>" data-id="<?php echo $r['ad_id']; ?>" style="margin:2px;max-width:100px; min-height:20px;_width:100px;height:20px;" />
        <?php }?>
        </td>
        <td><a href="?search_type=area_id&search_txt=<?php echo $r['area_id']; ?>" title="点击查看此位置的广告"><?php echo $r['area_name']; ?></a></td>
     	<td><?php echo vars::get_field_str('direction_types', $r['city_id']); ?></td>
     	<td>
          <?php if($r['expire_date']<time()){ ?><font color="#FF0000">已经到期</font> 
          <?php }else if($r['expire_date']<(time()+3600*24*7)){ ?><font color="#FF6600">剩余<?php echo ($r['expire_date']-(strtotime(date("Y-m-d"))))/(3600*24); ?>天</font>
          <?php }else{ ?><font color="green">正常状态</font>
          <?php }?>  
        </td>
        <td>
        <?php $this->check_u_menu(array('code'=>'<a href="'.$this->createUrl('ad/update').'?id='.$r['ad_id'].'&p='.$_GET['p'].'&search_type='.$this->get('search_type').'&search_txt='.$this->get('search_txt').'">修改</a>','auth_tag'=>'ad_edit')); ?>
        </td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>

<div class="float-simage-box" style="position: absolute;">
</div>


<script src="/static/lib/jquery.jcrop/jquery.jcrop.min.js"></script>
<link rel="stylesheet" href="/static/lib/jquery.jcrop/jquery.Jcrop.css">
<script>
$(".slider-simage").hover(
	function(){
		$(".float-simage-box").show();
		var imgurl=$(this).attr("src");
		$(".float-simage-box").html('<img src="'+imgurl+'" width=150 />');
		var left=$(this).offset().left-150;
		var top=$(this).offset().top;
		$(".float-simage-box").css({"left":left+'px',"top":top+'px'});
	},
	function(){
		$(".float-simage-box").hide();
	}
)
//封面快速裁剪
$(".slider-simage").click(function(){
	var img=$(this).attr("src");
	var id=$(this).attr("data-id");
	var table="ad_list";
	var idField='ad_id';
	var imgField='ad_img';
	info_cover_crop(table,id,idField,img,imgField);
})



</script>

<?php require(dirname(__FILE__)."/../common/foot.php"); ?>
