<?php
	$dir= dirname($_POST["fileurl"]);
	$url= $_POST["fileurl"];
	header("location:ezTag.php?dir=$dir&action=read&files=$url");
	include ("pdo.php");
	$int=0;
	$int2=0;
	$account=$_SESSION["account"];
	// echo $_POST["fileurl"];
	// echo "<br>";
	// echo $url;
	if($_POST["fileaddtag"]==""){
		$_SESSION["info"]="欄位不可空白!";
		
		$int2=2;
	}
	$account=$_SESSION["account"];
	$alltagarray=$db->query("select * from `tagtable` where `account`='$account'  ")->fetch();
	$tagarray=$db->query("select * from `tagtable` where `account`='$account' and `url`='$url'  ")->fetch();
	// echo $tagarray["alltagname"]."<br>";
	$alltagname=$alltagarray["alltagname"];
	$tagname=$tagarray["tagname"];
	// echo $alltagname;
	$singlealltagname=explode('|',$alltagname);
	$singletagname=explode('|',$tagname);

	// echo $_SESSION["account"];
	// print_r($alltagname);
// `account`='$account' 

	if ($int==0&&$int2==0) {
		for($i=1; $i<count($singlealltagname);$i++) {
			if ($_POST["fileaddtag"]==$singlealltagname[$i]) {
				$int=1;
			}
		}
	}
	if ($int!=1&&$int2==0) {
		$_SESSION["info"]="無此tag可標記!";
	}

	if($int==1&&$int2==0){

		for($i=1; $i<count($singletagname);$i++) {
			if($_POST["fileaddtag"]==$singletagname[$i]){
				$_SESSION["info"]="tag已標記過!";
				$int=2;
			}
		}
	}	
	if ($int==1&&$int2==0) {
		$addtag=$tagname."|".$_POST["fileaddtag"];
		if ($tagarray=="") {
			$_new=array(
				"account"=>$account,
				"filename"=>basename($url),
				"url"=>$url,
				"tagname"=>$addtag,
				// "alltagname"=>$alltagname
				);
			$db->prepare("insert into tagtable(account,filename,url,tagname) 
				values(:account,:filename,:url,:tagname)")->execute($_new);
			$_SESSION["info"]="tag新增成功!";
			// $db->query("update `tagtable` set `tagname`='$addtag',`url`='$url'  where `account`='$account' ");
		}else{
		$db->query("update `tagtable` set `tagname`='$addtag'  where `account`='$account' and `url`='$url'");
		$_SESSION["info"]="tag標記成功!";
		}
		
	}

?>