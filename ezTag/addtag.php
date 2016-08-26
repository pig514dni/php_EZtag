<?php
	$URL=$_POST["URL"];
	$URL=explode("?",$URL)[1];
	// $php="ezTag.php"."?".$URL;
	header("location:ezTag.php?$URL");
	include ("pdo.php");
	$int=0;
	$account=$_SESSION["account"];
	$tagarray=$db->query("select * from `tagtable` where `account`='$account' ")->fetch();
	// echo $tagarray["alltagname"]."<br>";
	$alltagname=$tagarray["alltagname"];
	// echo $alltagname;
	$singletagname=explode('|',$alltagname);
	if ($_POST["tag"]=="") {
		$_SESSION["info"]="欄位不可空白!";
		$int=1;
	}
	for($i=1; $i<count($singletagname);$i++) {
		if($_POST["tag"]==$singletagname[$i]){
			$_SESSION["info"]="tag已標記過!";
			$int=1;
		}
	}
	if($int == 0){
		// // $tagarray=$db->query("select * from `tagtable` where `account`='$a' ")->fetch();
		// // echo "<br>";
		// // echo $tagarray["alltagname"];
		$tagname=$alltagname."|".$_POST["tag"];
		$db->query("update `tagtable` set `alltagname`='$tagname'  where `account`='$account' ");
		// echo '<meta http-equiv=REFRESH CONTENT=1;url=ezTag.php>';
		$_SESSION["info"]="tag新增成功!";	
	}
	
?>