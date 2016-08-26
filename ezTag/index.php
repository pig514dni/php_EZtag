<?php
session_start();
?>
<!-- 設定網頁編碼為UTF-8 -->
<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
<html>
	<head>
   		<meta charset="utf-8">
	    <link rel="stylesheet" href="main.css">
	    <script src=""></script>
	    <title>ezTag</title>
	</head>
 	<body style="height:100%" >
		<form name="form" method="post" action="connect.php">
			帳號：<input type="text" name="name" /> <br>
			密碼：<input type="password" name="pw" /> <br>
		<input type="submit" name="button" value="登入" />
		<a href="register.php">申請帳號</a>
		</form>
	</body>
</html>	