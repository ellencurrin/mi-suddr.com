<?php
/*
Template Name: Results
*/
?>

<?php $base = get_template_directory_uri()."/images/"; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( ' | ', true, 'right' ); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<?php wp_head(); ?>
<style>
#mc{
	width:100%;
	background:#A0B6D3;
	background:#DeDeDe;
	padding:75px 0 0;
	margin:0px;
	}
#main{
	width:750px;
	padding:0px 10px 10px 250px;
	margin:0px auto;
	position:relative;
	min-height:1100px;
	}
#fc{
	border-top:10px solid #FfFfFf;	
	}
#filter_form{
	position:absolute;
	top:0px; left:0px;
	width:225px;
	padding:15px 0px 10px;
	margin:0px auto;
	background:#FfFfFf;
	overflow:visible;
	}
dl.category{
	width:100%;
	list-style:none;
	padding:0px;
	margin:0px 0px 25px 0px;	
	}		
dl.category dt{
	margin:0px;
	padding:0px 0px 0px 20px;
	width:215px;
	text-transform: uppercase;
	font: bold normal 15px/24px Arial;
	color: #555555;
	}
dl.category dd{
	background-image: url("<?php echo $base; ?>symbols/cbox_black_small.png");
	background-repeat: no-repeat;
	background-position: 10px top;
	color: #000000;
	position: relative;
	margin: 0px;
	padding: 7px 10px 7px 43px;
	width:172px;
	overflow: visible !important;
	font: 400 normal 14px/22px Arial, sans-serif;    
	cursor:pointer;
	-webkit-transition:background-color 200ms;
	transition:background-color 200ms;	
	}
dl.category dd b{
	display:none;
	position: absolute;
    width: 150px;
 	top:0px; left:230px;
    background: #cccccc;
    color: #333;
    padding: 5px 10px;
    z-index: 1000;
    box-shadow: 0px 0px 2px #333333;
    font-weight: bold;
    font-size: 14px;
    line-height: 18px;
	}
dl.category dd.active, #checkbox{
	background-image: url("<?php echo $base; ?>symbols/cbox_active_black_small.png");
	}
dl.category dd:hover{
	background-color:#CcCcCc;
	}
dl.category dd:hover b{
	display:block;
	}
#substance dd img{
	display: none;
	}
.go{
	font: bold normal 18px/24px Arial, sans-serif;
	padding: 5px 0px;
	margin: 20px auto;
	display: block;
	cursor: pointer;
	text-decoration: none;
	border: 3px solid green;
	background:green;
	color:white;
	width:185px;
	text-align:center;
	}
.go:hover{
	color: green;
	background:#FfFfFf;
	}
#collapse{
	position:absolute;
	right:10px;
	bottom:6px;
	height:36px;
	width:36px;
	background-image:url("<?php echo $base; ?>symbols/collapse_medium.png");	
	background-position: right center;
	background-repeat: no-repeat;
	border-radius:4px;
	cursor:pointer;
	}
#collapse:hover{
	background-color:#DdDdDd;
	}	
.closed #collapse{
	background-position: left center;
	}
.closed .go, .closed #filter_form{
	display:none;
	}
#search_terms{
	width:940px;
	line-height:30px;
	font-size:18px;
	font-weight:bold;
	color:#3A9100;
	margin-bottom:20px;		
	}
#parameters{

	}
.closed #parameters{
	display:block;
	}
	
.result{
	padding:0px 15px 0px 65px;
	margin:0px 0px 25px 0px;
	background: #FfFfFf;
	color: #333333;
	position:relative;
	border-top:2px solid #444;
	}
.result:hover{
/*	outline:4px solid #FfFfFf;*/
/*	box-shadow:2px 2px 4px 3px rgba(0,0,0,0.5);*/
	}
.result h4{
	color:#333333;
	font-size:18px;
	line-height:24px;
	margin:10px 0px 10px 0px;
	cursor:pointer;
	}
.result h4:hover{
	text-decoration:underline;
	color:#0F4FA8;
	}
#vc{
	width:100%;
	position:fixed;
	display:none;
	background:#EeEeEe;
	z-index:10;
	}
#viz, #viz iframe{
	width:100%;
	height:100%;
	border:0;
	padding:0;
	margin:0;
	}
#vClose{
	position:absolute;
	right:0px;
	top:0px;
	height:35px;
	width:35px;
	line-height:35px;
	text-align:center;
	text-decoration:none;
	font-weight:bold;
	color:white;
	font-size:30px;
	z-index:10;;
	}
#vClose:hover{
	color:red;
	}
.desc{
	font-size: 16px;
	line-height:22px;
	color: #444444;
	padding: 0px;
	margin: 10px 0px 0px;
	font-family:Georgia,serif;
	display:block;
	overflow:visible;
	}
.tframe{
	color: #003C00;
	font-size: 14px;
	line-height:20px;
	font-weight:400;
	padding: 0px;
	margin: 10px 0px 0px;
	}
.rtags{
	font-size:14px;	
	}
.thumbs{
	position:absolute;
	height:100%;
	width:50px;
	left:0px;
	top:0px;
	margin:0px;
	padding:3px 0px;
	background:#444444;
	}
.thumbs a{
	float:right;
	height:26px;
	width:26px;	
	position:relative;
	margin:5px 12px;
	}
.thumbs a img{
	position:absolute;
	width:100%;
	height:auto;
	bottom:0px;
	}

@media 
(-webkit-min-device-pixel-ratio: 2), 
(min-resolution: 150dppx) { 

	dl.category dd{
		background-image:url("<?php echo $base; ?>symbols/cbox_black_large.png");
		background-size:35px;
		}
	dl.category dd.active, #checkbox{
		background-image:url("<?php echo $base; ?>symbols/cbox_active_black_large.png");
		background-size:35px;
		}
	#collapse{
		background-image:url("<?php echo $base; ?>symbols/collapse_large.png");
		background-size:72px;		
		}

}
	
</style>
<script>
jQuery(document).ready(function(){
	window.$ = jQuery;
	$("dl.category dd").on("click",function(){ 
		$(this).toggleClass("active"); 
		createQuery();
		});

    $("body").on("click",".result h4",function(){
	  	var url = "<?php echo vizURL(); ?>/viz/?vid="+$(this).attr("data-vid");
		$("body").css({"overflow":"hidden"});
	  	$("#viz").html("<iframe src='"+url+"'></iframe>");
	  	$("#vc").fadeIn();
    	})
    layout();
    $(window).resize(function(){layout();});

<?php if(isset($_GET["tags"])): ?>
	var tags = "<?php echo $_GET["tags"];?>";
	var parameters = [];
	$("dl.category dd").each(function(){
		var d = $(this).attr("data-value");
		if( tags.search(d) > -1 ){ 
			$(this).addClass("active"); 
			parameters.push(d);
			}
		$("#parameters").html(parameters.join(",&nbsp;") );
	});
<?php else: ?>
	$("#parameters").html("ALL");
<?php endif; ?>
	createQuery();

});

function createQuery(){
	var query = [];
	$(".category").each(function(){
		var v = $(this).find("dd.active").map(function(){ return $(this).attr("data-value"); }).get();
		if(v.length>0){ query.push(v.join(",")) };
		});

	var q = encodeURIComponent( query.join(";") );

	var url = "http://www.mi-suddr.com/data/?";
	// var url = "http://localhost/~nicholas/mi-suddr/?page_id=56&";
	if(query.length > 0){
		url += "tags="+q;
		}

	$("#search")[0].href = url;

	}

function layout(){
	var t = $("#hc").outerHeight() + parseFloat($("#hc").css("top"));
	var h = $("body").height() - t;
	$("#vc").css({"height":h+"px", "top":t+"px"});
	}

function expand(){ 	
	$("#query").toggleClass("closed");
	}
</script>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">

<header>
	<div id="hc">
		<div id="header">
			<a id="logo" href="http://www.mi-suddr.com" style="float:left; text-decoration:none;">
			  <img src="<?php echo $base; ?>mdhhs-suddr-logo.png" style="height:40px; width:auto; border:none;" border="0">
			</a>
			<?php wp_nav_menu( array( "menu" => 'main', 'menu_id'=> "nav", 'container' => "nav" ) ); ?>
		</div>
	</div>
</header> 


<div id="mc" style="min-height:400px;">

	<div id="main"> 		


	<?php include("filter.php"); ?>


	<div id="search_terms">Results For:&nbsp;&nbsp;<span id="parameters"></span></div>

	<?php 
	$r;	
	if(isset($_GET["tags"])){
		$where = "";
		$tags = explode(";",$_GET["tags"]);	
		foreach($tags as $t){
			$x = explode(",",$t);
			if ($where !== "" ){ 
				$where .= " AND ";
				}
			$where .= "(tags like '%[".implode($x,"]%' or tags like '%[")."]%')";
		}
		$r = getVizzes($where);
		}
	else{
		$r = getVizzes();
		}

	$i=0;
	$tags = array("Cigarettes"=>"cigarettes.png",
		"Alcohol"=>"alcohol.png",
		"Illicit Drugs"=>"illicit.png",
		"Marijuana"=>"marijuana.png",
		"Rx Drugs"=>"rx-drugs.png"
		);
	while($row=$r->fetchArray(SQLITE3_ASSOC)){
		$lid = $row["lid"];
		echo "<div class='result'>";
		echo "<h4 data-vid='{$lid}'>{$row['title']}</h4>";
		echo "<p class='desc'>{$row['description']}</p>";
		echo "<p class='tframe'><b>Timeframe:</b> {$row['timeframe']}</p>";
		$t = str_replace(array("[","]",","),array("","",", "),$row['tags']);
		echo "<p class='rtags'><b>Tags:</b> {$t}</p>";
		echo "<div class='thumbs'>";
		$t = explode(", ",$t);

		foreach($t as $v){
			if( $tags[$v] ){
			echo "<a href='http://mi-suddr.com/data/?tags={$v}'><img src='{$base}tags/{$tags[$v]}'></a>";
			}
		}
		echo "</div></div>";
		$i++;
	}

	if($i==0){
		echo "<h2>No Results</h2>";
	}

	?>
		 
	</div>
</div>

<div id="vc">
	<a href="#" id="vClose" onclick="$(this).parent().fadeOut(); $('body').css({'overflow':'initial'});" >&times;</a>
	<div id="viz"></div>
</div>

<?php get_footer(); ?>