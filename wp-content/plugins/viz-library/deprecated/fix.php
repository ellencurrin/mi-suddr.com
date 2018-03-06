<?php
	$db = new SQLite3(__DIR__.'/vizzes.db');


	// $result = $db->query("SELECT name, sql FROM sqlite_master WHERE type = 'table' AND name LIKE 'GEO_%' OR name LIKE 'DATA_%' ;");
	// $pattern = '/\(.*\)/';
	// $subject = $row["sql"];
	// preg_match($pattern , $subject, $matches);
	// $columns[$row["name"]] = str_getcsv(trim(substr($matches[0],1,-1)),",","'");

	// $db->exec("BEGIN");
	// foreach($columns as $t=>$cols){
	// 	$c = implode(";",$cols);
	// 	echo $t."<br>";
	// 	echo $c."<br>";
	// 	$db->exec("INSERT INTO resources (name,type,fields) SELECT '{$t}','data','{$c}';");
	// }
	// $db->exec("COMMIT");

	
	// $db->exec("BEGIN");
	// foreach(){
	// 	$values = "
	// 		title = '{$_POST['title']}',
	// 		description = '{$_POST['description']}',
	// 		source = '{$_POST['source']}',
	// 		timeframe = '{$_POST['timeframe']}',
	// 		dtable = '".trim($_POST['dtable'])."',
	// 		gtable = '".trim($_POST['gtable'])."',
	// 		dt_join = '".trim(str_replace($b,"",$_POST['dt_join']))."',
	// 		gt_join = '".trim(str_replace($b,"",$_POST['gt_join']))."',
	// 		details = '{$d}',
	// 		tags = '{$tags}',
	// 		draft = '{$draft}'
	// 		";
	// 	$insert = "UPDATE vizzes SET $values WHERE vid = {$_GET["vid"]}";
	// 	$db->exec($insert);
	// 	}
	// $db->exec("COMMIT");

	

?>