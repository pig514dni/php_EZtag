<?php
	$URL=$_POST["URL"];
	$URL=explode("?",$URL)[1];
	header("location:ezTag.php?$URL");
	include ("pdo.php");

	$account=$_SESSION["account"];
	$tagarray=$db->query("select * from `tagtable` where `account`='$account' ")->fetch();
	$tagallarray=$db->query("select * from `tagtable` where `account`='$account' ")->fetchAll();
	$alltagname=explode("|",$tagarray["alltagname"]);
	$deletetag=$_POST["deletetag"];
	$tmp="";
	
	$int1=0;
	$int2=0;  
	echo $deletetag;
	echo "<br>";
	echo "<br>";

	


	if($deletetag==""){
		$_SESSION["info"]="欄位不可空白";
		$int2 =1;
	}
	
		foreach ($alltagname as $key => $value) {
			if($key!=0){
				if($value == $deletetag ){
					$int1=1;
				}
			}
		}
	
	if($int1!=1&&$int2!=1){
		$_SESSION["info"]="無此欄位可刪除";
	}
	if($int1=1){
		for ($i=0;$i<count($tagallarray);$i++) { 
		$tmp2="";
		// echo $i.":".$tagallarray[$i]["filename"];
		$filename=$tagallarray[$i]["filename"];
		echo "tagallarray".$i.":".$filename."<br>";
		
		// $d=$db->query("select * from `tagtable` where `account`='$account' and `filename`='$filename' ")->fetch();
		$tagname=$tagallarray[$i]["tagname"];
		$tagname=explode("|",$tagname);

		foreach ($tagname as $key => $value) {
			
			if($key!=0){
				echo "value".$i.":".$value."<br>";
				echo "<br>";
				if ($value!=$deletetag) {
					$tmp2=$tmp2."|".$value;
				}
			}
			$db->query("update `tagtable` set `tagname`='$tmp2' where `account`='$account' and `filename`='$filename'");
		}
	}
		foreach ($alltagname as $key => $value) {
			if($key!=0){
				if($value == $deletetag ){
					$deletetag="";
				}else{
					$tmp=$tmp."|".$value;
				}
			}
		}
		$db->query("update `tagtable` set `alltagname`='$tmp' where `account`='$account' ");
		$_SESSION["info"]="tag已刪除!";
	}
?>