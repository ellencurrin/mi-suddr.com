<?php

function getHex($colors, $val, $max){
	$c = "#";
	foreach($colors as $x){
		$b = $x[0] - round( ($x[0] - $x[1]) * ($val/$max) );
		$y=dechex($b);
		if(strlen($y) == 1){
			$c.="0".$y;
		}else{
			$c.=$y;
		}
	}
	return $c;
}

$colors = array(
	array(255,0),
	array(0,255),
	array(0,0)
	);

$vid = $_GET["vid"];
$db = new SQLite3('vizzes.db');

$v = $db->query("SELECT * FROM vizzes WHERE vid = {$vid}")->fetchArray(SQLITE3_ASSOC);
	
$data = array();
$series = array();
$result = $db->query("SELECT * FROM {$v['dataTable']} ORDER BY County, Year, ALCRASH ASC");
$i = 0;
$max = 0;
$min = 0;
while($row=$result->fetchArray(SQLITE3_ASSOC)){
	$val = floatval($row['ALCRASH']);
	if($i==0){
		$min = $val;
		$max = $val;
		$i++;
	}else{
		if( $val < $min ){$min = $val;}
		if( $val > $max ){$max = $val;}
		}
	$x = $row["County"]; 
	$y = $row["Year"]; 
	array_push($series,$y);
	unset($row["County"], $row["Year"]);
	$data[$x][$y] = $row;
	}

$series = array_unique($series);

$filter = "<ul class='filter_list'>";

foreach($series as $s){
	$filter .= "<li class='";
	if($s == "2004"){
		$filter.="active";
		}
	$filter .= "'><div class='cbox'></div>{$s}</li>";
	}
$filter .= "</ul>";

$lmax = getHex($colors,$max,$max);
$lmin = getHex($colors,$min,$max);
$svg = "";
$result = $db->query("SELECT * FROM {$v['geoTable']} ");

while($row=$result->fetchArray()){
	$path = $row['svgPath'];
	$name =  $row['name'];
	$val = $data[$name][2004]["ALCRASH"];
	$c = getHex($colors,$val,$max);
	$svg .= "<path class='unit' d='{$path}' data-unit='{$name}' style='fill:{$c}'/>";
	$h = ($val/2500)*100;
	}	

$axis = "";
$lines = "";
$increment = 500;
$axis_max = round(($max/$increment), 0, PHP_ROUND_HALF_UP ) * $increment;
$labels = range(0, $axis_max, $increment);
$step = ($increment/$axis_max)*100;
foreach($labels as $l){
	$top = 100-(($l/$axis_max)*100);			
	$axis .= "<div class='label' style='top:{$top}%'>{$l}</div>";
	$lines .= "<div class='line' style='top:{$top}%'></div>";
	}

?>

<html>
<head>
<style>
path{stroke:#FfFfFf; stroke-width:1; cursor:pointer;}

html,body{
	height:100%;
	width:100%;
	margin:0px;
	padding:0px;
	font-family:Arial,sans-serif;
	background:lightgray;
	overflow:hidden;
	}
h2{
	margin:10px;
	}
#nav{
	list-style:none;
	position:absolute;
	margin:0px 5px;
	padding:0px;
	top:10px;
	right:30px;
	z-index:100;
	}
li.nav, #filter{
	width:65px;
	height:30px;
	line-height:30px;
	float:left;
	margin:0px 5px;
	border-radius:4px;
	background:gray;
	background:rgba(0,0,0,0.5);
	padding:0px;
	font-weight:bold;
	cursor:pointer;
	color:white;
	text-align:center;
	position:relative;
	}
li.nav:hover, li.nav.active{
	background:rgba(0, 153, 255, 1);
	}
.section{
	position:absolute;
	width:100%;
	left:0px;
	z-index:1;
	}
#vtitle{
	text-transform: uppercase;
	font-weight: bold;
	margin: 0px;
	line-height:20px;
	padding: 15px 10px;
	padding-right: 255px;
	font-size: 20px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	}
#legend{
	margin:10px;
	position:absolute;
	bottom:0px;
	left:0px;	
	height:150px;
	width:30px;
	border:1px solid white;
	<?php echo "background: {$lmax}; /* Old browsers */
	background: -moz-linear-gradient(top,  {$lmax} 0%, {$lmin} 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,{$lmax}), color-stop(100%,{$lmin})); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  {$lmax} 0%,{$lmin} 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  {$lmax} 0%,{$lmin} 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  {$lmax} 0%,{$lmin} 100%); /* IE10+ */
	background: linear-gradient(to bottom,  {$lmax} 0%,{$lmin} 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='{$lmax}', endColorstr='{$lmin}',GradientType=0 ); /* IE6-9 */";
	?>
	}
.label{
	position:absolute;
	right:0px;
	height:20px;
	line-height:20px;
	margin-top:-10px;
	padding:0px 5px 0px 10px;
	text-align:right;
	font-size:12px;
	color:white;
	font-weight:bold;
	text-shadow:1px 1px 1px gray;
	}
.line{
	position:absolute;
	height:0px;
	width:100%;
	border-bottom:2px groove white;
	}
.bar{
	position:absolute;
	bottom:0px;
	box-shadow:1px 1px 2px gray;
	}
.barset{
	cursor:default;
	}
.barset:hover{
	background:rgba(255,255,255,0.3);
	}
.blabel{
	position: absolute;
	bottom: -25px;
	height: 20px;
	line-height: 20px;
	left: 0px;
	text-transform: uppercase;
	font-size: 12px;
	padding: 0px 10px;
	margin: 0px;
	white-space: nowrap;
	}
.blabel.hover{
	background:white;
	width:auto;
	border-radius:3px;
	box-shadow:1px 1px 2px gray;
	}
.barset{
	position:absolute;
	bottom:0px;
	height:100%;
	}
#chart_legend{
	list-style: none;
	position: absolute;
	right: 0px;
	margin: 10px;
	padding: 0;
	z-index:1000;
	}
#chart_legend li{
	height: 20px;
	width: 20px;
	margin-bottom: 10px;
	position: relative;
	}
#chart_legend li div{
	font-size: 12px;
	line-height: 20px;
	white-space: nowrap;
	right: 25px;
	position: absolute;
	}
#lmax,#lmin{
	position: absolute; 
	left: 38px; 
	white-space: nowrap; 
	font-size: 12px; 
	line-height: 20px;
	font-weight:bold;
	}
#filter_menu{
	padding: 6px 0px;
	position: absolute;
	top: 45px;
	right: 40px;
	border: 2px solid gray;
	background: #FfFfFf;
	background: rgba(255,255,255,0.8);
	border-radius: 4px;
	z-index:100;
	}
#filter.open, #filter:hover{
	background:rgb(0, 146, 53);
	}
.filter_list{
	list-style:none;
	color:#000000;
	margin:3px;
	padding:0;
	}
.filter_list li{
	font-size: 12px;
	font-weight: normal;
	line-height: 18px;
	text-align: left;
	padding: 3px 6px 3px 24px;
	margin: 0px;
	position: relative;
	width: 90px;
	cursor:pointer;
	}
.cbox{
	width: 8px;
	height: 8px;
	border: 2px solid gray;
	position: absolute;
	left: 6px;
	top: 6px;
	}
.filter_list li.active .cbox{
	background:#0099FF;
	border-color:#0099FF;
	}
.filter_list li:hover{
	background:#DdDdDd;
	}

</style>
<script src="/jQuery/jquery-1.11.1.min.js"></script>
<script>
var colors = {
	3: ["#a6cee3","#1f78b4","#b2df8a"],
	4: ["#a6cee3","#1f78b4","#b2df8a","#33a02c"],
	5: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99"],
	6: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c"],
	7: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f"],
	8: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00"],
	9: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6"],
	10: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6","#6a3d9a"],
	11: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6","#6a3d9a","#ffff99"],
	12: ["#a6cee3","#1f78b4","#b2df8a","#33a02c","#fb9a99","#e31a1c","#fdbf6f","#ff7f00","#cab2d6","#6a3d9a","#ffff99","#b15928"]
	};

var data = <?php echo json_encode($data);?>;
var series = <?php echo json_encode($series);?>;
var axis_max = <?php echo $axis_max;?>;

$(document).ready(function(){
	
	var w = 0; 
	$(".label").each(function(){ 
		var x = $(this).outerWidth(); 
		if(x>w){w=x;}  
		});
	$("#axis").width(w);
	
	layout();
	
	$(".nav").on("click",function(){
		var section = "#"+$(this).attr("data-section");
		$(".nav").removeClass("active");
		$(this).addClass("active");
		$(".section").css({"left":"5000em"});
		$(section).css({"left":"0em","display":"none"}).fadeIn();
		});
	$("body").on("click",".filter_list li", function(){
		$(this).toggleClass("active");
		});
	$("body").on("mouseover",".barset",function(){
		var x = $(this).attr("data-name");
		$(this).find(".blabel").html(x).addClass("hover");
		});
	$("body").on("mouseout",".barset",function(){
		var x = $(this).attr("data-abbr");
		$(this).find(".blabel").html(x).removeClass("hover");		
		});
		
	$(window).resize(function(){layout();});
	barchart(data,[2004,2005],["ALCRASH"]);
	
	});

function layout(){
	var t = $("#vtitle").outerHeight();
	var h = $("body").height() - t;
	var w = $("body").width();
	$(".section").css({'height':h,'top':t });
	$("#lines,#axis,#bars").height( (h-30) );
	
	var aw = $("#axis").outerWidth();
	var bw = (w - aw);	
	$("#barchart, #lines").css({"left":aw, "width":bw });
	}

function barchart(data,series,columns){
	var bars = "";
	var legend = "";
	var left = 0;
	var num_bars = series.length * columns.length;
	var color_set = ( num_bars < 4 ? 3 : num_bars );
	var width = (num_bars==1 ? 30:(num_bars==2 ? 15: 10) );
	var set_width = (num_bars * width) + ((num_bars-1)*5) + 20;
	var z = 10000;
	
	var test = "AAA"
	$("body").append("<div id='tester' class='blabel'>"+test+"</div>");
	while( $("#tester").outerWidth() <= set_width ){
		test+="A";
		$("#tester").text(test);
		}
	var abbr = test.length - 1;
	$("#tester").remove();	
	

	for(d in data){
		var p=0;
		var a = d.substr(0,abbr);
		bars+="<div class='barset' data-name='"+d+"' data-abbr='"+a+"' style='left:"+left+"px; width:"+set_width+"px; z-index:"+z+";'>";
		bars+="<div class='blabel'>"+a+"</div>";
		var sleft = 10;
		for(s in series){
			for(c in columns){
				var val = data[d][series[s]][columns[c]];
				var height = (val/axis_max) * 100;
				var color = colors[color_set][p];
				bars+="<div class='bar' data-value='"+val+"'"; 
				bars+="style='height:"+height+"%; left:"+sleft+"px; width:"+width+"px; background:"+color+"'></div>"
				sleft+=width+5;
				p+=1;
			}
		}
		bars+="</div>";
		left+=set_width;
		z=z-1;
	}
	
	var p = 0
	for(s in series){
		for(c in columns){
			var color = colors[color_set][p];
			var label = "";
			if(columns.length == 1){
				label = series[s];
			}else{
				label = columns[c]+", "+series[s];
			}
			legend+="<li style='background:"+color+";'><div>"+label+"</div></li>";			
			p+=1;
		}
	}
	
	$("#chart_legend").html(legend);
	$("#bars").html(bars).width(left+50);

}

function filter_menu(){
	$("#filter").toggleClass("open");
	$("#filter_menu").toggle("fast");	
}

</script>
</head>
<body>
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
		<li id="filter" onclick="filter_menu()">
			Options
		</li>			
	</ul>
	<div id="filter_menu" style="display:none;">
		<?php echo $filter;?>
	</div>
	<div id="vtitle">
		<?php echo $v["title"]; ?>
	</div>
	<div id="map" class="section" style="">
		<svg width='100%' height='95%' style="display:block; margin:5px auto;" viewbox="0 0 500 510">
			<?php echo $svg; ?>
		</svg> 
		<div id="legend">
			<div id="lmax" style='top:0px;'>
				<?php echo $max." Crashes"; ?>
			</div>
			<div id="lmin" style='bottom:0px;'>
				<?php echo $min." Crashes";?>
			</div>
		</div>
	</div>
	<div id="chart" class="section" style="left:5000em;">	
		<div id="axis" style="position:absolute; top:0px; left:0px; z-index:3">
			<?php echo $axis; ?>
		</div>
		<div id="lines" style="position:absolute; top:0px; z-index:1">
			<?php echo $lines; ?>
		</div>
		<div id="barchart" style="position:absolute; z-index:2; overflow-x:scroll; height:100%; overflow-y:hidden; padding-bottom:100px">
			<div id="bars" style="position:relative;"></div>
		</div>
		<ul id="chart_legend"></ul>
	</div>
	<div id="table" class="section" style="left:5000em;">
		
	</div>
</body>
</html>