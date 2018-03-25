<?php
$gt_join = $d['gt_join'];
$dt_join = $d['dt_join'];
$gtable = $d['gtable'];
$SERIES = str_replace(array("[","]"),"", $d['series'] );
$minColor = $d["minColor"];
$maxColor = $d["maxColor"];
$fields = $d["fields"];
$expr = $d["expr"];
$DATA = array();
if($d["display"]){
	$display = $d["display"];
	$names = array();
	}
$max = 0;
$min = 0;
$i = 0;
$current_column = array_keys($fields)[0];
$data_unit = $fields[$current_column]["units"];

$result = $db->query($expr);
$years = array();

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
		array_push($years,$s);
		}

	if(isset($display)){
		$names[$n] = $row[$display];
		}

	$DATA[$n][$s] = $row;

	foreach($fields as $f=>$q){
		$val = floatval( $row[$f] );
		if($i==0){
			$min = $val;
			$max = $val;
			$i++;
		}else{
			if( $val < $min ){$min = $val;}
			if( $val > $max ){$max = $val;}
		}
	}
}

$series = array_values(array_unique($years));
// $series = array_keys($DATA[$n]);

# -----------------------------------------------------------------------------
# PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS ~ PATHS
# -----------------------------------------------------------------------------

$PATHS = file_get_contents("../geojson/{$d['gtable']}.json");


# -----------------------------------------------------------------------------
# CHART ~ CHART ~ CHART ~ CHART ~ CHART ~ CHART ~ CHART ~ CHART ~ CHART ~ CHART
# -----------------------------------------------------------------------------
$axis = "";
$lines = "";
$increment = round(($max/4),0);
# $axis_max = round(($max/$increment), 0, PHP_ROUND_HALF_UP ) * $increment;
$axis_max = ceil($max/$increment) * $increment;
$labels = range(0, $axis_max, $increment);
$step = ($increment/$axis_max)*100;
foreach($labels as $l){
	$top = 100-(($l/$axis_max)*100);
	$n = number_format($l);
	$axis .= "<div class='label' style='top:{$top}%'>{$n}</div>";
	$lines .= "<div class='line' style='top:{$top}%'></div>";
	}


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
#legend{
	margin:10px;
	position:absolute;
	bottom:0px;
	left:0px;	
	height:150px;
	width:30px;
	border:1px solid white;
	<?php echo "background: {$maxColor}; /* Old browsers */
	background: -moz-linear-gradient(top,  {$maxColor} 0%, {$minColor} 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,{$maxColor}), color-stop(100%,{$minColor})); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  {$maxColor} 0%,{$minColor} 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  {$maxColor} 0%,{$minColor} 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  {$maxColor} 0%,{$minColor} 100%); /* IE10+ */
	background: linear-gradient(to bottom,  {$maxColor} 0%,{$minColor} 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$maxColor}', endColorstr='{$minColor}',GradientType=0 ); /* IE6-9 */";
	?>
	}
</style>
<script src="../jQuery/jquery-1.11.1.min.js"></script>
<!-- <script src="http://www.mi-suddr.com/wp-content/plugins/viz-library/jQuery/jquery-1.11.1.min.js"></script> -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
<script src="quant_script.js"></script>
<script>	

var series = <?php echo json_encode($series); ?>;
var current_series = series[0];
var series_name = "<?php echo $SERIES; ?>";
var current_column = "<?php print array_keys($fields)[0]; ?>";
var data = <?php echo json_encode($DATA);?>;
var dt_join = "<?php echo $dt_join; ?>";
var gt_join = "<?php echo $gt_join; ?>";
var data_unit = <?php echo json_encode($data_unit);?>;
var paths = <?php echo $PATHS; ?>;
var axis_max = <?php  echo $axis_max; ?>;
var minColor = "<?php echo $minColor; ?>";
var maxColor = "<?php echo $maxColor; ?>";
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
			$function .= "if( typeof r['$s'] !== 'undefined' ){ x+=formatNum(r['$s']['$F']) + ' $u</td>'; } ";
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
			<li class="nav" data-section="chart">
				Chart
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
		
		<?php if($i>1): ?>
		<div id="ddown" class="closed" style="position:absolute; top:10px; left:10px;">			
			<ul>
				<?php
				echo $m_opts;
				?>
			</ul>
		</div>
		<?php endif;?>
		<div id="legend">
			<div id="lmax" style='top:-3px;'>
				<?php 
				echo number_format($axis_max)." ".$data_unit;
				?>
			</div>
			<div id="lmin" style='bottom:-3px;'>
				<?php 
				echo "0 ".$data_unit;
				?>
			</div>
		</div>
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

<!-- CHART CHART CHART CHART -->
	
	<div id="chart" class="section" style="left:5000em; margin-top:15px;">
		<div id="axis" style="position:absolute; top:0px; left:0px; z-index:3">
			<?php echo $axis; ?>
		</div>
		<div id="lines" style="position:absolute; top:0px; z-index:1">
			<?php echo $lines; ?>
		</div>
		<div id="barchart" style="position:absolute; z-index:2; overflow-x:scroll; height:100%; overflow-y:hidden;">
			<div id="bars" style="position:relative;"></div>
		</div>
		<ul id="chart_legend"></ul>
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
			<label id='ChkAll' class='opts'><input class='uOpts' type='checkbox' checked/>SELECT ALL</label> 
			<p id='checkBoxes'>
				<?php  echo $u_opts; ?>
			</p>	
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

<script type="text/javascript">

	$("#ChkAll input").on("change", function () {
	    $("#checkBoxes label input").prop("checked", $(this).prop("checked"))
	});

	$("#checkBoxes label input").on("change", function () {
		if (!$(this).prop("checked")) {
			$("#ChkAll input").prop("checked", false);
		}
	})

</script>

</body>	
</html>