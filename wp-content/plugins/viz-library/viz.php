<?php

	$db = new SQLite3(__DIR__.'/vizzes.db');

	$e = false;
	if( $_GET["lid"] ){
		$e = true;
		}

# ---------------------------------------------------------------------------------
# SAVE VIZ ~ SAVE VIZ ~ SAVE VIZ ~ SAVE VIZ ~ SAVE VIZ ~ SAVE VIZ ~ SAVE VIZ  
# ---------------------------------------------------------------------------------
	
	if( $_POST["submit"] == "Save Viz"){

		$cols = "type,
				title, 
				description,
				source,
				timeframe,
				details,
				tags,
				draft";
				
		$b = array("[","]");
	
		$db->exec("CREATE TABLE IF NOT EXISTS library ( [lid] INTEGER PRIMARY KEY ASC, $cols )");

		$tags =  (count($_POST["vtags"])>0) ? "[".implode("],[",$_POST["vtags"])."],[Viz]" : "[Viz]";

		$details = array(
			'maxColor' => $_POST['maxColor'],
			'minColor' => $_POST['minColor'],
		);

		$series = trim($_POST['series']);
		if( $series !== "" ){
			$details["series"] = $series;
		}

		$FLDS = $_POST["fields"];
		$key = "[{$_POST['dt_join']}]";
		$asc = array($key);
		$expr = array($key);
		if($series !== ""){ 
			array_push($expr, $_POST['series']); 
			array_push($asc, $_POST['series']); 
			}		
		$fields = array();
		$draft = 0;
		if( isset($_POST['draft']) ){$draft=1;}

		# ==========================
		# PREPARE FIELD DESCRIPTIONS
		# ==========================
				
		foreach($FLDS as $f){
			array_push($expr, $f["name"]);
			$n = stripslashes(trim(str_replace($b,"", array_pop( preg_split("/\s+AS\s+/i", $f["name"]) ) ) ) );			
			$x = array(
				"expr" => trim(str_replace("'",'"', stripslashes($f["name"] ) ) )
				);
			if( $f['confidence'] !== "" ){
				$confidence = str_replace("'",'"', stripslashes($f["confidence"]) );
				array_push($expr, $confidence);
				$x["ci_expr"] = trim(str_replace("'",'"', stripslashes( $confidence ) ) );
				$x["ci"] = trim(str_replace($b,"", array_pop( preg_split("/\s+AS\s+/i", $confidence ) ) ) );
				}
			// if( $f['units'] !== "" ){
			// 	$x['units'] = trim(str_replace("'",'"', stripslashes($f["units"]) ) );
			// 	}
			$x['units'] = trim(str_replace("'",'"', stripslashes($f["units"]) ) );
			if( $f['def'] !== "" ){
				$x['def']= trim(str_replace("'",'"', stripslashes( $f["def"] ) ) );
				}
			$fields[$n] = $x;
			}

		$details["fields"] = $fields;
		
		if($_POST['display']){
			$details["display"] = trim(str_replace($b,"", array_pop( preg_split("/\s+AS\s+/i", $_POST["display"] ) ) ) );
			$details["display_expr"] = $_POST['display'];
			array_push($expr,$_POST['display']);
		}		

		$expr = "SELECT".implode(",", $expr)." FROM [{$_POST['dtable']}] ";
		$legend_expr .= "[{$_POST['dtable']}] ";
		if( $_POST["where"] !== "" ){
			$w = trim(str_replace("'",'"', stripslashes( $_POST["where"] ) ) );
			$details["where"]= $w;
			$expr.="WHERE {$w} ";
			}

		$ASC = implode(",",$asc);
		$expr.="ORDER BY {$ASC} ASC";
		$details["expr"] = $expr;
		$details["dtable"] = trim($_POST['dtable']);
		$details["gtable"] = trim($_POST['gtable']);
		$details["dt_join"] = trim(str_replace($b,"",$_POST['dt_join']));
		$details["gt_join"] = trim(str_replace($b,"",$_POST['gt_join']));
		$details["legend_type"] = $_POST['legend_type'];
		$details["legend_divs"] = $_POST['legend_divs'];
		$d = json_encode($details);

		$values = "
			'viz',
			'{$_POST['title']}', 
			'{$_POST['description']}',
			'{$_POST['source']}',
			'{$_POST['timeframe']}',			
			'{$d}',
			'{$tags}',
			'{$draft}'
			";			

		$insert = "INSERT INTO library ( {$cols} ) VALUES( {$values} )";

		if($e){
			$values = "
				title = '{$_POST['title']}', 
				description = '{$_POST['description']}',
				source = '{$_POST['source']}',
				timeframe = '{$_POST['timeframe']}',
				details = '{$d}',
				tags = '{$tags}',
				draft = '{$draft}'
				";			
			$insert = "UPDATE library SET $values WHERE lid = {$_GET["lid"]}";
			}
			
		$db->exec($insert);

		$result = $db->query("SELECT lid FROM library ");
		$library = array();
		while($row=$result->fetchArray(SQLITE3_ASSOC)){
			array_push($vizzes,$row["LID"]);
			}
		$ll = json_encode($library);
		file_put_contents(__DIR__."/vizlist.json",$ll);

		echo "<div class='success'>Success!</div>";
	}
	
	# ---------------------------------------------------------------------------------
	# PREPARE FORM ~ PREPARE FORM ~ PREPARE FORM ~ PREPARE FORM ~ PREPARE FORM  
	# ---------------------------------------------------------------------------------	

	if($e){
		$e = $db->query("SELECT * FROM library WHERE lid = ".$_GET["lid"])->fetchArray(SQLITE3_ASSOC);
		$e["details"] = json_decode($e["details"],true);				
		}
	
	$result = $db->query("SELECT name, type, fields FROM resources;");
	
	$data="<option>Select Data Table</option>"; 
	$geo="<option>Select Geography Table</option>";
	$columns = array();
	
	while($row=$result->fetchArray(SQLITE3_ASSOC)){
		$name = $row["name"];
		$flds = $row["fields"];
		$type = $row["type"];
		
		$s = "";
		if($e){if($name == $e["details"]["dtable"] || $name == $e["details"]["gtable"] ){
			$s = "selected";
			}}

		if( $type == "data" ){
			$data .= "<option value='{$name}' {$s}>{$name}</option>";
			}
		if( $type == "json" ){
			$geo .= "<option value='{$name}' {$s}>{$name}</option>";
			}

		$columns[$name] = explode(";",$flds);
	}
	

?>

<form class='vizForm' method='post' enctype="multipart/form-data">

	<table style="border-collapse:collapse; border:0px; float:left; margin:10px 0px 200px">
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

		<tr>
			<td class="l">Data Table</td>
			<td class="n">
				<select id='dtable' name='dtable' style="width:100%; margin:auto 0px; float:left;" onchange="setColumns(this,'#dt_join');">
				<?php echo $data;?>
				</select>

		<tr>
			<td class="l">Geo Table</td>
			<td class="n">
				<select id='gtable' name='gtable' style='width:100%; margin:auto 0px; float:left;' onchange="setColumns(this,'#gt_join')">
				<?php echo $geo;?>
				</select>				
			</td>
		</tr>

		<tr>
			<td class="l">Table Join</td>
			<td class="n" vertical-align="center">
				<select id="dt_join" name="dt_join" style='width:200px; margin:0px; float:left' disabled></select>
				<div style="font-size:20px; line-height:28px; font-weight:bold; width:20px; vertical-align:middle; float:left; text-align:center;">=</div>
				<select id="gt_join" name="gt_join" style='width:200px; margin:0px; float:left' disabled></select>	
			</td>
		</tr>


		<tr>
			<td class="l">Series</td>
			<td class="n">
				<?php $val = ($e ? $e["details"]["series"] : "" ); ?>
				<input class='sql' name='series' type='text' placeholder="Series Column, i.e. year, age groups, etc."
					 style='width:100%;' value="<?php echo $val;?>">
			</td>
		</tr>

		<tr>
			<td class="l">Display Column</td>
			<td class="n">
				<?php $val = ($e ? $e["details"]["display_expr"] : "" ); ?>
				<input class='sql' name='display' type='text' placeholder="Column from data table with name for each row"
					 style='width:100%;' value="<?php echo $val;?>">
			</td>
		</tr>

		<tr id="filter">
			<td class="l">Filter</td>
			<td class="n">
				<?php $val = ($e ? $e["details"]["where"] : "" ); ?>
				<textarea class='sql' name='where' type='text' style='width:100%;'><?php echo $val;?></textarea>
			</td>
		</tr>

		<tr id="column_list">
			<td class="l" style="vertical-align:top;">Fields</td>
			<td class="n">
				<div id="columns"></div>
				<input class="submit" type='button' onclick="addColumn()" value="Add Field" style="margin-bottom:20px;">
			</td>
		</tr>

		<tr id="vlegend">
			<td class="l" style="vertical-align:top;">Legend</td>
			<td class="n" style="position:relative vertical-align:top;">		
				<select id="ltype" name="legend_type" style="width:100%; margin:auto 0px;" onchange="vlegend();" >
					<option value="l_sdev" selected>Standard Deviaton</option>
					<option value="l_ediv">Equal Divisons</option>
				</select>
				<div id="l_ediv" class="l_section" style="display:none;">
					<div class="legend_row" style="padding-bottom:5px;">
						<span style="vertical-align:middle">Divisions</span>
						<select name="legend_divs" id="ldivs" style="margin-left:5px">
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5" selected>5</option>
							<option value="6">6</option>
							<option value="7">7</option>
						</select>
					</div>
				</div>
				<div id="l_sdev" class="l_section">
					<div class="legend_row">
						<div class="cp-label">Min Color</div>
						<div style="height:30px; overflow:visible; float:left;">
							<input name="minColor" type="text" value="#E0F3DB" class="my-color-field" />
						</div>
					</div>
					<div class="legend_row">
						<div class="cp-label">Max Color</div>
						<div style="height:30px; overflow:visible; float:left;">
							<input name="maxColor" type="text" value="#43A2CA" class="my-color-field" />
						</div>
					</div>
				</div>		
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
				<input id="submit" name='submit' class='submit' type='submit' value='Save Viz'>
				
				<label style='margin-left:20px;'><input type='checkbox' name='draft' value='1' 
					<?php if($e){if($e['draft'] === 1){ echo 'checked';}} ?>>Save as Draft</label>
			</td>
		</tr>
			
	</table>
	
	
	<div style="float:left;">
		<div id="fieldlist" style="margin:10px 20px; padding:5px; border:1px solid #DdDdDd; background:whitesmoke; height:400px; width:200px; overflow:scroll;">
		</div>
	</div>

</form>

<script>

<?php echo "var vColumns = ".json_encode($columns); ?>

var flds = 0;

function allowDrop(ev) {
    ev.preventDefault();
	}

function drag(ev) {
	var x = ev.target.getAttribute("data-value")
    ev.dataTransfer.setData("text", " ["+x+"]");
	}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.value+=data;
	}
	
function setColumns(a,b){
	var n = a.value;
	var x = vColumns[n];
	var y = "<optgroup label='"+n+"'>";
	var z = "";
	for(i in x){
		z+= "<div class='column' data-value='"+x[i]+"' draggable='true' ondragstart='drag(event)'>"+x[i]+"</div>";
		y+= "<option value='"+x[i]+"'>"+x[i]+"</option>";
		}
	y+= "</optgroup>";

	jQuery(b).html(y);
	jQuery(b).prop("disabled", false);

	if( a.id == "dtable" ){
		dataset = n;
		flds = 0;
		jQuery("#columns").html("");
		addColumn();
		jQuery("#fieldlist").html(z);
	}

}

function addColumn(expr,ci,units,def){
	expr = typeof expr !== 'undefined' ? expr : "";
	ci = typeof ci !== 'undefined' ? ci : "";
	def = typeof  def !== 'undefined' ? def : "";	
	units = typeof units !== 'undefined' ? units : "";
	
	var c = "<div class='vfield'>";
	c += "<div class='field_remove' onclick='jQuery(this).parent().remove();'>&times;</div>"
	c += "<input class='sql' name='fields["+flds+"][name]' type='text' placeholder='Column' ondrop='drop(event) '"; 	
	c += "ondragover='allowDrop(event)' style='width:475px' value='"+expr+"'><br><br>";
	c += "<textarea class='sql' name='fields["+flds+"][def]' type='text' placeholder='Field Definition' ";
	c += "style='width:475px; resize:vertical; margin-bottom:10px;' >"+def+"</textarea><br>";
	c += "<input class='sql' name='fields["+flds+"][confidence]' type='text' placeholder='Confidence Interval' ";
	c += "ondrop='drop(event)' ondragover='allowDrop(event)' style='margin-right:10px; width:200px;' value='"+ci+"'>";
	c += "<input class='sql' name='fields["+flds+"][units]' type='text' placeholder='Units'";
	c += "style='margin-right:10px; width:200px;' value='"+units+"'>";
	c += "</div>";
	jQuery("#columns").append(c);
	flds++;
}

function fAdd(a){
	var b = jQuery("#vfields").val();
	if(b != null){
		var v = jQuery(a).val();
		var nv = (v.length > 0 ? (v+", "+b) : b );
		jQuery(a).val(nv);
	}
}

function vlegend(){
	if( jQuery("#ltype").val() == "l_ediv"){
		jQuery("#l_ediv").show();
	}else{
		jQuery("#l_ediv").hide();
	}
}

jQuery(document).ready(function($){	
    $('.my-color-field').wpColorPicker();
	$('.wp-picker-container').click(function(){
		$('.wp-picker-container').removeClass("active");
		$(this).addClass("active");
		});
	
	$(window).keydown(function(event){
		if(event.keyCode == 13) {
			event.preventDefault();
			return false;
			}
		}).scroll(function(){
			var t = $(".vizForm").offset().top - $(window).scrollTop();
			if(t < 40){
				$("#fieldlist").css({"position":"fixed", "top":40})
			}
			if(t > 40){
				$("#fieldlist").css({"position":"static", "top":"auto"})
			}		
		});
		
	<?php if($e): 
		$dt = $e["details"]["dt_join"]; 
		$gt = $e["details"]["gt_join"]; 
		$lt = $e["details"]["legend_type"];
		$ld = $e["details"]["legend_divs"];
		?>
		setColumns( $("#dtable")[0], '#dt_join' );
		setColumns( $("#gtable")[0], '#gt_join' );
		$("option[value='<?php echo $dt; ?>'],option[value='<?php echo $gt; ?>'],option[value='<?php echo $lt; ?>'],option[value='<?php echo $ld; ?>']").prop("selected",true);
		
		$("#columns").html("");
		vlegend();
		<?php 
		$fields = "";
		$F = $e["details"]["fields"];
		foreach($F as $f){
			$expr = $f['expr'];
			$ci = $f['ci_expr'];
			$units = $f['units'];
			$def = $f['def'];
			echo "addColumn('$expr','$ci','$units','$def');";
			}
					
		?>
		
	<?php else: ?>
	  
	addColumn();
	
	<?php endif; ?>
});

</script>

<?php
	$db->close();
?>