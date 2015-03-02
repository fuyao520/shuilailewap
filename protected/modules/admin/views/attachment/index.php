<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
function resizeImage(obj, MaxW, MaxH)
{
var imageObject = obj;
    var oldImage = new Image();
    oldImage.src = imageObject.src;
    var dW = oldImage.width; 
    var dH = oldImage.height;
    if(dW>MaxW || dH>MaxH) 
   {
        a = dW/MaxW; b = dH/MaxH;
        if(b>a)
		 { 
		 a=b;
		 }
        dW = dW/a; 
		dH = dH/a;
    }
    if(dW > 0 && dH > 0) 
	{
			imageObject.width = dW;
		   imageObject.height = dH;
	}
}
</script>
<style>
.resource_ico{ width:20px; height:20px;}
</style>

<div class="main mhead">
    <div class="snav">模块管理 »   资源管理
     </div>
    <div class="mt10 clearfix">
        <div class="l">
            <input type="button" class="but2" value="删除选中" onclick="set_some('<?php echo $this->createUrl('attachment/delete');?>?ids=[@]','确定删除吗？');" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<table class="tb">
    <tr>
        <th><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('attachment/index').'?p='.$_GET['p'].'','field_cn'=>'资源名称','field'=>'r_name')); ?></th>
        <th class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('attachment/index').'?p='.$_GET['p'].'','field_cn'=>'资源地址','field'=>'resource_url')); ?></th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('attachment/index').'?p='.$_GET['p'].'','field_cn'=>'文件类型','field'=>'resource_type')); ?></th>
        <th style="text-align:left;"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('attachment/index').'?p='.$_GET['p'].'','field_cn'=>'缩略图','field'=>'resource_url')); ?></th>
        <th>资源大小</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['resource_id']; ?>" /></td>
        <td><?php echo $r['r_name']?$r['r_name']:'-'; ?></td>
        <td class=alignleft><a href="<?php echo $r['resource_url']; ?>" target="_blank"><?php echo $r['resource_url']; ?></a></td>
        
        <td><?php if(preg_match('~\.([a-zA-Z]+)$~',$r['resource_url'],$b)){echo '<img class="resource_ico" src="'.Yii::app()->params['basic']['cssurl'].'admin/img/resource_ico/'.$b[1].'.jpg" />';} ?></td>
        
        <td align="center" style="text-align: center;">
        
		<?php if(preg_match('~\.(jpg|png|gif|bmp)$~i',$r['resource_url'])){?>
        <div style="display:table-cell; vertical-align:middle;width:30px;  height:30px; overflow:hidden; border:1px solid #ccc; padding:2px;">
			<a target="_blank" href="<?php echo $r['resource_url'];?>"><img src="<?php echo $r['resource_url'];?>" onload="resizeImage(this,30,30)" style="width:30px;height:30px;" /></a>	
                    </div>

		<?php }else{?>
        <div style="display:table-cell; vertical-align:middle;width:30px;  height:30px; overflow:hidden; padding:2px; margin:2px auto;">
        </div>
        <?php }?>
        </td>
        <td><?php echo $r['r_size']?preg_replace('~(\.\d+)~','',($r['r_size']/1000)).'kb':'-'; ?></td>
    </tr>
   <?php } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>