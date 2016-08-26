<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("pdo.php");

$name = $_POST['name'];
$pw = $_POST['pw'];
$pw2 = $_POST['pw2'];

//判斷帳號密碼是否為空值
//確認密碼輸入的正確性
$d=$db->query("select * from `members` where name = '$name'")->fetch();
if ($d["name"]==$name) {
        echo '帳號重複，請洽管理員';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}
else if($name != null && $pw != null && $pw2 != null && $pw == $pw2)
{
        //新增資料進資料庫語法
        $_POST=array(
             "name"=>$name,
             "password"=>$pw,
             );
        $_tag=array(
             "name"=>$name,
             );
        $db->prepare("insert into members(name, password) values (:name,:password)")->execute($_POST);
        $db->prepare("insert into tagtable(account) values (:name)")->execute($_tag);
        echo '新增帳號成功!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';

        // if(mysql_query($sql))
        // {
        //         echo '新增成功!';
        //         echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        // }
        // else
        // {
        //         echo '新增失敗!';
        //         echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        // }
}
else
{
        echo '帳號、密碼不可為空值，密碼須一致';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}
?>