<?php

if( $_POST["submit"] == "Delete" ){
	$t = $_POST['tagname'];
	$db->exec("DELETE FROM tags WHERE name = '$t' ");
	}

$db = new SQLite3(__DIR__.'/vizzes.db');
#$db->exec("DROP TABLE IF EXISTS tags");
$db->exec("CREATE TABLE IF NOT EXISTS tags (id INTEGER PRIMARY KEY ASC, name UNIQUE, type )");

if( $_POST["submit"] == "Save Tag" ){
	$tagname = $_POST["tagName"];
	$type = $_POST["type"];
	if( $tagname !== "" && $type !== ""){
								
		$insert = "INSERT INTO tags (name,type) VALUES( '{$tagname}', '{$type}' )"; 
		$result = $db->exec($insert);
		if($result){
			echo "<div class='success'>Tag Added to List!</div>";
			}
		else{
			echo "<div class='err'>Invalid Tag or Missing Information</div>";
			}
		
		}
	else{
		echo "<div class='err'>Invalid Tag or Missing Information</div>";
		}
	}

?>

<datalist id="tagtypes">
<?php
$result = $db->query("SELECT DISTINCT type FROM tags");
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	$t = $row["type"];
	echo "<option value='$t' />";
	}
?>
</datalist>

<form class='vizForm' method='post' enctype="multipart/form-data">
	<p style='font-weight:bold; color:#6F6F6F'>Add or Remove Tags</p>

	<table style="border-collapse:collapse; border:0px;">
		<tr>
			<td class="l">TAG TYPE</td>
			<td class="n">
				<input list='tagtypes' id='type' name='type' type='text' style='width:300px'>
			</td>
		</tr>

		<tr>
			<td class="l">TAG NAME</td>
			<td class="n">
				<input id='tagName' name='tagName' type='text' style='width:300px'>
			</td>
		</tr>
		
		<tr>
			<td class="l"></td>
			<td class="n">
				<input id="submit" name='submit' class='submit' type='submit' value='Save Tag'>
			</td>
		</tr>
		
	</table>		
</form>

<div style="margin-top:15px; border-top:2px solid white;">
<?php

$result = $db->query("SELECT * FROM tags;");
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	$n = $row["name"];
	$t = $row["type"];
	echo "<form class='row' method='post'>";
	echo "<input type='hidden' name='tagname' value='{$n}' />";
	echo "<div style='margin-right:20px; float:left; width:150px; font-weight:bold;'>$n</div>$t";
	echo "<input class='delete' type='submit' name='submit' value='Delete' />";
	echo "</form>";
	}
$db->close();
?>
</div>