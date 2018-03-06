<?php

$db = new SQLite3(__DIR__.'/vizzes.db');

$e = false;
if( $_GET["lid"] ){
	$e = true;
	}


# ---------------------------------------------------------------------------------
# SAVE DOC ~ SAVE DOC ~ SAVE DOC ~ SAVE DOC ~ SAVE DOC ~ SAVE DOC ~ SAVE DOC 
# ---------------------------------------------------------------------------------

if( $_POST["submit"] == "Save Document"){
	if($e){
		$tags =  (count($_POST["vtags"])>0) ? "[".implode("],[",$_POST["vtags"])."],[Doc]" : "[Doc]";
		$values = "
			title = '{$_POST['title']}', 
			description = '{$_POST['description']}',
			source = '{$_POST['source']}',
			timeframe = '{$_POST['timeframe']}',
			tags = '{$tags}',
			draft = 0
			";
		$insert = "UPDATE library SET $values WHERE lid = {$_GET["lid"]}";
		$db->exec($insert);				
	}else{
		$file = $_FILES["file"]["name"];
		if( preg_match("/.*\.pdf/", $file) ){
			if( $_POST["title"]){
				$name = time().".pdf";
				$move = rename( $_FILES["file"]["tmp_name"], __DIR__."/docs/".$name);
				if($move){
					$cols = "type,
							title, 
							description,
							source,
							timeframe,
							details,
							tags,
							draft";
	
					$db->exec("CREATE TABLE IF NOT EXISTS library ( [lid] INTEGER PRIMARY KEY ASC, $cols )");

					$tags =  (count($_POST["vtags"])>0) ? "[".implode("],[",$_POST["vtags"])."],[Doc]" : "[Doc]";
					$details = array( "url" => $name );
					$d = json_encode($details);
					$values = "
						'doc',
						'{$_POST['title']}', 
						'{$_POST['description']}',
						'{$_POST['source']}',
						'{$_POST['timeframe']}',
						'{$d}',
						'{$tags}',
						0
						";
				
					$insert = "INSERT INTO library ({$cols}) VALUES( {$values} )"; 												
				
					$result = $db->exec($insert);
				
					echo "<div class='success'>Document Added!</div>";
				}
				else{ echo "<div class='err'>Error saving file</div>";
				}
			}
			else{
				echo "<div class='err'>Please Provide a Title for the Upload</div>";
			}
		}
		else{
			echo "<div class='err'>Invalid or Missing File</div>";
		}
	}

}	

if($e){
	$e = $db->query("SELECT * FROM library WHERE lid = ".$_GET["lid"])->fetchArray(SQLITE3_ASSOC);
	$e["details"] = json_decode($e["details"],true);				
	}


?>

<form class='vizForm' method='post' enctype="multipart/form-data">

	<table style="border-collapse:collapse; border:0px; float:left; margin:10px 0px 200px">

		<?php if ($e) : ?>
			

		<!-- <tr> -->
			<!-- <td class="l">File</td> -->
			<!-- <td class="n"> -->
				<?php
				// $name = $e["details"]["url"];
				// $url = $base."docs/".$name;
				// echo "<a href='$url' target='_blank' >$name</a>"
				?>
			<!-- </td> -->
		<!-- </tr> -->
		<!-- <tr> -->
			<!-- <td class="l">New File</td> -->
			<!-- <td class="n"> -->
				<!-- <input id='file' name='file' type='file'> -->
			<!-- </td> -->
		<!-- </tr> -->


		<?php else: ?>

		<tr>
			<td class="l">File</td>
			<td class="n">
				<input id='file' name='file' type='file'>
			</td>
		</tr>

		<?php endif; ?>

		<tr>
			<td class="l" style="vertical-align:top;">Title</td>
			<td class="n">
				<textarea id='title' name='title' style="width:100%; margin-bottom:6px;"><?php if($e){echo $e["title"];}?></textarea>
			</td>
		</tr>

		<tr>
			<td class="l" style="vertical-align:top;">Description</td>
			<td class="n">
				<textarea id="description" name="description" style="width:100%; margin-bottom:6px;"><?php if($e){echo $e["description"];}?></textarea>
			</td>
		</tr>

		<tr>
			<td class="l" style="vertical-align:top;">Timeframe</td>
			<td class="n">
				<textarea id="timeframe" name="timeframe" style="width:100%; margin-bottom:6px;"><?php if($e){echo $e["timeframe"];}?></textarea>
			</td>
		</tr>

		<tr>
			<td class="l" style="vertical-align:top;">Source</td>
			<td class="n">
				<textarea id="source" name="source" style="width:100%; margin-bottom:6px;"><?php if($e){echo $e["source"];}?></textarea>
			</td>
		</tr>
		
		<tr id="vtags">
			<td class="l" style="vertical-align:top;">Tags</td>
			<td class="n">
				<div style='width:550px; margin-bottom:40px;'>
				<?php
				$result = $db->query("SELECT type, name FROM tags;");
				$groups = array();
				while($row=$result->fetchArray(SQLITE3_ASSOC)){
					$n = $row["name"];
					$t = $row["type"];
					if( isset($groups[$t]) === false ){
						$groups[$t]="";
						}
					$c = "";
					if($e){
						$x = "[$n]";
						if( strpos($e["tags"],$x) !== False ){
							$c = "checked";
							} 
						}
					$groups[$t] .= "<label class='vtags'><input type='checkbox' name='vtags[]' value='$n' $c>$n</label>";
					}
				foreach($groups as $k=>$v){
					echo "<div style='overflow:hidden; margin-bottom:10px'><h4 style='line-height:28px; margin:0px 5px; padding:0px;'>$k</h4>$v</div>";
					}
				?>
				</div>
			</td>
		</tr>
		
		<tr id="vsubmit">
			<td class="l"></td>
			<td class="n">
				<input id="submit" name='submit' class='submit' type='submit' value='Save Document'>
			</td>
		</tr>
			
	</table>


</form>

<?php
	$db->close();
?>