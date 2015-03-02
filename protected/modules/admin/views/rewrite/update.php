<?php require(dirname(__FILE__)."/../common/head.php"); ?>
<?php 
if(!isset($page['info'])){
	$page['info']['rewrite_id']='';
	$page['info']['rewrite_name']='';
	$page['info']['rewrite_ident']='';
	$page['info']['rewrite_example']='';
	$page['info']['true_url']='';
	$page['info']['rewrite_rule']='';
	$page['info']['rewrite_type']=0;
	$page['info']['rewrite_page_rule']='';
}
?>
<div class="main mhead">
    <div class="snav">内容中心 »  
    伪静态管理 </div>
</div>
<div class="main mbody">
<form method="post" action="<?php echo $this->createUrl('rewrite/update'); ?>?p=<?php echo $_GET['p'];?>">
<input type="hidden" id="id" name="id" value="<?php echo $page['info']['rewrite_id']; ?>" />
<table class="tb3">
    <tr>
        <th colspan="2" class="alignleft"><?php echo $page['info']['rewrite_id']?'修改伪静态':'添加伪静态' ?></th>
    </tr> 
    <tr>
        <td  width="100">类型：</td>
        <td  class="alignleft">
        <?php echo vars::input_str(array('node'=>'rewrite_type','type'=>'radio','default'=>$page['info']['rewrite_type'],'name'=>'rewrite_type')); ?>

        </td>      
    </tr> 
    <tr>
        <td  width="100">调用标识：</td>
        <td  class="alignleft">
          <input type="text" class="ipt"  id="rewrite_ident"   name="rewrite_ident" value="<?php echo $page['info']['rewrite_ident']; ?>"/> 
        </td>      
    </tr>
    
    <tr>
        <td  width="100">伪静态名称：</td>
        <td  class="alignleft">
        <input type="text" class="ipt"  id="rewrite_name"   name="rewrite_name" value="<?php echo $page['info']['rewrite_name']; ?>"/> 

        </td>      
    </tr>

    <tr>
        <td  width="100">url原型：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="true_url" style="width:500px;"   name="true_url" value="<?php echo $page['info']['true_url']; ?>"/> 
        </td>      
    </tr>
    <tr>
        <td  width="100">示例：</td>
        <td  class="alignleft">
        <input type="text"  class="ipt"  id="rewrite_example"   name="rewrite_example" value="<?php echo $page['info']['rewrite_example']; ?>"/> 

        </td>      
    </tr>
    <tr>
        <td  width="100">规则：</td>
        <td  class="alignleft">
        <textarea id="rewrite_rule"   name="rewrite_rule" style="width:500px; height:60px;" ><?php echo $page['info']['rewrite_rule']; ?></textarea> <span class="red">*文档或者栏目</span><br />
        <textarea  id="rewrite_page_rule"   name="rewrite_page_rule" style="width:500px; height:60px; margin-top:10px;" ><?php echo $page['info']['rewrite_page_rule']; ?></textarea> <span class="red"> * 包括页码的栏目，如果为空的话则采用上面的页码规则</span>
        
        <br />
       * 栏目和详情页 可用变量 {host}/   {cate_id} 栏目ID  {cname_py} 栏目拼音  {p} 分页   {info_id} 文档ID    {year} 年  {month} 月  {day} 日   
</td>      
    </tr>
    
       
    
    
   <tr>
        <td></td>
        <td  class="alignleft"><input type="submit" class="but" id="subtn" value="确定" /> <input type="button" class="but" value="返回" onclick="window.location='<?php echo $this->createUrl('rewrite/index'); ?>?p=<?php echo $_GET['p'];?>'" /></td>
    </tr>
</table>
</form>
</div>

<?php require(dirname(__FILE__)."/../common/head.php"); ?>
