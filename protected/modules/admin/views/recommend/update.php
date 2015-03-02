<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['recommend_name']='';
	$page['info']['recommend_id']='';
	$page['info']['table_name']='';
	$page['info']['inid']='';
	$page['info']['id_field']='';
	$page['info']['name_field']='';
}
?>
<script>
function load_data_list(){
	var inid=$("#inid").val();
	var id_field=$("#id_field").val();
	var name_field=$("#name_field").val();
	var table_name=$("#table_name").val();
	$.get("<?php echo $this->createUrl('recommend/GetRecommendData');?>?inid="+inid+"&id_field="+id_field+"&name_field="+name_field+"&table_name="+table_name+"",function(data){
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
    window.open("<?php echo $this->createUrl('recommend/RecommendExt');?>?id_field="+id_field+"&name_field="+name_field+"&table_name="+table_name,'win1','height=400, width=700, top=100, left=450,crollbars=yes,  menubar=no, location=no, status=no');
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
    <div class="snav">内容中心 »  
    推荐位管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('recommend/update');?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['recommend_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['recommend_id']?'修改推荐位':'添加推荐位' ?></th>
    </tr>
    
    
    
    <tr>
        <td  width="100">推荐位名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="recommend_name"   name="recommend_name" value="<?php echo $page['info']['recommend_name']; ?>"/> 

        </td>      
    </tr>

    <tr>
    	<td></td>
        <td  class="alignleft">
        <span id="advan_box" style="display:none;">
        数据库表名
        <input type="text"  class="ipt"  id="table_name"   name="table_name" value="<?php echo $page['info']['table_name']; ?>"/> 
        (ID字段 <input type="text" size="10" id="id_field" name="id_field" value="<?php echo $page['info']['id_field']; ?>" /> ID：名称（或标题） <input type="text" size="10" id="name_field" name="name_field" value="<?php echo $page['info']['name_field']; ?>" />) 
        <span class="red"> * 可推荐任何数据表</span>  
        </span>
        <input type="button" class="but2" value="选择数据" onclick="open_data_list()" />
        <span onclick="$('#advan_box').toggle();"><a href="#">打开高级设置</a></span>
        </td>      
    </tr>
    
    <tr>
        <td  width="100">数据集合：</td>
        <td  class="alignleft">
        
        <div class="recommend_data" id="recommend_data">
            <ul>
             
        </ul>
        </div>
        <span class="red">* 请用英文逗号隔开ID</span><br />
        <textarea id="inid"   name="inid" style="width:700px; height:70%;" ><?php echo $page['info']['inid']; ?></textarea>
        <input type="button" class="but2" value="刷新数据" onclick="load_data_list()" />
        <script>load_data_list();</script>
        

        </td>      
    </tr>
   
    
    
    
    <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('recommend/index');?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/head.php"); ?>