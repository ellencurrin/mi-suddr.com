<?php
if( $_POST["delete"] == "Delete" ){
	$db->exec("DELETE FROM vizzes WHERE vid = {$_POST['vid']} ");
	}

$result = $db->query("SELECT vid, title, draft FROM vizzes ");
$i = 0;
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	if($i == 0){
		echo "<div style='height:14px; margin-top:15px; padding:5px'>";
		echo "<div style='float:left; line-height:14px; height:14px; width:30px;'>ID</div>";
		echo "<div style='float:left; line-height:14px; height:14px; width:30px;'>TITLE</div>";
		echo "</div>";
		echo "<div style='margin-top:5px; border-top:2px solid white;'>";
		$i++;
		}
	$vid = $row["vid"];

	$title = $row["title"];
	echo "<form class='row' method='post'>";
	echo "<input type='hidden' name='vid' value='{$vid}' />";
	echo "<div style='float:left; width:30px; font-weight:bold;'>{$vid}</div>";
	echo "<span style='font-weight:bold;'>{$title}</span>";
	echo "<input class='delete' type='submit' name='delete' value='Delete' />";
	echo "<a href='{$base}&vp=viz&action=add&vid={$vid}' style='float:right; margin-right:20px;'>Edit</a>";
		if( $row['draft']===1 ){
			echo '<div style="float:right; font-size:14px; font-weight:bold; margin-right:20px;">DRAFT</div>';
		}
	echo "</form>";
	}
if($i == 0){
	echo "<a href='{$base}&vp=viz&action=add' 
		style='float:left; font-size:30px; font-weight:bold; text-decoration:none; line-height:120px; padding:0px 15px; border:3px dashed lightgray; margin:20px 0px 10px;'>
		+ Add New Viz</a>";
	}
else{echo "</div>";}

?>