<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	$db=new pdo("mysql:host=localhost;port=8889","root","root");
	$db->query("set names 'utf8'");
	$db->query("use mydb");
	// $db->query("insert into testtable(title,url,description) 
	// 	values('$_POST[title]','$_POST[url]','$_POST[description]')");


//===========新增=========	
//=============有索引======
	// $_POST=array(
	// 	"title"=>"111",
	// 	"url"=>"222",
	// 	"description"=>"333"
	// 	);
	// $db->prepare("insert into testtable(title,url,description) 
	// 	values(:title,:url,:description)")->execute($_POST);
//=============無索引======
	// $_POST=array("111","222","aaa");
	// $db->prepare("insert into testtable(title,url,description) 
	// 	values(?,?,?)")->execute($_POST);


//===========刪除=========	
	// $db->query("delete from `testtable` where `id` in('13','14')");
	// $db->query("delete from `testtable` where `title` like '%a%'  ");
	// $db->query("delete from `testtable` where `id` between('10','11')");

//===========更新=========	
//=============有索引======
	// $db->query("update `testtable` set `title`='Google',`url`='https://www.google.com.tw/'  where `id`='12'");

//=============無索引======
	// $_POST=array(
	// 	"aa"=>"Yahoo",
	// 	"url"=>"https://tw.yahoo.com/"
	// );

	// $db->prepare("update `testtable` set `title`=:aa,`url`=:url  where `id`='10'")->execute($_POST);
//==========搜尋===========================
// print_r($d);
	// $name="testuser";
	// $d=$db->query("select password from `members` where name = '$name'")->fetchAll();
	// $d=$db->query("select * from `members` where name = '$name'");
	// echo $d["password"];
	// print_r($d);
	// foreach ($d as $key => $value) {
	// 	// echo print_r($value)."<br>";
	// 	echo $value."<br>";
	// }

?>