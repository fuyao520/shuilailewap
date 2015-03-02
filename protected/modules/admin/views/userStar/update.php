<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['id']='';
	$page['info']['uid']='';
	$page['info']['create_time']=time();
	$page['info']['reason']='';
	$page['info']['cover']='';
}
?>
<div class="main mhead">
    <div class="snav">内容中心 »  
    达人管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('userStar/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['id']?'修改达人':'添加达人' ?></th>
    </tr>   
    
    <tr>
        <td  width="100">用户ID：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="uid"   name="uid" value="<?php echo $page['info']['uid']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td  width="100">推荐理由：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt size400"  id="reason"    name="reason" value="<?php echo $page['info']['reason']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">图片：</td>
        <td  class="alignleft">
         <div class="l">
            <input type="text" class="ipt" id="cover" name="cover" value="<?php echo $page['info']['cover']; ?>"/>
        </div>
        <div class="l" style="margin:0px 10px;" id="cover_span">
        <?php echo $page['info']['cover']?'<img src="'.$page['info']['cover'].'" width=24 height=24>':'' ?>
        </div>
        <div class="l" >
           <script>create_upload_iframe('{"func":"callback_upload","Eid":"cover"}');</script>
        </div>

        </td>      
    </tr>
    
    <tr>
        <td  width="100">日期：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="create_time"   name="create_time" value="<?php echo date('Y-m-d',$page['info']['create_time']); ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('userStar/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>