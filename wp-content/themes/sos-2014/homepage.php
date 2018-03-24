<?php
/*
Template Name: Home
*/
?>
<?php $base = get_template_directory_uri()."/images/"; ?>
<?php 
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="0"/>
<title><?php wp_title( ' | ', true, 'right' ); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<?php wp_head(); ?>
<style>
#mc{
	width:100%;
	background:#A0B6D3;
	padding:0px;
	margin:0px;
	}
#fc{
	border-top:10px solid #FfFfFf;	
	}
#filter_form{
	width:100%;
	}
#filter{
	width:1000px;
	padding:20px 0px;
	margin:0px auto;
	}	
#cp-map{
	float:left;
	width:398px;
	}
dl.category{
	list-style:none;
	padding:0px 20px 15px;
	margin:0px;
	width:740px;
	overflow:visible;
	display:block;
	float:left;
	}	
dl.category dt{
	width:100%;
	margin:0px;
	text-transform: uppercase;
	font: normal bold 14px/20px Arial;
	overflow: visible;
	color: #FfFfFf;	
	}
dl.category dd{
	display: block;
	float: left;
	height: 35px;
	background: #0F4FA8;
	background-image: url("<?php echo $base; ?>symbols/cbox_small.png");
	background-repeat: no-repeat;
	background-position: left top;
	color: white;
	position: relative;
	margin: 5px 15px 5px 0px;
	padding: 0px 10px 0px 33px;
	overflow: visible !important;
	font: normal bold 16px/35px Arial, sans-serif;    
	cursor:pointer;
	-webkit-transition:background-color 100ms, box-shadow 100ms;
	transition:background-color 100ms, box-shadow 100ms;
	}
dl.category dd.active, #checkbox{
	background-image: url("<?php echo $base; ?>symbols/cbox_active_small.png");
	background-color:#08306B;
	}
dl.category dd:hover{
	background-color:#08306B;
/*	box-shadow:0px 0px 10px 3px rgba(255,255,255,0.9);*/
	box-shadow:1px 1px 3px rgba(0,0,0,0.7);	
	outline:2px solid #FfFfFf;
	}
dl.category dd b{
	display: none;
    top: 120%;
    z-index: 1000;
    background: white;
	position:absolute;
    left: 0px;
    font-size: 11px;
    line-height: 16px;
    padding: 5px 10px;
    width: 100px;
    text-align: center;
    box-shadow: 2px 0px 5px rgba(0,0,0,.9);
    color: #0F4FA8;
	}
dl.category dd:hover b{
	display:block;	
	}
#substance dd{
	width:122px;
	padding:92px 5px 0px;
	text-align:center;	
	}
#substance dd img{
	width: 80px;
	height: auto;
	display: block;
	position: absolute;
	bottom: 34px;
	left: 50%;
	margin-left:-40px; 
	}
.go{
	font: normal bold 30px/50px Arial, sans-serif;
	color: white;
	background: #3A9100;
	float: left;
	padding: 0px 15px;
	margin: 20px 20px 10px;
	cursor: pointer;
	width: 200px;
	-webkit-transition:background-color 200ms, box-shadow 200ms;
	transition:background-color 200ms, box-shadow 200ms;
	background-image:url("<?php echo $base; ?>symbols/arrow_medium.png");	
	background-position: 186px 6px;
	background-repeat: no-repeat;	
	}
.go:hover{
	background-color:#006d2c;
/*	box-shadow:0px 0px 10px 2px rgba(255,255,255,0.9);*/
	box-shadow:1px 1px 3px rgba(0,0,0,0.7);
	outline:3px solid #FfFfFf;
	}
a{
	text-decoration:none;
	}
.action_item{
	display: block; 
	float: left; 
	margin: 5px 25px 0px 0px; 
	padding: 0px 50px 0px 10px; 
	line-height: 40px; 
	background-color: #0F4FA8; 
	font-weight: bold; 
	color: white;
	cursor:pointer;
	-webkit-transition:background-color 200ms, box-shadow 200ms;
	transition:background-color 200ms, box-shadow 200ms;
	background-image:url("<?php echo $base?>symbols/arrow_small.png");	
	background-position: 92% 11px;
	background-repeat: no-repeat;
	}
.action_item:hover{
	background-color: #08306B;
	box-shadow:1px 1px 3px rgba(0,0,0,0.7);	
	outline:2px solid #FfFfFf;
	}
#welcome,#shadow{
	position:absolute; 
	width:740px; 
	padding:25px 10px;
	}
#welcome p, #shadow p{
	font-size:24px; 
	font-weight:bold; 
	line-height:30px; 
	margin:20px 0px; 
	padding:0px;
	}
#welcome h4, #shadow h4{
	font-size:40px; 
	font-weight:normal;
	color:#3A9100; 
	margin:10px 0px 20px; 
	padding:0px; 
	line-height:50px;
	}
	
@media 
(-webkit-min-device-pixel-ratio: 2), 
(min-resolution: 150dppx) { 

	dl.category dd{
		background-image:url("<?php echo $base; ?>symbols/cbox_large.png");
		background-size:35px;
		}
	dl.category dd.active, #checkbox{
		background-image:url("<?php echo $base; ?>symbols/cbox_active_large.png");
		background-size:35px;
		}
	.action_item{
		background-image:url("<?php echo $base; ?>symbols/arrow_medium.png");
		background-size:18px;
		}
	.go{
		background-image:url("<?php echo $base; ?>symbols/arrow_large.png");
		background-size:36px;
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
});

function createQuery(){
	var query = [];
	$(".category").each(function(){
		var v = $(this).find("dd.active").map(function(){ return $(this).attr("data-value"); }).get();
		if(v.length>0){ query.push(v.join(",")) };
		});

	var q = encodeURIComponent( query.join(";") );

	var url = "http://www.mi-suddr.com/data/";
	// var url = "http://localhost/~nicholas/mi-suddr/?page_id=56";
	if(query.length > 0){
		url += "?tags="+q;
		}

	$("#search")[0].href = url;
	
	}
	
</script>
</head>
<body <?php body_class(); ?> style="background:#EeEeEe;">
<div id="wrapper" class="hfeed">

<header>
	<div id="hc">
		<div id="header">
			<a id="logo" href="../" style="float:left; text-decoration:none;">
			  <img src="<?php echo $base; ?>mdhhs-suddr-logo.png" style="height:40px; width:auto; border:none;" border="0">
			</a>
			<?php wp_nav_menu( array( "menu" => 'main', 'menu_id'=> "nav", 'container' => "nav" ) ); ?>
		</div>
	</div>
</header> 

<img src="<?php echo $base; ?>autumn4.jpg" style="position:fixed; width:100%; min-width:100%; min-height:500px; z-index:0; top:53px; left:0px;" >

<div id="container" style="z-index:10; height:440px; width:980px; overflow:hidden;">
	<img src="<?php echo $base; ?>hexagons.png" style="position:absolute; width:130px; height:auto; z-index:0; left:60px; top:44px;">
	<div id="welcome" style="left:234px; top:0px; z-index:3;">
		<h4>
			Welcome to the all new Michigan Substance Use Data Repository.
		</h4>
		<p>Use this website to explore substance use and mental health data available for your county or region.</p>
		<p>The data on this site has been collected to help you make more informed decisions for programming. For more information see the About page.</p>
		<div style="overflow:visible;">
			<a href="http://mi-suddr.com/about/" class="action_item">Learn More</a>
			<a href="http://mi-suddr.com/data/" class="action_item">Browse Data</a>
		</div>		
	</div>
	<div id="shadow" style="left:235px; top:1px; z-index:2;">
		<h4 style="color:#FfFfFf;">
			Welcome to the all new Michigan Substance Use Data Repository.
		</h4>
		<p style="color:#FfFfFf;">
			Use this website to explore substance use and mental health data available for your county or region.	
		</p>
		<p style="color:#FfFfFf;">
			The data on this site has been collected to help you make more informed decisions for programming. For more information see the About page.
		</p>
	</div>	
</div> <!--end container-->

<!-- <div style="width:100%; background:#B3001B; border-top:2px solid #D38888; border-bottom:2px solid #410000">
	<div style="height:30px; width:980px; padding:5px; margin:0px auto; color:#FfFfFf; font-weight:bold; text-shadow:1px 1px 2px #410000; font-size:16px; line-height:30px; text-align:center;">
		We just relaunched!&nbsp; Please help us troubleshoot.&nbsp; Email any issues to
		<span style="text-decoration:underline;">info@mi-suddr.com</span>.
	</div>
</div> -->

<div id="mc" style="border-top:10px solid #0F4FA8;">
	<div id="filter">
		<div style="float:left; width:178px; padding:0px 20px; text-align:right; overflow:hidden;">
		    <h3 style="margin:0px 0px 10px 0px; font:bold normal 35px/35px Arial, san-serif; color:white; overflow:hidden;">
				FILTER DATA BY TOPICS
			</h3>		
		</div>
		<div style="padding:0px; float:left; border-left:2px solid #FfFfFf; width:780px;">
			<?php include("filter.php"); ?>
		</div>
	</div>
	<div id="profiles" style="background:#E0EEFF; width:100%; margin:0px 0px; border-top:10px solid white;">
	    <div style="font: bold normal 24px/35px Arial, san-serif; color: white; overflow: hidden; text-align: center;background-color: #0F4FA8;">
			<p style="margin: 0px;">COMMUNITY PROFILES</p>
		</div>
		<div>
			<h5 style="margin: 10px 0 10px 0; text-align: center;">CLICK ON ANY COUNTY TO EXPLORE ITS DEMOGRAPHICS.</h5>
		</div>	
		<iframe src="./wp-content/plugins/viz-library/profiles/" style="width:1000px; margin:10px auto; display:block; height:500px; border:0;" ></iframe>
		<!-- <iframe src="http://localhost/~nicholas/mi-suddr/wp-content/plugins/viz-library/profiles/" style="width:1000px; margin:10px auto; display:block; height:500px; border:0;" ></iframe> -->
	</div>
</div>


<?php get_footer(); ?>