<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<script>
function load_data_list(){
	var inid=$("#inid").val();
	var id_field=$("#id_field").val();
	var name_field=$("#name_field").val();
	var table_name=$("#table_name").val();
	$.get("index.php?m=admin&c=recommend&a=get_recommend_data&inid="+inid+"&id_field="+id_field+"&name_field="+name_field+"&table_name="+table_name+"",function(data){
		//alert(data);
	    try{
		$("#recommend_data > ul").html('');
		var json=$.evalJSON(data);
		var html='';
		for(var i=0;i<json.length;i++){
		    html+='<li><a href="javascript:void(0);"  onclick="del_data(this,\''+json[i][id_field]+'\')"><span class=r>删除</span></a><span class="gray">ID：'+json[i][id_field]+'</span>  <span class="tit2"> '+json[i][name_field]+'</span></li>';	
		}
		$("#recommend_data > ul").append(html);
		$("#recommend_data").scrollTop(10000);
		}catch(e){alert(e.message);}
	})
	
}
function del_data(eobj,id){
	try{
    var liobj=$(eobj).parent();	
	liobj.remove();
	var inid=$("#inid").val();
	if(inid.indexOf(',')<=0){
	    $("#inid").val('');
		return;
	}
	var rule='/(,'+id+'[^,]*|^'+id+',)/';
	var newval=inid.replace(eval(rule),'');
	
	$("#inid").val(newval);
	}catch(e){alert(e.message);}
	
}
function open_data_list(){
	var id_field=$("#id_field").val();
	var name_field=$("#name_field").val();
	var table_name=$("#table_name").val();
	if(!id_field||!name_field||!table_name){
	    alert('数据表名，ID字段名，标题字段名不能为空！');	
	}
    window.open("index.php?m=admin&c=recommend_ext&id_field="+id_field+"&name_field="+name_field+"&table_name="+table_name,'win1','height=400, width=700, top=100, left=450,crollbars=yes,  menubar=no, location=no, status=no');
}
function add_data(id,title){
	try{
    var html=$("#recommend_data > ul").html();
	var rule=eval('/>ID：'+id+'</');
	if(html.match(rule)!=null){
		alert('已经存在');
		return false;
	}
	var html='<li><a href="javascript:void(0);"  onclick="del_data(this,\''+id+'\')"><span class=r>删除</span></a><span class="gray">ID：'+id+'</span>  <span class="tit2"> '+title+'</span></li>';
	$("#recommend_data > ul").append(html);
	var inid=$("#inid").val();
	var newval=$("#inid").val()+(inid==''?id:','+id);
	$("#inid").val(newval);
    $("#recommend_data").scrollTop(10000);
	}catch(e){alert(e.message);}	
}
</script>
<style>
.recommend_data{ height:200px; overflow-y:scroll; margin:10px; width:700px;}
.recommend_data ul{}
.recommend_data ul li{ list-style:decimal; margin:0px 10px; margin-left:30pt;}
.recommend_data ul li:hover{ background:#F5F5F5;}
.recommend_data ul li .tit2{ width:300px; display:inline-block; vertical-align:middle; overflow:hidden; height:24px;}
</style>

<div class="main mhead">
    <div class="snav">内容中心 »  推荐位管理	</div>
 
    <div class="mt10 clearfix">
        <div class="l">
           <input type="button" class="but2" value=" 删除选中 " onclick="set_some('<?php echo $this->createUrl('recommend/delete');?>?ids=[@]','确定删除吗？');" />
           <input type="button" class="but2" value="添加推荐位" onclick="location='<?php echo $this->createUrl('recommend/update');?>'" />
        </div> 
        <div class="r">
            
        </div>
    </div>
</div>
<div class="main mbody">
<form action="<?php echo $this->createUrl('recommend/saveOrder');?>" name="form_order" method="post">
<table class="tb">
    <tr>
        <th width="100"><a href="javascript:void(0);" onclick="check_all('.cklist');">全选/反选</a></th>
        <th width="80"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('recommend/index').'?p='.$_GET['p'].'','field_cn'=>'ID','field'=>'recommend_id')); ?>	</th>
        <th width="400"  class="alignleft"><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('recommend/index').'?p='.$_GET['p'].'','field_cn'=>'推荐位名称','field'=>'recommend_name')); ?>	</th>
        <th><?php echo helper::field_paixu(array('url'=>''.$this->createUrl('recommend/index').'?p='.$_GET['p'].'','field_cn'=>'数据表','field'=>'table_name')); ?>	</th>
        <th width=200>操作</th>
    </tr>
    
   <?php 
   foreach($page['listdata']['list'] as $r){
   ?>
    <tr>   
        <td><input type="checkbox" class="cklist" value="<?php echo $r['recommend_id']; ?>" /></td>
        <td><?php echo $r['recommend_id']; ?></td>
        <td class="alignleft"><a href="<?php echo $this->createUrl('recommend/update');?>?id=<?php echo $r['recommend_id'];  ?>&p=<?php echo $_GET['p'];  ?>"><?php echo $r['recommend_name']; ?></a></td>
     	<td><?php echo $r['table_name']; ?></td>
        <td><a href="<?php echo $this->createUrl('recommend/update');?>?id=<?php echo $r['recommend_id'];  ?>&p=<?php echo $_GET['p'];  ?>">修改</a></td>	
    </tr>
   <?php 
   } ?> 
     
    
</table>
  <div class="pagebar"><?php echo $page['listdata']['pagearr']['pagecode']; ?></div>
  <div class="clear"></div>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>