<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
$(document).ready(function(){
	C.tabs(
	{"style":{		//选项卡样式
	"sclass":"current"	//选中
	},
	"params":[
	{"nav":"#conbtn1","con":"#con001"},
	{"nav":"#conbtn2","con":"#con002"},
	{"nav":"#conbtn3","con":"#con003"},
	{"nav":"#conbtn4","con":"#con004"},
	{"nav":"#conbtn5","con":"#con005"},
	{"nav":"#conbtn6","con":"#con006"}
	]}
	)
})
</script>
<div class="main mhead">
    <div class="snav">内容中心 » 资讯分类</div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('infoCategory/addMore');?>">
<div class="tab_table">
   <div class="title01">批量添加栏目</div>
   <div class="btn_box">
        <a href="#" id="conbtn1" class="current" >基本设置</a>
       
   </div>
</div>
<div id="e_box">
<table class="tb3" id="con001" width="100%">
    <tr>
        <td  width="120">选择模型：</td>
        <td  class="alignleft">
        <select id="model_id" name="model_id">
            <?php echo $this->get_option(array('table_name'=>'model','id_field_name'=>'model_id','txt_field_name'=>'model_name','wheresql'=>' where model_type=0 and parent_model_id=0 ')); ?>
		</select></td>      
    </tr><tr>
        <td  width="100">上级栏目：</td>
        <td  class="alignleft"><select id="parent_id" name="parent_id">
        <option value="0">≡ 作为一级栏目 ≡</option>
		<?php echo $page['categorys']; ?></select></td>      
    </tr>
    <tr>
        <td  width="100">名称：</td>
        <td  class="alignleft">
        <textarea name="cnames"  style="width:600px;height:200px;"></textarea>
         <span> 用空格隔开</span>

        </td>      
    </tr>
 
    
</table>
<div>
<table class="tb3">
 <tr>
        <td width="100"></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('infoCategory/index');?>'" /></td>
    </tr>
    </table>
</div>

</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>