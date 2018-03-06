<?php

header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename={$_POST['title']}.csv");

if($_POST["title"]){
	$rows = explode(";",$_POST['content']);
	foreach($rows as $r){
		echo $r;
		echo "\r\n";
	}
}


?>