<?php
	$dir= dirname($_POST["fileurl"]);
	$fileurl= $_POST["fileurl"];
	$deletetag=$_POST["delete"];
	
	if($_POST["tag"]==0){
		header("location:ezTag.php?dir=$dir&action=read&files=$fileurl");
	}elseif ($_POST["tag"]==1) {
		header("location:ezTag.php?action=tag&tag=$deletetag");
	}
	
	
											

	include ("pdo.php");
	// $fileurl=$_POST["fileurl"];
	$account=$_SESSION["account"];
	$file=$_POST["delete"];
	$tmp="";
	$tagarray=$db->query("select * from `tagtable` where `account`='$account' and `url`='$fileurl'  ")->fetch();
	$filetagname=explode("|",$tagarray["tagname"]);
	foreach ($filetagname as $key => $value) {
		if ($key!=0) {
			if ($value==$file) {
				$file="";
			}else{
				$tmp=$tmp."|".$value;
			}
		}
	}

	$db->query("update `tagtable` set `tagname`='$tmp' where `account`='$account' and `url`='$fileurl' ");
	$_SESSION["info"]="tag刪除成功!";
?>