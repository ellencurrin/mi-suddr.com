<pre>
<?php

function insert($array,$keys,$table){
	$cols = array();
	$vals = array();
	foreach($array as $k=>$v){
		if( in_array($k,$keys) ){
			array_push($cols,$k);
			array_push($vals,$v);
			}
		}
	$cols= implode("','",$cols); 
	$vals= implode("','",$vals);
	return "INSERT INTO '{$table}' ('{$cols}') SELECT '{$vals}';";
}

function csv_to_array($x){
	$i = 0;
	$header = array();
	$h = fopen($x, "r");
    while (($csv = fgetcsv($h,0, ",")) !== FALSE) {	
		$row = array();
		foreach($csv as $k=>$v){
			if($i==0){
				$header[] = trim($v);
			}else{
				$row[ $header[$k] ] = trim($v);
			}
		}
		if($i == 0){
			$GLOBALS["tHEADER"] = array_unique( array_merge($header, $GLOBALS["tHEADER"]) );
			$i++;
		}else{
			array_push($GLOBALS["tDATA"], $row);
		}		
	}
}

$db = new SQLite3(__DIR__.'/vizzes.db');

# DELETE TABLE
if( $_POST["delete"] == "Delete" ){
	$db->exec("DROP TABLE IF EXISTS '{$_POST['table']}' ;" );
	$db->exec("DELETE FROM resources WHERE name = '{$_POST['table']}' ;");
	}

# POPULATE TABLE LIST & APPEND DROPDOWN; RETRIEVE TABLE INFORMATION
$table_list = ""; //HTML; LIST OF CURRENT TABLES 
$append = ""; //OPTIONS FOR APPEND DROPDOWN
$tables = array();  //HOLDS INFORMATION FOR ALL TABLES
$result = $db->query("SELECT name,fields FROM resources WHERE type = 'data'; ");
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	$n = $row["name"];
	$nn = str_replace("DATA_","",$n);
	$tables[$n] = $row["fields"];
	$table_list .= "<form class='row' method='post' >";
	$table_list .= "<input type='hidden' name='table' value='{$n}' />{$nn}";
	$table_list .= "<input class='delete' type='submit' name='delete' value='Delete' />";
	$table_list .= "</form>";
	$append .= "<option value='{$n}'>{$nn}</option>";
	}

# UPLOAD NEW TABLE OR APPEND TO EXISTING TABLE

$GLOBALS["tDATA"] = array(); //DATA FOR ALL INPUTTED TABLES; ASSOCIATIVE ARRAY
$GLOBALS["tHEADER"] = array(); //UNIQUE LIST OF HEADER NAMES FOR ALL INPUTTED TABLES

if( $_POST["submit"] == "Upload"){
	if( $_POST["name"] !== ""  || $_POST["append"] !== "none" ){
		$name = "DATA_".$_POST["name"];
		if( array_key_exists($name, $tables) ){ 
			echo "<div class='err'>Table Already Exists</div>"; }
		else{
			#RETRIEVE INPUT CSVs AND READ THEM TO ARRAYS
			$i=0; $z=count($_FILES["file"]["tmp_name"]);
			while($i<$z){	
				if($_FILES["file"]["type"][$i] == "text/csv" ){
					csv_to_array($_FILES["file"]["tmp_name"][$i]); 
				}
				$i++;
			}
			if( count($GLOBALS["tDATA"]) > 0 ){
				if( isset($_POST["name"]) && $_POST["name"] !== ""){  //CREATE NEW TABLE & DECLARE COLUMNS 
					$cols = "'".implode("','", $GLOBALS["tHEADER"] )."'";
					$db->exec("CREATE TABLE '{$name}' ( {$cols} );");
					$fields = implode(";" , $GLOBALS["tHEADER"]);					
					$db->exec("INSERT INTO resources (name,type,fields) SELECT '{$name}','data','{$fields}';");

					$nn = str_replace("DATA_","",$name);
					$table_list .= "<form class='row' method='post' >";					
					$table_list .= "<input type='hidden' name='table' value='{$name}' />{$nn}";
					$table_list .= "<input class='delete' type='submit' name='delete' value='Delete' />";
					$table_list .= "</form>";
					$append .= "<option value='{$name}'>{$name}</option>";
					}
				else if($_POST["append"] !== "none"){ //IF APPENDING, IDENTIFY TABLE AND RETRIEVE COLUMN LIST
					$name = $_POST["append"];
					$cols = explode(";", $tables[$name] );
					}
			
				$db->exec("BEGIN");
				foreach( $GLOBALS["tDATA"] as $ROW ){
					$sql = "";
					if( isset($_POST["name"]) && $_POST["name"] !== "" ){
						$values = "'".implode("','", array_values($ROW) )."'";
						$columns = "'".implode("','", array_keys($ROW) )."'";
						$sql = "INSERT INTO '{$name}' ({$columns}) SELECT {$values} ;";
						}	 
					else if($_POST["append"] !== "none"){
						$sql = insert($ROW,$cols,$name);
						}
					$db->exec($sql);
					}

				$db->exec("COMMIT;");						
				echo "<div class='success'>Data Table Added!</div>";
			}else{ echo "<div class='err'>Invalid or Missing File</div>"; } 				
		}				
	}else{ echo "<div class='err'>Please Give the Upload a Name</div>"; }
}


?>
</pre>

<form class='vizForm' method='post' enctype="multipart/form-data">

	<p style='font-weight:bold; color:#6F6F6F'>Create additional data tables from one or more .CSV files.</p>
	<table style="border-collapse:collapse; border:0px;">
		<tr>
			<td class="l">NAME</td>
			<td class="n">
				<input id='name' name='name' type='text' style='width:300px'>
			</td>
		</tr>

		<tr>
			<td class="l">FILES</td>
			<td class="n">
				<input id='file' name='file[]' type='file' multiple>
			</td>
		</tr>

		<tr>
			<td class="l">APPEND</td>
			<td class="n">
				<script>
				function toggleName(x){
					var n = document.getElementById("name");
					if(x.value !== "none"){ n.disabled = true; }
					else{ n.disabled = false; }
				}
				</script>
				<select style='width:300px;'name='append' onchange="toggleName(this);">
					<option value='none'>No Selection (Optional)</option>
					<?php echo $append; ?>
				</select>
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
echo $table_list;
?>
</div>