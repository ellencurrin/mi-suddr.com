<?php

function compareBBs($a,$b){
	$a[0] = min($a[0], $b[0]);
	$a[1] = min($a[1], $b[1]);
	$a[2] = max($a[2], $b[2]);
	$a[3] = max($a[3], $b[3]);
	return $a;	
}

function walk(&$a,$bb=array(2000,2000,-2000,-2000) ){
	foreach($a as $k => $v){
		if(is_array($v)){ $bb = walk($a[$k],$bb); }
		elseif($k==0 && is_numeric($v)){
			$x = round($v,4);
			$y = round($a[$k+1],4);
			$a[$k] = $x;
			$a[$k+1] = $y;
			$c = array($x,$y,$x,$y);
			$bb = compareBBs($bb,$c);
		}
	}
	return $bb;
}

$db = new SQLite3(__DIR__.'/vizzes.db');

if( $_POST["submit"] == "Upload"){
	if( $_POST["name"] !== "" ){	
		$content = file_get_contents( $_FILES["file"]["tmp_name"] );
		$geojson = json_decode($content, true);

		if( $geojson !== null ){

			$props = implode(";", array_keys($geojson["features"][0]["properties"]) );
			$name = $_POST['name'];

			$db->exec("CREATE TABLE IF NOT EXISTS resources (id INTEGER PRIMARY KEY ASC, name UNIQUE, type, fields )");
			 
			$insert = "INSERT INTO resources (name,type,fields) VALUES( '{$name}','json','{$props}' )"; 
			$result = $db->exec($insert);

			if($result){								
			
				$bbs = array(2000,2000,-2000,-2000);
				
				foreach($geojson["features"] as $f => $feature){
					$b = $geojson["features"][$f]["bbox"] = walk($feature["geometry"]["coordinates"]);
					$bbs = compareBBs($bbs,$b);
					}
			
				$geojson["bbox"] = $bbs;

				$file = __DIR__."/geojson/".$_POST['name'].".json";
				$contents = json_encode($geojson);
			
				file_put_contents($file,$contents);
			
				echo "</pre>";
				
				echo "<div class='success'>Geography Added!</div>";	
			}
			else{
				echo "<div class='err'>Geography already exists</div>";
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
	$db->exec("DELETE FROM resources WHERE id = {$_POST['id']} ");
	$file = __DIR__."/geojson/".$_POST['name'].".json";
	unlink($file);
	}

$result = $db->query("SELECT id, name FROM resources WHERE type = 'json'");
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	$n = $row["name"];
	$id = $row['id'];
	echo "<form class='row' method='post'>";
	echo "<input type='hidden' name='id' value='{$id}' />";
	echo "<input type='hidden' name='name' value='{$n}' />$n";	
	echo "<input class='delete' type='submit' name='delete' value='Delete' />";
	echo "</form>";
	}
?>
</div>