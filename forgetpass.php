<?php
	if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['passmoi'])){
	//	session_start();
		define('IN_ECS', true);
		include_once("inc/#config.php");
		$dbconn = new connectMySQL;
		$dbconn->connect('jxaccount');
		
		$taikhoan=$_POST['username'];
		$taikhoan=$_POST['username'];
		$email=$_POST['email'];
		$matkhaumoi=md5($_POST['passmoi']);
		$sql="SELECT loginName FROM account WHERE loginName='$taikhoan' AND email='$email'";
		$row=mysql_query($sql);
		$num_row=mysql_num_rows($row);
		if ($num_row!=0)
		{
			$sql="UPDATE account SET password_hash='$matkhaumoi' WHERE loginName='$taikhoan'";
			mysql_query($sql)or die ("Lay lai mat khau that bai.");
		//	mysql_close($dbconn);
			echo "<script language=Javascript1.1>alert(\"Bạn đã lấy mật khẩu mới thành công\");</script>";
			echo("<script language='JavaScript'>window.top.location='index.php';</script>"); 
		}
		else
		{
			echo "<script language=Javascript1.1>alert(\"Bạn đã nhập sai tên tài khoản hoặc email.\");</script>";
			echo("<script language='JavaScript'>window.top.location='reset.php';</script>"); 
		}
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Lấy lại mật khẩu - Hệ thống quản lý tài khoản kiếm thế private</title>
		<meta name="description" content="Lấy lại mật khẩu - Kiếm thế private" />
		<meta NAME="keywords" CONTENT="quản lý tài khoản, Lấy lại mật khẩu, kiếm thế private">
		<link href="css/styles.css" media="screen" rel="stylesheet" type="text/css" />  
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>	
		<script type="text/javascript" src="js/laivt_ajax.js"></script>	
        <link rel="SHORTCUT ICON" href="/images/fav.png" />
        <link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
		
	</head>

	<body>
<form method="post" onsubmit="return checkform()" action="">
   <p>&nbsp;</p>
   <table width="496" border="0" align="center">
     <tr>
       <td width="92">Tên tài khoản:</td>
       <td width="188"><label><input type="text" name="username" id="username" /></label></td>
     </tr>
	 <tr>
       <td>Email đăng ký:</td>
       <td><label><input type="text" name="email" id="email" /></label></td>
     </tr>
      <tr>
       <td>Mật khẩu mới:</td>
       <td><label><input type="password" name="passmoi" id="passmoi" /></label></td>
	  </tr>
     <tr>
       <td>&nbsp;</td>
       <td><label><input type="submit" name="Submit" value="Lấy lại mật khẩu"/></label></td>
     </tr>
   </table>
   <p>&nbsp;   </p>
 </form>
</body>