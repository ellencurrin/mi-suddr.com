<?php
function chunkSizes($pop,$classes=5){
	$remainder = $pop % $classes;
	$initial = ($pop - $remainder)/$classes;
	$chunks = array_fill(0,5,$initial);
	for($i=0;$i<$remainder;$i++){
		$chunks[$i] = $chunks[$i]+1;
	}
	return $chunks;
}

function getHex($minColor, $maxColor, $val, $max, $min){
	$mnC = str_split(substr($minColor,1),2);
	$mxC = str_split(substr($maxColor,1),2);
	$c = "#";

	for($i=0; $i<3; $i++){
		$a = hexdec($mnC[$i]);
		$b = hexdec($mxC[$i]);
		$d = $a - round( ($a-$b)*( ($val-$min) / ($max-$min) ) );
		$y = dechex($d);
		$c.= ( strlen($y)==1 ? "0$y" : $y);
	}

	return $c;
}

$vid = $_GET["vid"];
$db = new SQLite3('../vizzes.db');

$v = $db->query("SELECT * FROM library WHERE lid = {$vid}")->fetchArray(SQLITE3_ASSOC);

$d = json_decode($v['details'],true);

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
$current_column = array_keys($fields)[0];
$data_unit = $fields[$current_column]["units"];

$result = $db->query($expr);
$years = array();

$n = "";

$vals = array();

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
		$val = $row[$f];
		if( preg_match("/\d/", $val) ){
			array_push($vals, floatval($val) );
		}
	}
}

$mean = array_sum($vals) / count($vals);

$vals2 = array();
foreach($vals as $val){
	$x = pow( $val-$mean, 2 );
	array_push($vals2, $x);
	}
	
$sdev = sqrt( array_sum($vals2) / count($vals2) );
$min = min($vals);
$max = max($vals);

$series = array_values(array_unique($years));

# ------------------------------------------------------------------------------
# LEGEND ~ LEGEND ~ LEGEND ~ LEGEND ~ LEGEND ~ LEGEND ~ LEGEND ~ LEGEND ~ LEGEND 
# ------------------------------------------------------------------------------

$legend = "";
$chart = array();
$l_classes = array();

if($d["legend_type"]=="l_ediv"){
	$lmax = $max;
	$lmin = $min;
	$classes = $d["legend_divs"];
	$increment = ($lmax-$lmin)/$classes;	
	$quints = chunkSizes( count($vals) );
		
}else{
	$lmax = $mean + (ceil( abs($max-$mean)/$sdev ) * $sdev);
	$lmin = $mean - (ceil( abs($min-$mean)/$sdev ) * $sdev);
	$classes = ($lmax-$lmin)/$sdev;
	$increment = $sdev;
}
while($classes > 0){
	$class = array("mx"=>$lmax);
	$patch = round($lmax,1);	
	$lmax = $lmax - $increment;
	$patch = round($lmax,1).$data_unit." to ".$patch.$data_unit;
	//$c = getHex($minColor,$maxColor,$lmax,$max);
	$class["mn"] = $lmax; $class["hex"]=$c;
	array_push($l_classes, $class);
	$legend .= "<li  style='background:$c'><b>$patch</b></li>";
	$classes--;
}
echo "var legend = ".json_encode($l_classes,true);

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
$ii = 0;

foreach($series as $s){
	if($ii == 0){
		$m_opts .= "<dd class='active' data-value='{$s}' style='margin-top:15px'>{$s}</dd>"; $ii++;
		}
	else{ 
		$m_opts .= "<dd data-value='{$s}' >{$s}</dd>";
		}
	
	foreach($dCols as $dc){
		if($i == 0){
			$d_opts .= "<label class='opts'><input class='dOpts' type='checkbox' value='{$s};{$dc}' checked>{$s} - {$dc}</label>";
#			$m_opts .= "<option value='{$k};{$d}' selected>{$k} - {$d}</option>";
#			$m_opts .= "<li class='active' data-value='{$s};{$dc}' >{$s} - {$dc}</li>";
			$i++;
		}else{
			$d_opts .= "<label class='opts'><input class='dOpts' type='checkbox' value='{$s};{$dc}'>{$s} - {$dc}</label>";
#			$m_opts .= "<option value='{$k};{$d}'>{$k} - {$d}</option>";
#			$m_opts .= "<li data-value='{$s};{$dc}'>{$s} - {$d}</li>";
			$i++;
		}
	}
}


?>


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
			$function .= "if( typeof r['$s'] !== 'undefined' ){ x+=( r['$s']['$F'].search(/\d/) >= 0 ? formatNum(r['$s']['$F'])+' $u' : r['$s']['$F'] )+'</td>'; } ";
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

