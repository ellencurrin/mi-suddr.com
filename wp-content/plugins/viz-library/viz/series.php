<pre>
<?php

// function getColor($minColor, $maxColor, $val, $max){
// 	$nc = str_split( substr($minColor,1,7), 2);
// 	$xc = str_split( substr($maxColor,1,7), 2);
// 	$c = "#";
// 	foreach( range(0,2) as $i ){
// 		$a = hexDec( $nc[$i] );
// 		$b = hexDec( $xc[$i] );
// 		$d = $a - round( ($a - $b) * ($val/$max) );
// 		$y = dechex($d);
// 		$c .= ( strlen($y) == 	1  ) ? "0".$y : $y;
// 	}
// 	return $c;
// }


# ---------------------------------------------------------------------------------
# DATA PREP ~ DATA PREP ~ DATA PREP ~ DATA PREP ~ DATA PREP ~ DATA PREP ~ DATA PREP  
# ---------------------------------------------------------------------------------


$vid = $_GET["vid"];
$db = new SQLite3('../vizzes.db');

$v = $db->query("SELECT * FROM vizzes WHERE vid = {$vid}")->fetchArray(SQLITE3_ASSOC);

$d = json_decode($v['details'],true);

$gt_join = $v['gt_join'];
$dt_join = $v['dt_join'];
$gtable = $v['gtable'];
$SERIES = str_replace(array("[","]"),"", $d['series'] );
$minColor = $d["minColor"];
$maxColor = $d["maxColor"];
$fields = $d["fields"];
$expr = $d["expr"];
$DATA = array();
$max = 0;
$min = 0;
$i = 0;
$current_column = array_keys($fields)[0];
$data_unit = $fields[$current_column]["units"];

$result = $db->query($expr);

echo $expr;

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

print_r($DATA);

$series = array_keys($DATA[$n]);
#$series = array_keys(array_shift($DATA));
print_r($series);

?>
</pre>