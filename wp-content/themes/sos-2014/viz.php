<style>
#viz{
	font:normal normal 12px/20px Arial, sans-serif;
	height:100%;
	display:none;
	position:fixed;
	top: 67px;
	width: 100%;
	z-index: 10;
	background: gainsboro;
	}
.admin-bar #viz{
	top:95px;
	}
#vc{
	background:#B6B6B6;
	height:35px;
	line-height:35px;
	position:relative;
	
	}
#tabs{
	margin:0 auto;
	padding:0;
	list-style:none;
	overflow:auto;
	float:left;
	}
#tabs li{
	color:white;
	font-weight:bold;
	text-align:center;
	line-height:21px;
	height:21px;
	float:left;
	padding:7px 50px;
	font-size:14px;
	cursor:pointer;
	text-transform:uppercase;
	cursor:pointer;
	}
#tabs li:hover, #tabs li.selected{
	background:#555555;
	box-shadow:0px 0px 6px #555555;
	}
#sections{
	position:relative;
	box-shadow:0px 0px 6px gray;
	}
.section{
	font-size:40px;
	color:gray;
	text-align:center;
	line-height:50px;
	padding-top:10px;
	}
table{
	border-collapse:collapse;
	
	}
tr{
	height:24px;
	background:whitesmoke;
	}
</style>
<script type="text/javascript">
jQuery("document").ready(function(){
	layout();
	jQuery(window).resize(function(){ layout(); });
	jQuery("#tabs li").click(function(){
		$("#tabs li").removeClass("selected")
		var id = "#"+$(this).addClass("selected").attr("data-section");
		jQuery(".section").hide().removeClass("selected");
		jQuery(id).fadeIn();
		});
	});
	
function layout(){
	h = jQuery("#wrapper").height() - 40;
	jQuery("#sections").height(h+"px");
	var m = ( jQuery("#wrapper").width() - jQuery("#tabs").width() )/2;
	jQuery("#tabs").css({"margin-left":m+"px"});
	}

function vizHide(){
	jQuery("#viz").fadeOut();
	$("body").css({"overflow":"auto"});
	}	

</script>
<div id="viz">
	<div id="vc">
		<ul id="tabs">
			<li class="selected" data-section="map">Map</li>
			<li data-section="chart">Chart</li>
			<li data-section="table">Table</li>
			<li data-section="details">Details</li>
		</ul>
		<div style="float:right;color:white;font:bold normal 28px/35px Arial;width:35px; text-align:center;cursor:pointer;"
		 onclick="vizHide()">&times;</div>		
	</div>
	<div id="sections">
		<div id="map" class="section">
		Map	
		</div>
		
		<div id="chart" class="section" style="display:none">
		Chart
		</div>
		<div id="table" class="section" style="display:none">
		Table
		<?php
		 
		 ?>		
		</div>
		<div id="details" class="section" style="display:none">
		Detail
		</div>
	</div>
</div>