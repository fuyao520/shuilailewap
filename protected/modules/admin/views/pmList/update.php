<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['pm_id']='';
	$page['info']['uid_recv']='';
	$page['info']['uid_post']='';
	$page['info']['pm_title']='';
	$page['info']['pm_body']='';
	$page['info']['pm_type']=1;

}
?>


<div class="main mhead">
    <div class="snav">用户中心 »  
    站内信管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('pmList/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['pm_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['pm_id']?'修改站内信':'添加站内信' ?></th>
    </tr>
    <tr style="display:none;">
        <td  width="100">类型：</td>
        <td  class="alignleft">
            <label><input type="radio" name="pm_type" value="1" <?php echo $page['info']['pm_type']==1?'checked':''; ?> /> 系统 </label>
            <label><input type="radio" name="pm_type" value="2" <?php echo $page['info']['pm_type']==2?'checked':''; ?> /> 私信</label>

        </td>      
    </tr>
    <tr style="display:none;">
        <td  width="100">发件人uid：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt" size="10"  id="uid_post"   name="uid_post" value="<?php echo $page['info']['uid_post']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">收件人uid：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt" size="10"  id="uid_recv"   name="uid_recv" value="<?php echo $page['info']['uid_recv']; ?>"/> 

        </td>      
    </tr>
    
    <tr>
        <td  width="100">短信标题：</td>
        <td  class="alignleft">
        <input type="text" class="ipt" size="50"  id="pm_title"   name="pm_title" value="<?php echo $page['info']['pm_title']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">短信内容：</td>
        <td  class="alignleft">
        <textarea id="pm_body"   name="pm_body" style="width:98%; height:200px;"><?php echo htmlspecialchars($page['info']['pm_body']); ?></textarea>
              <script>$("#pm_body").xheditor({skin:'nostyle'});</script>

        </td>      
    </tr>

    
    
    
    
    
    
    
    
   <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('pmList/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>