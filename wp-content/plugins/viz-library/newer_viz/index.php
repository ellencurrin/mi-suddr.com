<html>
<head>	
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
<script src="../jQuery/jquery-1.11.1.min.js"></script>
<script>
	<?php include("setup.php"); ?>
</script>
<script src="chartist/chartist.js"></script>
<link rel="stylesheet" href="chartist/chartist.css">
<script src="script.js"></script>
</head>
<body>
	
<!-- ================================================================= -->
<!-- NAVIGATION NAVIGATION NAVIGATION NAVIGATION NAVIGATION NAVIGATION -->
<!-- ================================================================= -->

<?php if( $_GET["embed"] == false ): ?>

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

<?php endif;?>

<!-- =============================================================== -->
<!-- MAP MAP MAP MAP MAP MAP MAP MAP MAP MAP MAP MAP MAP MAP MAP MAP -->
<!-- =============================================================== -->

	<div id="map" class="section" style="">
		<div id="info" style="display:none;">
			<div style="background:#ffffff; padding:5px 10px;">
				<div id="unit"></div>
				<div id="value"></div>
			</div>
		</div>
		
		<dl id="series">
			<?php echo $m_opts; ?>		
		</dl>

		<dl id="animate">
			<dt id="play" onclick="PlayData.start()">
				<div class="arrow" style="border-left:25px solid #333333;"></div>
				<b style="color:#333333">Play Data</b>
			</dt>
			<dt id="playing" style="display:none">
				<div class="arrow" style="border-left:25px solid #888888;"></div>
				<b style="color:#888888">Playing . . .</b>
			</dt>
		</dl>
		
		<div id='canvas' style="position:absolute;left:80px; height:90%; bottom:5%;"></div>

		<div id="meta">
			<h4><?php echo $v["title"];?></h4>
			<dl id="meta_inner">
				<dt>Description</dt>
					<dd><?php echo $v["description"]; ?></dd>
				<dt>Source</dt>
					<dd><?php echo $v["source"]; ?></dd>
				<dt>Dates</dt>
					<dd><?php echo $v["timeframe"]; ?></dd>
			</dl>
		</div>

		<div id="sidebar" style="display:none">
			
		</div>

		<dl id="legend">
			<?php echo $legend; ?>
		</dl>

	</div>

<!-- ======================================================================= -->
<!-- CHART CHART CHART CHART CHART CHART CHART CHART CHART CHART CHART CHART -->
<!-- ======================================================================= -->
	
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
	
<!-- ======================================================================= -->
<!-- TABLE TABLE TABLE TABLE TABLE TABLE TABLE TABLE TABLE TABLE TABLE TABLE -->
<!-- ======================================================================= -->

	<div id="table" class="section" style="left:5000em;">	
		<table id="hrow"></table>
		<div id="tcont" style="height:100%; width:100%; overflow:auto;">	
			<table id="dtable">

			</table>
		</div>
	</div>

<!-- =============================================================================== -->
<!-- OPTIONS OPTIONS OPTIONS OPTIONS OPTIONS OPTIONS OPTIONS OPTIONS OPTIONS OPTIONS -->
<!-- =============================================================================== -->
	
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

<!-- =============================================================================== -->
<!-- DOWNLOADS DOWNLOADS DOWNLOADS DOWNLOADS DOWNLOADS DOWNLOADS DOWNLOADS DOWNLOADS -->
<!-- =============================================================================== -->

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