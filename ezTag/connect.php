<?php 
session_start(); 
// <!--上方語法為啟用session，此語法要放在網頁最前方-->
// <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
$name = $_POST['name'];
$pw = $_POST['pw'];
?>
<?php
//連接資料庫
//只要此頁面上有用到連接MySQL就要include它
// include("mysql_connect.inc.php");
include("pdo.php");

//搜尋資料庫資料
$d=$db->query("select * from `members` where name = '$name'")->fetch();


//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員

if($name != null && $pw != null && $d["name"] == $name && $d["password"] == $pw)
{
        //將帳號寫入session，方便驗證使用者身份
        $_SESSION["account"] = $name;
        echo '登入成功!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=ezTag.php>';
}
else
{		
		// echo $d["name"]."<br>";
		// echo $d["password"]."<br>";
        echo '登入失敗!';
        echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
}
?>