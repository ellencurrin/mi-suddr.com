<html>
<head>
<script type="text/javascript" src="../jQuery/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="script.js"></script>
<script type="text/javascript">
	var paths = <?php echo file_get_contents("../geojson/Michigan_Counties.json"); ?>;
</script>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" title="no title" charset="utf-8">
</head>
<body onload="layout(); makeMap();">
<div id="m_opts">
	
</div>
<div id="map">
	
</div>
<div id="instructions" style="color:#EeEeEe; font-weight:bold; font-size:34px;">
	Click on a county to explore its demographics.
</div>	
<div id="sidebar">
	
	<h4 id="cname">Ingham County</h4>
	<div class="section">
		<h5>2014 Population Estimate</h5>
		<div id="tpop" style="color:white; font-size:40px; line-height:40px;">282,234</div>
		<div style="line-height:40px; font-size:40px; position:absolute; right:0px; bottom:0px;">
			<span id="pchange" style="color:green; font-weight:bold; font-size:18px; vertical-align:baseline; transition:200ms;">+0.5%</span>
		</div>
	</div>
	<div class="section">
		<h5>Race &amp; Ethnicity</h5>
		<dl id="race" class="brownie" style="height:30px">
			<dd data-total="70000" data-pct="70%" style="width:70%; background:green;" data-name="White"></dd>
			<dd data-total="13000" data-pct="13%" style="width:13%; background:#3333FF;" data-name="African American"></dd>
			<dd data-total="10000" data-pct="10%" style="width:10%; background:purple;" data-name="Hispanic or Latino"></dd>
			<dd data-total="4000" data-pct="4%" style="width:2%; background:salmon;" data-name="Asian"></dd>
			<dd data-total="2000" data-pct="2%" style="width:2%; background:lightblue;" data-name="Native American" ></dd>
			<dd data-total="2000" data-pct="2%" style="width:2%; background:orange;" data-name="Native Hawaiian or Pacific Islander" ></dd>
			<dd data-total="1000" data-pct="1%" style="width:1%; background:gray;" data-name="Other"></dd>
		</dl>
	</div>
	<div class="section">
		<h5>Families Living In Poverty</h5>
		<div>
			<span id="fp_pct" style="color:white; font-size:26px;">13.4%</span>
			<span style="font-size:14px; color:white;">&nbsp; &ndash; &nbsp;</span>
			<span id="fp_total" style="color:white; font-size:14px;">8,296 Families</span> 
		</div>
	</div>
	<div class="section">
		<h5>Employment Status</h5>
		<dl id="emp_status" class="brownie" style="height:30px">
			<dd data-total="70000" data-pct="70%" style="width:70%; background:#333333;" data-name="Employed"></dd>
			<dd data-total="13000" data-pct="20%" style="width:20%; background:#555555;" data-name="Unemployed"></dd>
			<dd data-total="10000" data-pct="10%" style="width:10%; background:#777777;" data-name="Not In Labor Force"></dd>
		</dl>
	</div>
	<div class="section">
		<h5>Educational Attainment</h5>
		<dl id="edu_attainment" class="brownie" style="height:30px">
			<dd data-total="70000" data-pct="70%" style="width:70%; background:#ccebc5;" data-name="Less than High School"></dd>
			<dd data-total="13000" data-pct="13%" style="width:10%; background:#a8ddb5;" data-name="High School Graduate"></dd>
			<dd data-total="10000" data-pct="10%" style="width:5%; background:#7bccc4;" data-name="Some College"></dd>
			<dd data-total="4000" data-pct="4%" style="width:5%; background:#4eb3d3;" data-name="Associate's Degree"></dd>
			<dd data-total="2000" data-pct="2%" style="width:5%; background:#2b8cbe;" data-name="Bachelor's Degree" ></dd>
			<dd data-total="2000" data-pct="2%" style="width:5%; background:#0868ac;" data-name="Graduate Degree"></dd>
		</dl>
	</div>
	
</div>

<div id="popup"></div>
<dl id="ttip"></dl>

</body>
</html>