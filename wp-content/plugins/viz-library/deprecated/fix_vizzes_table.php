<pre>
<?php
	
	$db = new SQLite3(__DIR__.'/vizzes.db');

	$cols = "type,
			title, 
			description,
			source,
			timeframe,
			details,
			tags,
			draft";

	$db->exec('DROP TABLE IF EXISTS library');
	$db->exec("CREATE TABLE IF NOT EXISTS library ( [lid] INTEGER PRIMARY KEY ASC, $cols )");	

	$result = $db->query("SELECT * FROM vizzes ");
	
	while($row=$result->fetchArray(SQLITE3_ASSOC)){
		
		$d = json_decode($row['details'],true);
		
		$d["dtable"] = $row["dtable"];
		$d["gtable"] = $row["gtable"];
		$d["dt_join"] = $row["dt_join"];
		$d["gt_join"] = $row["gt_join"];
		
		$details = json_encode($d);
		
		$values = "
			'viz',
			'{$row['title']}',
			'{$row['description']}',
			'{$row['source']}',
			'{$row['timeframe']}',
			'{$details}',
			'{$row['tags']},[Viz]',
			'{$row['draft']}'
			";

		echo $values."\n";

		$insert = "INSERT INTO library ( {$cols} ) VALUES( {$values} )";
		
		$db->exec($insert);
	}

	

?>
</pre>