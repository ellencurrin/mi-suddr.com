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

$v = $db->query("SELECT * FROM library WHERE lid = {$vid}")->fetchArray(SQLITE3_ASSOC);

$d = json_decode($v['details'],true);

if($d["type"]){
	include("qual.php");
}else{
	include("quant.php");
}

?>