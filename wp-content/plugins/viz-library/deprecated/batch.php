<?php

$db = new SQLite3(__DIR__.'/vizzes.db');

if( $_POST["submit"] == "Upload"){
	$handle = fopen($_FILES["file"]["tmp_name"], "r");
	if ( $handle !== FALSE && $handle !== null && $_FILES["file"]["type"] == "text/csv" ) {
		$i = 0;
		$cols = "";
	    while (($data = fgetcsv($handle,0, ",")) !== FALSE) {	
			foreach($data as $k=>$v){
				$data[$k] = trim($v);
			}
			$row = "'".implode("','",$data)."'";
			if($i==0){		
				$db->exec("BEGIN");
				$cols = $row.",draft ";
				$i++;
			}else{
				$db->exec("INSERT INTO vizzes ({$cols}) SELECT {$row},1;");					
			}
		}
		$db->exec("COMMIT");
		echo "<div class='success'>Data Table Added!</div>";	
	}
	else{
		echo "<div class='err'>Invalid or Missing File</div>";
	}
}

?>

<form class='vizForm' method='post' enctype="multipart/form-data">
	<p style='font-weight:bold; color:#6F6F6F'>Upload multiple vizzes at once.</p>
	<table style="border-collapse:collapse; border:0px;">

		<tr>
			<td class="l">FILE</td>
			<td class="n">
				<input id='file' name='file' type='file'>
			</td>
		</tr>
		
		<tr>
			<td class="l"></td>
			<td class="n">
				<input id="submit" name='submit' class='submit' type='submit' value='Upload'>
			</td>
		</tr>
		
	</table>		
</form>