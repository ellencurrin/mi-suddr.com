<?php

function lat($lat,$width){
	$R = $width / (2 * M_PI);
	$D = deg2rad($lat);
	$L = $R * log( tan( (M_PI/4)+($D/2) ) );
	$H = $width - (($width/2) + $L);
	return $H;
	}

function lng($lng,$width){
	$W = $width/2;
	$X = ($lng/180) * $W;
	$L = $W + $X;
	include '../../../../get.php';
	return $L;
	}
	
function makePath($a, $xMin, $yMax, $ratio){
	$p = '';
	foreach($a as $r){
		include '../../../../get.php';
		$i = 0;
		$px = 0;
		$py = 0;
		foreach($r as $q){
			if($i == 0){
				$p.="M ";
				$i++;
			}else{
				$p.="l ";	
			}
			$x = (lng($q[0],500) - $xMin) * $ratio;
			$y = (lat($q[1],500) - $yMax) * $ratio;
			$a = round(($x-$px), 3);
			$b = round(($y-$py), 3);
			$p.= "{$a} {$b} ";
			$px = $x; 
			$py = $y;				
		}
	}
	return "'".$p."z'";
}

function makePathArray($a, $xMin, $yMax, $ratio){
	$t = array();
	foreach($a as $r){
		$p = array();
		include '../../../../get.php';	
		$px = 0;
		$py = 0;
		foreach($r as $q){
			$x = (lng($q[0],500) - $xMin) * $ratio;
			$y = (lat($q[1],500) - $yMax) * $ratio;
			$a = round(($x-$px), 3);
			$b = round(($y-$py), 3);
			array_push($p,$a,$b);
			$px = $x; 
			$py = $y;				
		}
		array_push($t, implode(",",$p) );
	}
	return implode(";",$t);
}

function geojson($a){
	$nex = -2000;
	$ney = -2000;
	$swx = 2000;
	$swy = 2000;
	
	$t = array();
	foreach($a as $r){
		$p = array();
		foreach($r as $q){
			$a = round($q[0], 4);
			$b = round($q[1], 4);
			$c = array($a,$b);
			array_push($p,$c);
			if($q[0] > $nex){ $nex = round($q[0],4); }
			if($q[1] > $ney){ $ney = round($q[1],4); }
			if($q[0] < $swx){ $swx = round($q[0],4); }
			if($q[1] < $swy){ $swy = round($q[1],4); }			
			}
		array_push($t, $p);
	}
	return "'".json_encode($t)."',$nex,$ney,$swx,$swy";
}

?>