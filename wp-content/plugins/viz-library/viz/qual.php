<?php
$gt_join = $v['gt_join'];
$dt_join = $v['dt_join'];
$gtable = $v['gtable'];
$SERIES = str_replace(array("[","]"),"", $d['series'] );

$fields = $d["fields"];
$expr = $d["expr"];
$DATA = array();
if($d["display"]){
	$display = $d["display"];
	$names = array();
	}

$legend = $d["legend"];

$current_column = array_keys($fields)[0];
$data_unit = $fields[$current_column]["units"];

$result = $db->query($expr);

$series = array();

$n = "";
while($row=$result->fetchArray(SQLITE3_ASSOC) ){
	$n = $row[$dt_join];
	$s = "Data";
	if( isset($DATA[$n]) == false ){
		$DATA[$n] = array();
		}
	if($SERIES == ""){
		unset($row[$dt_join]);
	}else{
		$s = $row[$SERIES];
		unset($row[$dt_join], $row[$SERIES]);
		}

	if(isset($display)){
		$names[$n] = $row[$display];
		}

	$DATA[$n][$s] = $row;
	
	if( in_array($s,$series) == false ){
		$series[] = $s;
	}

	// foreach($fields as $f=>$q){
	// 	$val = floatval( $row[$f] );
	// 	if($i==0){
	// 		$min = $val;
	// 		$max = $val;
	// 		$i++;
	// 	}else{
	// 		if( $val < $min ){$min = $val;}
	// 		if( $val > $max ){$max = $val;}
	// 	}
	// }
}

// $series = array_keys($DATA[$n]);

# -----------------------------------------------------------------------------
# PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS
# -----------------------------------------------------------------------------

$PATHS = file_get_contents("../geojson/{$v['gtable']}.json");


# -----------------------------------------------------------------------------
# OPTIONS ~ OPTIONS ~ OPTIONS ~ OPTIONS ~ OPTIONS ~ OPTIONS ~ OPTIONS ~ OPTIONS
# -----------------------------------------------------------------------------
$dCols = array_keys($fields);

$u_opts = "";
foreach($DATA as $k=>$s){
	$u_opts .= "<label class='opts'><input class='uOpts' type='checkbox' value='{$k}' checked/>{$k}</label>";
	}

$d_opts = "";
$m_opts = "";
$i = 0;

foreach($series as $s){
	foreach($dCols as $d){

		if($i == 0){
			$d_opts .= "<label class='opts'><input class='dOpts' type='checkbox' value='{$s};{$d}' checked>{$s} - {$d}</label>";
#			$m_opts .= "<option value='{$k};{$d}' selected>{$k} - {$d}</option>";
			$m_opts .= "<li class='active' data-value='{$s};{$d}' >{$s} - {$d}</li>";
			$i++;
		}else{
			$d_opts .= "<label class='opts'><input class='dOpts' type='checkbox' value='{$s};{$d}'>{$s} - {$d}</label>";
#			$m_opts .= "<option value='{$k};{$d}'>{$k} - {$d}</option>";
			$m_opts .= "<li data-value='{$s};{$d}'>{$s} - {$d}</li>";
			$i++;
		}

	}
}


?>
<!--[if (IE 7)|(IE 8)|(IE 9)]>     
	<html class="vml" xmlns:v="urn:schemas-microsoft-com:vml"> 
<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html>  <!--<![endif]-->
<head>
	
<!--[if (IE 7)|(IE 8)|(IE 9)]>     
	<style>v\:* {behavior:url(#default#VML);}</style>
	<script>var vml = true; var svg = false;</script>
<![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> 
	<script>var svg = true; var vml = false;</script>
<!--<![endif]-->
	
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<style>
path{	
	stroke:#666666;
	}
</style>
<script src="../jQuery/jquery-1.11.1.min.js"></script>
<!-- <script src="http://www.mi-suddr.com/wp-content/plugins/viz-library/jQuery/jquery-1.11.1.min.js"></script> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script src="qual_script.js"></script>
<script>

var series = <?php echo json_encode($series); ?>;
var current_series = series[0];
var series_name = "<?php echo $SERIES; ?>";
var current_column = "<?php print array_keys($fields)[0]; ?>";
var data = <?php echo json_encode($DATA);?>;
var gt_join = "<?php echo $gt_join; ?>";
var data_unit = <?php echo json_encode($data_unit);?>;
var paths = <?php echo $PATHS; ?>;
var legend = <?php echo json_encode($legend); ?>;
var fields = <?php echo json_encode($fields);?>;
	<?php 
	if(isset($display)){
		echo "var names = ".json_encode($names).";";
		}
	?>;
//var dCols = <?php // echo json_encode(array_keys($fields)); ?>;

function makeRow(r){
	var x = "";
  <?php
	$function = "";
	$header = array();
	$header2 = array();
	$subheader = array();
	$subheader2 = array();
	$column = 0;
	foreach($fields as $F=>$f){
		$c = 0;
		foreach($series as $s){
			$y = 1;	
			$c++;
			$u = $f["units"];
			$function .= "x += '<td class=\"tVal\">'; ";
			$function .= "if( typeof r['$s'] !== 'undefined' ){ x+=r['$s']['$F'] + ' $u</td>'; } ";
			$function .= "else{ x+= 'N/A </td>'; }";
			if( isset($f["ci"]) ){
				$ci = str_replace(array("'",'"'),"",$f["ci"]);
				$function .= " x+= '<td class=\"ciVal\">'+r['$s']['$ci']+'</td>'; ";
				$y = 2; $c++; $column++; //Colspans
				}
			if( count($series) > 1){
				$column++;
				$html = "<td class='shVal' colspan='$y'>$s";
				$html .= "<div class='sort' data-col='$column'><div class='up'></div> <div class='down'></div> </div>";
				$html .= "</td>";
				array_push($subheader, $html); //push subheader
				}
			}
		// $rowspan = count($series)==1 ? 1:2;
		if($c==1){
			$html = "<td class='hVal' colspan='1' rowspan='2'><b>$F</b>";
			}
		else{
			$html = "<td class='hVal' data-col='$column' colspan='$c'><b>$F</b>";
			}
		if(count($series)== 1){
			$html .= "<div class='sort' data-col='$column'> <div class='up'></div> <div class='down'></div> </div>";
			}	
		if( isset($f['def']) ){
			$html .= "<div class='field_def'>?<div class='field_def_inner'>{$f['def']}</div></div>";
			}
		$html .= "</td>";
		
		array_push($header, $html); //push header
		// $html = "<div class='hVal'>$F";
		// $html .= "<div class='field_def'>";
		// $html .= "<div class='field_def_inner'>{$f['def']}</div>";
		// $html .= "</div></div>";
		// array_push($header2, $html); //push header2
	}
	echo $function."return x;";
  ?>	
}

var header = "<?php echo implode($header); ?>";
var subheader = "<?php  if($c > 1){ echo implode($subheader); }?>";

var PlayData = {
	i:0,
	s:series.length-1,
	play: function(){
		var x = PlayData.i;
		current_series = series[x];
		$("#ddown li").removeClass("active");
		$("#ddown li:eq("+x+")").addClass("active");
		makeMap();
		if(x < PlayData.s){
			x++
			PlayData.i = x;
		}else{
			PlayData.i=0;
			window.clearInterval(myVar);
			$("#playing").hide();
			$("#play").show(); 
		}		
	},
	start: function(){
		window.myVar = setInterval(PlayData.play,700);
		$("#play").hide();
		$("#playing").show();
	}
}

</script>
</head>
<body>
	
<!-- NAVIGATION NAVIGATION NAVIGATION -->
	
	<div id="header">
		<div id="vtitle">
			<?php echo $v["title"]; ?>
		</div>
		<ul id="nav">
			<li class="nav active" data-section="map">
				Map
			</li>
			<li class="nav" data-section="table">
				Table
			</li>
			<li class='icon' data-section="options" onclick="$('#options').fadeIn()">
				<img src="images/gear.png" />
			</li>
			<li id='download' class='icon'>
				<img src="images/download.png" />
				<ul id="dmenu">
					<li onclick="makeCSV();document.getElementById('CSV').submit()">Download CSV File</li>
					<li onclick="makeJPG();document.getElementById('JPG').submit()">Download Map as JPG</li>
				</ul>
			</li>
		</ul>		
	</div>

<!-- MAP MAP MAP MAP MAP MAP -->

	<div id="map" class="section" style="">
		<div id="info" style="display:none;">
			<div style="background:#ffffff; padding:5px 10px;">
				<div id="unit"></div>
				<div id="value"></div>
			</div>
		</div>
		
		
		<!-- DROPDOWN DROPDOWN DROPDOWN -->
		<?php if($i>1): ?>
		<div id="ddown" class="closed" style="position:absolute; top:10px; left:10px;">			
			<ul>
				<?php
				echo $m_opts;
				?>
			</ul>
		</div>
		<?php endif;?>
		<div id="play" onclick="PlayData.start()"><div id="play_arrow"></div>Play Data</div>
		<div id="playing" style="display:none;">PLAYING . . . </div>
		
		<!-- LEGEND LEGEND LEGEND -->
		<ul id="c_legend">
			<?php
			foreach($legend as $l){
				$label = $l["label"]; 
				$max = $l["Max"];
				echo "<li><div class='patch' style='background-color:$max'></div>$label</li>";
			}
			?>
			<li><div class="patch" style="background-color:#EeEeEe"></div>No Data</li>
		</ul>

		<div id='canvas' style='width:100%; height:95%; position:relative;'></div>
		<div id="meta" onclick="$('#meta_inner').toggle();">Data Info
			<dl id="meta_inner" style="display:none;">
				<dt>Description</dt>
					<dd><?php echo $v["description"]; ?></dd>
				<dt>Source</dt>
					<dd><?php echo $v["source"]; ?></dd>
				<dt>Dates</dt>
					<dd><?php echo $v["timeframe"]; ?></dd>
			</dl>
		</div>
	</div>
	
<!-- TABLE TABLE TABLE TABLE-->

	<div id="table" class="section" style="left:5000em;">	
		<table id="hrow"></table>
		<div id="tcont" style="height:100%; width:100%; overflow:auto;">	
			<table id="dtable">

			</table>
		</div>
	</div>

<!-- OPTIONS OPTIONS OPTIONS OPTIONS -->
	
	<div id="options" style="display:none;">
		<div style="height:35px; line-height:35px; font-size:18px; background:#AaAaAa; padding:0px 10px; font-weight:bold">
			OPTIONS
		</div>
		<div id="units" class="optgroup" style="margin-right:0px;">
			<h4>Counties</h4>
			<?php  echo $u_opts; ?>
		</div>
		<?php if($i>1): ?>
		<div id="dsets" class="optgroup" style="margin-right:0px;">
			<h4>Datasets</h4>
			<?php echo $d_opts; ?>
		</div>
	<?php endif; ?>
		<div style="float:left; margin:10px; width:200px">
			<div style="overflow:hidden;">
				<div class="button" style="margin-right:10px" onclick="apply()">Apply</div>
				<div class="button" onclick="$('#options').fadeOut(200);">Cancel</div>
			</div>
		</div>

	</div>
	
</div>
<form id="CSV" method="post" action="csv.php" style="display:none;" target="csv">
	<textarea id="content" name='content'></textarea>
	<input name="title" type="hidden" value="<?php echo $v["title"]; ?>">
</form>
<form id="JPG" method="post" action="jpg.php" style="display:none;" target="csv">
	<textarea id="img_content" name='img_content'></textarea>
	<input name="img_title" type="hidden" value="<?php echo $v["title"]; ?>">
</form>
<iframe id="csv" name="csv" style="display:none;" ></iframe>
</body>	
</html>