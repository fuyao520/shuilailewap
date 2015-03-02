<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['uid']='';
	$page['info']['group_id']='';
	$page['info']['uname']='';
	$page['info']['upass']='';
	$page['info']['uqq']='';
	$page['info']['uname_true']='';
	$page['info']['uemail']='';
	$page['info']['audit']=1;
	$page['info']['uphone']='';
	$page['info']['companyUser_money']=0;
	$page['info']['uname_true']='';
	$page['info']['city_id']=0;
	$page['info']['url_py']='';
}
if(!$page['company']){
	$page['company']['company_id']='';
	$page['company']['company_name']='';
	$page['company']['company_tel']='';
	$page['company']['company_type']='';
}

?>
<script>
function get_select_branch(jsonstr){
   //alert(jsonstr);
   try{
	   var data=$.evalJSON(jsonstr);
	   $("#forcity").html(data.branch_province+'-'+data.branch_city); 
	   $("#branch_id").val(data.branch_id); 
	   $("#branch_name").html(data.branch_name);   
   }catch(e){alert(e.message);}
}
</script>

<script>
$(document).ready(function(){
	C.tabs(
	{"style":{		//选项卡样式
	"sclass":"current"	//选中
	},
	"params":[
	{"nav":"#conbtn1","con":"#con001"},
	{"nav":"#conbtn2","con":"#con002"}
	]}
	)
})
</script>
<div class="main mhead">
    <div class="snav">系统 »  
    企业 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('companyUser/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['uid']; ?>" />
<div class="tab_table">
   <div class="title01"><?php echo $page['info']['uid']?'修改企业':'添加企业' ?></div>
   <div class="btn_box">
        <a href="#" id="conbtn1" class="current" >基本信息</a>
        <a href="#" id="conbtn2" >公司资料</a>       
   </div>
</div>
<table class="tb3" id="con001">
    <tr>
        <td  width="100">帐号：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="uname" autocomplete="off"   name="uname" value="<?php echo $page['info']['uname']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">密码：</td>
        <td  class="alignleft">
        <input type="password"  class="ipt"  id="upass" autocomplete="off"    name="upass" value=""/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">所属城市：</td>
        <td  class="alignleft">
        <span id="t_s_city_id">
        </span>
        <span id="t_s_city_id_load"></span> 
        <script>cg_edit_sele_cc(<?php echo $page['info']['city_id'] ?>,"city_id[]","t_s_city_id","1");</script>
        </td>      
    </tr>
    <tr>
        <td  width="100">真实姓名：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="uname_true"   name="uname_true" value="<?php echo $page['info']['uname_true']; ?>"/> 
        <font color="red"></font>
        </td>      
    </tr>
    <tr style="display:none;">
        <td  width="100">url别名：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="url_py"   name="url_py" value="<?php echo $page['info']['url_py']; ?>"/> 
        <font color="red">默认使用企业ID</font>
        </td>      
    </tr>
    <tr>
        <td  width="100">手机号码：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="uphone"   name="uphone" value="<?php echo $page['info']['uphone']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">邮箱：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="uemail"   name="uemail" value="<?php echo $page['info']['uemail']; ?>"/> 
        </td>      
    </tr> 
    <tr>
        <td  width="100">QQ：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="uqq"   name="uqq" value="<?php echo $page['info']['uqq']; ?>"/> 
        </td>      
    </tr> 
    <tr>
        <td  width="100">审核状态：</td>
        <td  class="alignleft">
			<input id="audit" name="audit" type="radio" value="0"  <?php if($page['info']['audit']==0){echo 'checked';} ?>/>未审核
			<input id="audit" name="audit" type="radio" value="1"  <?php if($page['info']['audit']==1){echo 'checked';} ?>/>已审核
			
        </td>      
    </tr>      
    
    
</table>
<table class="tb3" id="con002" style="display:none;">
	<tr>
        <td  width="100">公司名称：</td>
        <td  class="alignleft">
        <input type="hidden" class="ipt"  id="company_name"   name="company[company_id]" value="<?php echo $page['company']['company_id']; ?>"/> 
        <input type="text" class="ipt"  id="company_name"   name="company[company_name]" value="<?php echo $page['company']['company_name']; ?>"/> 
        </td>      
    </tr> 
    <tr>
        <td  width="100">公司类型：</td>
        <td  class="alignleft">
        <?php echo vars::input_str(array('node'=>'company_types','name'=>'company[company_type]','type'=>'radio','default'=>$page['company']['company_type']));?>
        </td>      
    </tr>
    <tr>
        <td  width="100">公司电话：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="company_tel"   name="company[company_tel]" value="<?php echo $page['company']['company_tel']; ?>"/> 
        </td>      
    </tr> 
	
</table>
<table class="tb3">
<tr>
        <td width=100></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('companyUser/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>
<?php require(dirname(__FILE__)."/../common/foot.php"); ?>