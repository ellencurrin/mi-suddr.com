<?php

$db = new SQLite3(__DIR__.'/vizzes.db');

if( $_POST["submit"] == "Upload"){
	if( $_POST["name"] !== "" ){	
		$content = file_get_contents( $_FILES["file"]["tmp_name"] );
		$geojson = json_decode($content, true);

		if( $geojson !== null ){

			$features = $geojson["features"];

			require("functions.php");

			$xMin = $features[0]["geometry"]["coordinates"][0][0][0]; 
			$yMin = $features[0]["geometry"]["coordinates"][0][0][1]; 
			$xMax = $features[0]["geometry"]["coordinates"][0][0][0];
			$yMax = $features[0]["geometry"]["coordinates"][0][0][1]; 

			foreach($features as $feature){
				foreach($feature["geometry"]["coordinates"] as $c){
					foreach($c as $q){
						if($q[0] < $xMin){ $xMin = $q[0]; }
						if($q[1] < $yMin){ $yMin = $q[1]; }
						if($q[0] > $xMax){ $xMax = $q[0]; }
						if($q[1] > $yMax){ $yMax = $q[1]; }																		
					}
				}
			}

			// $nex = round($xMin,4);
			// $ney = round($yMax,4);
			// $swx = round($xMax,4);
			// $swy = round($yMin,4);
					
			$xMin = lng( $xMin, 500 );
			$yMin = lat( $yMin, 500 );
			$xMax = lng( $xMax, 500 );
			$yMax = lat( $yMax, 500 );
			$ratio = 500 / ( $xMax - $xMin ) ;
			$height = abs($yMax - $yMin) * $ratio;

			// $columns = "'path',";
			$props = implode("','", array_keys($features[0]["properties"]) );
			$columns = "'coords','nex','ney','swx','swy','$props'";

			$name = "GEO_".str_replace(" ","_",$_POST['name']);
			
			$result = $db->exec("CREATE TABLE {$name} ( {$columns} ) ");
			
 			if($result){
				$db->exec("BEGIN");

				foreach($features as $feature){
					$props =  implode("','", $feature["properties"]);					
					$coords = geojson($feature["geometry"]["coordinates"]);
					// $coords= makePathArray($feature["geometry"]["coordinates"],$xMin, $yMax, $ratio);
					
					$insert = "INSERT INTO $name ($columns) SELECT $coords,'$props'";
					$db->exec($insert);
					}
			
				$db->exec("COMMIT");
			
				echo "<div class='success'>Geography Added!</div>";	
 				}
			else{
				echo "<div class='err'>Name Already Exists</div>";
				}						
			}
		else{
			echo "<div class='err'>Invalid or Missing File</div>";
			}
		}
	else{
		echo "<div class='err'>Please Give the Upload a Name</div>";
		}
}

?>

<form class='vizForm' method='post' enctype="multipart/form-data">
	<p style='font-weight:bold; color:#6F6F6F'>Create additonal geography tables from .GEOJSON files.</p>

	<table style="border-collapse:collapse; border:0px;">
		<tr>
			<td class="l">NAME</td>
			<td class="n">
				<input id='name' name='name' type='text' style='width:300px'>
			</td>
		</tr>

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

<div style="margin-top:15px; border-top:2px solid white;">
<?php
if( $_POST["delete"] == "Delete" ){
	
	}

$result = $db->query("SELECT name FROM sqlite_master WHERE type = 'table' AND name LIKE 'GEO_%' ");
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	$n = $row["name"];
	echo "<form class='row' method='post'>";
	echo "<input type='hidden' name='table' value='{$n}' />{$n}";
	echo "<input class='delete' type='submit' name='delete' value='Delete' />";
	echo "</form>";
	}
?>
</div>