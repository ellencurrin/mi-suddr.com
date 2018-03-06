<?php
if( $_POST["delete"] == "Delete" ){	
	if($_POST["type"] == "doc"){
		$e = $db->query("SELECT details FROM library WHERE lid = ".$_POST["lid"])->fetchArray(SQLITE3_ASSOC);
		$e["details"] = json_decode($e["details"],true);
		$name = __DIR__."/docs/".$e["details"]["url"];
		$d = unlink($name);
		if($d){
			$db->exec("DELETE FROM library WHERE lid = {$_POST['lid']} ");
		}
	}
	else{
		$db->exec("DELETE FROM library WHERE lid = {$_POST['lid']} ");
	}
}

$result = $db->query("SELECT lid, type, title, draft FROM library ");
$i = 0;
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	if($i == 0){
		echo "<div style='height:14px; margin-top:15px; padding:5px'>";
		echo "<div style='float:left; line-height:14px; height:14px; width:50px;'>ID</div>";
		echo "<div style='float:left; line-height:14px; height:14px; width:50px;'>TYPE</div>";
		echo "<div style='float:left; line-height:14px; height:14px; width:30px;'>TITLE</div>";
		echo "</div>";
		echo "<div style='margin-top:5px; border-top:2px solid white;'>";
		$i++;
		}

	$lid = $row["lid"];
	$title = $row["title"];
	$type = $row["type"];

	echo "<form class='row' method='post'>";
	echo "<input type='hidden' name='lid' value='{$lid}' />";
	echo "<input type='hidden' name='type' value='{$type}' />";	
	echo "<div style='float:left; width:50px; font-weight:400;'>{$lid}</div>";
	echo "<div style='float:left; width:50px; font-weight:400; text-transform:capitalize;'>{$type}</div>";
	echo "<div style='font-weight:bold; float:left;'>{$title}</div>";
	echo "<input class='delete' type='submit' name='delete' value='Delete' />";

	if($type == "viz"){
		echo "<a href='{$base}&vp=viz&action=add&lid={$lid}' style='float:right; margin-right:20px;'>Edit</a>";
		}
	else{
		echo "<a href='{$base}&vp=docs&action=add&lid={$lid}' style='float:right; margin-right:20px;'>Edit</a>";
		}
		
	if( $row['draft']===1 ){
		echo '<div style="float:right; font-size:14px; font-weight:bold; margin-right:20px;">DRAFT</div>';
		}
	echo "</form>";
	}

echo "</div>";

?>
