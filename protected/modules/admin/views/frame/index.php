<?php $_GET['layout']=isset($_GET['layout'])?$_GET['layout']:''; ?>
<?php 
$page['doctype']=1;
?>
<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<table cellspacing="0" cellpadding="0" width="100%" height="100%" border="0" align="center">
    <tr>
        <td class="top_nav logo"><a href="<?php echo $this->createUrl('frame/welcome'); ?>" target="main" class="logoa" style=" display:block; <?php if($this->layout==''){echo 'height:60px;line-height:60px;overflow:hidden;';}else if($this->layout==2){echo 'height:30px;line-height:30px;overflow:hidden;';} ?>width:140px;">
        <?php echo Yii::app()->params['management']['name']?Yii::app()->params['management']['name']:Yii::app()->params['basic']['sitename']; ?></a></td>
        <td class="top_nav">
        <iframe name="top_frame" frameborder="0" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;height:30px;" src="<?php echo $this->createUrl('frame/top',array('layout'=>$_GET['layout']));?>"></iframe>
        </td>
    </tr>
    <tr><td width="150" valign="top" class="menu">
    <iframe name="left_frame" frameborder="0" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;" src="<?php echo $this->createUrl('frame/left',array('layout'=>$_GET['layout']));?>"></iframe>
    </td>
    <td valign="top"><iframe name="main" frameborder="0" width="100%" height="100%" frameborder="0" scrolling="yes" style="overflow: visible;" src="<?php echo $this->createUrl('frame/welcome',array('layout'=>$_GET['layout']));?>"></iframe></td></tr>
</table>
