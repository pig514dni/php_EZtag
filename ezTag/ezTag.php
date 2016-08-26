<?php
	session_start();
	include ("pdo.php");
	$account=$_SESSION["account"];
	
	$tagarray=$db->query("select * from `tagtable` where `account`='$account' ")->fetch();
	$accountallarray=$db->query("select * from `tagtable` where `account`='$account'")->fetchAll();
	// echo $tagarray["alltagname"]."<br>";
	$alltagname=$tagarray["alltagname"];
	// echo $alltagname;
	$singletagname=explode('|',$alltagname);

	// echo print_r($singletagname);
	// $data=file_get_contents("data.txt");
	// $person=explode("name1".".tag|", $data)[1];
	// $personCut=explode("]\n[",$person)[0];
	// $tagOfPerson=explode(";",explode(']',$personCut)[0]);
	// $filterByFile=explode("[",$personCut);
	// $filterByFile=str_replace(']', '', $filterByFile[1]);
	// $filterByFile=explode(',',$filterByFile);
	// echo '$data:'.$data;
	// echo "<br>";
	// echo '<br>$person:';print_r($person);
	// echo "<br>";
	// echo '<br>$personCut:';print_r($personCut);
	// echo "<br>";
	// echo '<br>$tagOfPerson:';print_r($tagOfPerson);// All Tags
	// echo "<br>";
	// echo '<br>$filterByFile:';print_r($filterByFile);
	// echo "<br>";
	$filenames = array();
	$tags = array();
	$filenameAndTag = array();
	$tagAndFilename = array();
	for ($i=0; $i < count($filterByFile); $i++) { 
		$filename=explode("|",$filterByFile[$i])[0];
		array_push($filenames,$filename);// File Name
		// echo $filename;
		for ($j=0; $j < count(explode(";",explode("|",$filterByFile[$i])[1])); $j++) { 
			$tag="#".explode(";",explode("|",$filterByFile[$i])[1])[$j];// Tag			
			// echo $tag;
			$filenameAndTag[$filename]=$filenameAndTag[$filename].$tag;
			
			$tagAndFilename[$tag]=$tagAndFilename[$tag].'|'.$filename;

		}
		// echo "<br>";
	}
	// echo '<br>$tagOfPerson:';print_r($tagOfPerson);
	// echo '<br>$filenames: ';print_r($filenames);
	// echo "<br>";
	// echo '<br>$filenameAndTag: ';print_r($filenameAndTag);
	// echo "<br>";
	if ($_GET["action"]=="delete") {
		if (is_dir($_GET["file"])==true) {
			rmdir($_GET["file"]);
		}else{
		unlink($_GET["file"]);
		}
	}
	if ($_GET["action"]=="create_dir") {
		mkdir($_POST["dirname"]);
	}
	if ($_GET["action"]=="read") {
		global $name;
		 $name=basename($_GET["files"]);
	}
		if ($_GET["action"]=="tag") {
		global $tagfilenamearray;
		global $tagname;
		global $tagfilename;
		$tagfilename=$_GET["files"];
		 $tagname=$_GET["tag"];
		 $tagfilenamearray=explode("|",$tagAndFilename["#".$tagname]);
	}
?>	

<!DOCTYPE html>

<html>
 
	<head>
   		<meta charset="utf-8">
	    <link rel="stylesheet" href="main.css">
	    <script src=""></script>
	    <title>Tag My File</title>
	    <?php if($_SESSION["info"]!=""){?>
		<script >
			 
			window.alert("<?php echo $_SESSION["info"]; ?>");
		</script>
		<?php
			$_SESSION["info"]="";
		?>
		<?php } ?>
	</head>
 	<body style="height:100%" >
		<span id="indexIcon">
			<!-- #ezTag -->

			<a href="http://localhost:8888/第四組-ezTag/ezTag.php" id="ezTag">ezTag</a>
		</span>
		<span id="searchBar">
			<form action="?" method="get" enctype="multipart/form-data">
				<input type="text" name="search">
				<input type="submit" value="search">
			</form>

		</span>
		<span id="addtag" >
			<form action="addtag.php" method="post" enctype="multipart/form-data">
				<?php
				$URL=$_SERVER['REQUEST_URI'];
				
				echo "<input type='hidden' name='URL' value=".$URL.">";
				echo "<input type='text' name='tag'>";
				echo "<input type='submit' value='add'>";
				?>
				<!-- <input type="hidden" name="URL">
				<input type="text" name="tag">
				<input type="submit" value="add"> -->
			</form>
		</span>
		<span id="deletetag" >
			<form action="deletetag.php" method="post" enctype="multipart/form-data">
				<?php
				$URL=$_SERVER['REQUEST_URI'];
				
				echo "<input type='hidden' name='URL' value=".$URL.">";
				echo "<input type='text' name='deletetag'>";
				echo "<input type='submit' value='delete'>";
				?>
			</form>
		</span>
		<span id="account" >
		<?php

				echo "Hi:".$_SESSION["account"];
		?>
		</span>
		<span id="logout">

			<form action="logout.php">
				<input type="submit" value="logout">
			</form>
		</span>
		<br>
		<hr>

		<div id="scrollBar">
			<p style="width:250%">
				<?php
					$URL=$_SERVER['REQUEST_URI'];
					$URL=explode("?",$URL)[1];
					if($_GET["search"]!=""){
						$value=$_GET["search"];
						echo "<fieldset class='tags'><a href='?action=tag&tag=$value'>#".$value.'</a></fieldset> ';
					}else{
						foreach ($singletagname as $key => $value) {
							if($key!=0){
							echo "<fieldset class='tags'><a href='?action=tag&tag=$value'>#".$value.'</a></fieldset> ';
							}
						}
					}
						
				?>
			</p>
		</div>

		<hr>

	<!-- <div style="border:1px red solid;height:500px"> -->
		<div style="height:500px">
		<div id="leftList">
		<?php
			// if ($_GET["dir"]==false) {
				// echo "當前路徑:"./."<br>";
			// }else{
				echo "當前路徑:".$_GET["dir"]."<br>";
			// }
			if($_GET["dir"]!="/"&&$_GET["dir"]!=""){
				echo "<a href='?dir=".dirname($_GET["dir"])."'>Previous Page</a>";
			}
			foreach(glob($_GET["dir"]."/*") as $key => $value){
				if(is_dir($value)==true){
				echo "<li>
					<span>".basename($value)."</span>";
				if(is_dir($value)==true){
					if($_GET["dir"]=="/"){
						$v=explode("/",$value)[2];
						echo "<a href='?dir=/".$v."'>[GO]</a>";
						
					}else{
						echo "<a href='?dir=$value'>[GO]</a>";
					}
					
				}
				echo	"<a href='?action=delete&file=".$value."'>[Delete]</a>
					</li>";
				}
			}
		?>
		</div>
		<div id="rightList">
			<?php 
			if ($_GET["tag"]) {
				echo "已標記".$tagname."的檔案如下:<br><br>";
							
				foreach ($accountallarray as $key => $value) {
									
					$f=explode("|",$value["tagname"]);
					
					foreach ($f as $key1 => $value1) {
						if($key1!=0){
							if($value1==$_GET["tag"]){
								echo "<li>";
								echo $value["filename"];
								$u=$value["url"];
								echo "<a href='?action=tag&files=".$u."&tag=".$tagname."'>[Read]</a>";
								echo "</li>";
							}
						}	
					}
			 	 }
			}else{
			foreach(glob($_GET["dir"]."/*") as $key => $value){
				if(is_dir($value)!=true){
					if (strlen(basename($value))>15) {
						$shortValue=substr(basename($value),0,15);
						$tmp="...";
					}else{
						$shortValue=basename($value);	
						$tmp="";
					}
				echo "<li>
					<span>".$shortValue.$tmp."</span>";
					$longValue=dirname($value);
					echo "<a href='?dir=$longValue&action=read&files=".$value."'>[Read]</a>";
					echo	"<a href='?dir=$longValue&action=delete&files=".$value."'>[Delete]</a>
					</li>";
				}
			}
		}	
		?>
		</div>
		<div id="preview" style="overflow:scroll">
			<!-- <img src="1.jpg" style="width:100%;height:300px"> -->
		<?php
					
					if ($_GET["tag"]) {
						$subscript = explode(".",$_GET["files"]);
						if ($subscript[1]=="jpg") {
							echo "<img src='readImage.php?files=".$_GET["files"]."' style='width:100%;height:300px'>";
						}else{
							// $content=file_get_contents(basename($_GET["files"]));
							// echo $content;
							echo file_get_contents($_GET["files"])."<br>";
							}
					}else{
						$subscript = explode(".",$_GET["files"]);
						if ($subscript[1]=="jpg") {
							echo "<img src='readImage.php?files=".$_GET["files"]."' style='width:100%;height:300px'>";
						}else{
							// $content=file_get_contents(basename($_GET["files"]));
							// echo $content;
							echo file_get_contents($_GET["files"])."<br>";
							}	
					}						
			?>
		</div>
		<hr style="width:47%;float:left">
			<div>
				
				<?php
					if ($_GET["action"]=="read") {
						$fileurl=$_GET["files"];
						echo "<form action='fileaddtag.php' method='post'>";
						echo "<input type='hidden' name='fileurl' value='$fileurl'>";
						echo "<input  name='fileaddtag' type='text'>";
						echo "<input type='submit' value='addtag'>";
						echo "</form>";
						// echo "<br>";
						$tagarray=$db->query("select * from `tagtable` where `account`='$account' and `url`='$fileurl'  ")->fetch();
						// print_r($tagarray["tagname"]);
						$filetagname=explode("|",$tagarray["tagname"]);
						echo "<div class='e'>已標記的tag:</div>";
						// echo "已標記的tag:";
						foreach ($filetagname as $key => $value) {
							if ($key!=0) {
								echo "<form action='deletefiletag.php' method='post' class='deletereadtag'>";
								echo "<input type='hidden' name='tag' value=0>";
								echo "<input type='hidden' name='delete' value='".$value."'>";
								echo "<input type='hidden' name='fileurl' value='".$fileurl."'>";  
								echo "<input type='submit' value='".$value."'>";
								echo "</form>";
							}
							
						}
						echo "<div class='clear'></div>";
					}
					if($_GET["action"]=="tag"){
						$fileurl=$_GET["files"];
						$tagarray=$db->query("select * from `tagtable` where `account`='$account' and `url`='$fileurl'  ")->fetch();
						// print_r($tagarray["tagname"]);
						$filetagname=explode("|",$tagarray["tagname"]);

						echo "<div class='e'>已標記的tag:</div>";
						// echo "已標記的tag:";
						foreach ($filetagname as $key => $value) {
							if ($key!=0) {
								echo "<form action='deletefiletag.php' method='post' class='deletereadtag'>";
								echo "<input type='hidden' name='tag' value=1>";
								echo "<input type='hidden' name='delete' value='".$value."'>";
								echo "<input type='hidden' name='fileurl' value='".$fileurl."'>";  
								echo "<input type='submit' value='".$value."'>";
								// echo "<a href='deletetag.php'>$value</a>";
								// echo $value;
								// echo "\n";
								echo "</form>";
							}
							
						}
						echo "<div class='clear'></div>";

					}

				?>
			</div>
	</div>
	
 	</body>


</html> 