<?php
if(!defined('InEmpireBak'))
{
	exit();
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>菜单</title>
<link href="images/css.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0472BC">
 <tr> 
    <td height="30"><div align="center"><font color="#FFFFFF"><strong>操作菜单</strong></font></div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="main.php" target="ebakmain">控制面板首页</a></div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="SetDb.php" target="ebakmain">参数设置</a></div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="ChangeDb.php" target="ebakmain">备份数据</a></div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="ListSetbak.php" target="ebakmain">管理备份设置</a></div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"> <div align="center"><a href="ReData.php" target="ebakmain">恢复数据</a></div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="ChangePath.php" target="ebakmain">管理备份目录</a></div></td>
  </tr>
  <tr>
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="RepFiletext.php" target="ebakmain">替换目录文件</a></div></td>
  </tr>
  <tr> 
    <td height="30" bgcolor="#FFFFFF" onMouseOut="this.style.backgroundColor='#ffffff'" onMouseOver="this.style.backgroundColor='#DBEAF5'"><div align="center"><a href="DoSql.php" target="ebakmain">执行SQL语句</a></div></td>
  </tr>

</table>
</body>
</html>