<?php

if($_GET["county"]){
	$county = $_GET["county"];
	$db = new SQLite3('../vizzes.db');

	$v = $db->query("SELECT * FROM DATA_demographics WHERE County = '{$county}'")->fetchArray(SQLITE3_ASSOC);
	header('Content-Type: application/json');
	echo json_encode($v);
	
}else{
	echo "error";
}

?>