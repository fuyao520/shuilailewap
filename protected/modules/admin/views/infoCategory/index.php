<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
var btotal=0;
var catetotal=<?php echo count($page['idarr']);?>;
var idarr=[];
function get_cate_total(){
	//得到每个分类的总数
	$(".ttbtn").val('正在更新('+(catetotal-btotal)+')..');
	$(".ttbtn").attr("disabled",true);
	
	idarr=<?php echo json_encode($page['idarr']); ?>;
	var delay=1000;
	send_gettotal(idarr[0]);
}
function send_gettotal(cate_id){
	btotal++;
	if(btotal>=catetotal){	
		$(".ttbtn").attr("disabled",false);
		$(".ttbtn").val("更新数据");
		return;
	}
	$(".ttbtn").val('正在更新('+(catetotal-btotal)+')..');
	$.ajax({url:"<?php echo $this->createUrl('infoCategory/getCateTotalInfo');?>?cate_id="+cate_id,success: function(data){
			var json=$.evalJSON(data);
			$("#fei_"+json.cate_id).html(json.totals);
			send_gettotal(idarr[btotal-1]);
	}});	
}

function reset_cname_py(){
    if(confirm('确定重置吗？')&&confirm('真的确定吗？')){
		location='<?php echo $this->createUrl('infoCategory/resetNamePy');?>?parent_id=0';
	}	
}
</script>
<div class="main mhead">
    <div class="snav">内容中心 » 栏目分类</div>
    <div class="mt10 clearfix">
        <div class="l">
            <input type="button" class="but2" value="修改排序" onclick="document.form_corder.submit();" />&nbsp;
            <input type="button" class="but2 ttbtn" value="更新数据量" onclick="get_cate_total();" />
            <input type="button" class="but2" value="添加栏目" onclick="location='<?php echo $this->createUrl('infoCategory/update');?>'" />
            <input type="button" class="but2" value="批量添加栏目" onclick="location='<?php echo $this->createUrl('infoCategory/addMore');?>'" />
            <input type="button" class="but2" value="重置所有栏目拼音"  onclick="reset_cname_py();" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('infoCategory/saveCorder'); ?>" name="form_corder" method="post">
<table class="tb">
    <tr>
        <th align='center' width="48">排序</th>
        <th align='center' width="70">分类ID</th>
        <th  class="alignleft">分类名称</th>
        <th width=50>导航</th>
        <th width=100>单篇介绍</th>
        <th width=100>模型</th>
        <th width=50>数据量</th>
        <th width=280>操作 </th>
    </tr>
    <?php echo $page['categorys']; ?>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>