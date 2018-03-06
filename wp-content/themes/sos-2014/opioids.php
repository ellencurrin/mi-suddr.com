<?php
/*
Template Name: Opioids
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
		padding:0px;
		margin:0px;
		}
	#main{
		position:relative;
		min-height:1100px;
		}
	.chunk{
		width:970px;
		margin:0px auto;
		padding:15px 0px 40px;
		}
	#intro{
		background-color:#214478;
		padding:85px 10px 15px;
		margin:0px auto;
		}
	h1{
		font-weight:400;
		font-size:45px;
		margin:0px 0px 25px;
		}
	h2{
		font-size:28px;
		font-weight:600;
		margin:0px 0px 18px;
		}
	p{
		font-family:Georgia,serif;
		font-size:17px;
		font-weight:400;
		letter-spacing:.5px;
		margin:0px 0px 15px;
		line-height:1.7;
		}
	.link{
		font-family:Georgia,serif;
		font-size:16px;
		font-weight:400;
		letter-spacing:.5px;
		margin:0px 0px 15px;
		line-height:1.7;			
		}
	#infographics{
		list-style:none;
		overflow:hidden;
		width:970px;
		height:200px;
		margin:25px auto;
		padding:0px;
		}
	#infographics li{
		float:left;
		width:225px;
		margin:0px 20px 0px 0px;
		height:200px;
		background:#EEE;
		}
	#infographics li h2{
		text-align: center;
	    font-size: 44px;
	    margin: 15px auto;
	    font-weight: bold;
	    color: #666666;
		}
	#infographics li h4{
		text-align: center;
	    margin: 0px 20px;
	    font-family: Georgia, serif;
	    font-weight: 400;
	    color: #333;
		}		
	#viz_nav{
		list-style:none;
		padding:0px;
		margin:0px;
		}
	#viz_nav li{
		float:left;
		display:block;
		cursor:pointer;
		margin:0px 15px 20px 0px;
		line-height:40px;
		color:white;
		background:#AaAaAa;
		padding:0px 10px;
		font-weight:bold;
		}
	#viz_nav li.active, #viz_nav li:hover{
		background:#214478;	
		}
</style>
<script>
	jQuery("document").ready(function(){
		$ = jQuery;
		$("#viz_nav li").click(function(){			
			$("#viz_nav li").removeClass("active");
			$(this).addClass("active");
			var x = $(this).attr("data-viz");
			document.getElementById("viewer").src = "<?php echo vizURL(); ?>/newer_viz/?vid="+x+"&embed=1";
			
		});
		
	});
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
 		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		 <div id="intro">
			<div style="width:770px; padding:0px 200px 0px 0px; margin:0px auto; color:#FfFfFf;">		 
				<h1>The Opioid Epidemic in Michigan</h1>
				<h2>Why It Matters</h2>
				<?php 
				if ( has_post_thumbnail() ) { the_post_thumbnail(); }
				the_content(); 
				?>
				<img src="<?php echo $base; ?>/opioid_molecule.png" style="position:absolute; top:0px; right:15px; height:250px; width:auto;">
			</div>
 		</div>
		<?php endwhile; endif; ?>
		
		<ul id="infographics">
			<li>
				<h2>650,000</h2>
				<h4>Number of opioid prescriptions dispensed every day in the United States</h4>
			</li>
			<li>
				<h2>3,900</h2>
				<h4>Number of people who begin abusing prescription opioids every day throughout the United States</h4>				
			</li>
			<li>
				<h2>580</h2>
				<h4>Number of people who begin using heroin in the United States every day</h4>				
			</li>
			<li style="margin-right:0px">
				<h2>90+</h2>
				<h4>People who die every day in the United States from opioid-related overdoses.</h4>				
			</li>
		</ul>
		
		<div id="tool" class="chunk">
			<h2>Current Data</h2>
			<ul id="viz_nav">
				<li data-viz="54">Opioid-Related Drug Poisoning Deaths</li>
				<li data-viz="49" class="active">Opioid-Related Hospitalizations</li>
				<li data-viz="50">Opioid Prescriptions</li>
			</ul>
			<iframe id="viewer" src="<?php echo vizURL(); ?>/newer_viz/?vid=49&embed=1" style="height:500px; width:100%; background:#EEE; border:none;">

			</iframe>
			
		</div>
		<div id="related" class="chunk">
			<h2>Related Data &amp; Reports</h2>
			<?php
						
				$r = getVizzes("tags like '%Opioid%' ");
				while($row=$r->fetchArray(SQLITE3_ASSOC)){
					$url = vizURL()."viz/?vid=".$row["lid"];
					echo "<div class='{$row["type"]} link'><a href='$url' target='_blank'>{$row["title"]}</a></div>";
				}
			?>
		</div>
		<div id="sources" class="chunk">
			<h2>Additional Resources</h2>
			<div class="link">
				<a href="https://www.cdc.gov/vitalsigns/opioids/index.html" target='_blank'>Centers for Disease Control: Protect patients from opioid overdose</a>
			</div>
			<div class="link">
				<a href="http://www.michigan.gov/stopoverdoses" target='_blank'>MDHHS: Combating the Prescription Drug and Opioid Epidemic in Michigan</a>
			</div>
			<div class="link">
				<a href="www.michigan.gov/hepatitisaoutbreak" target='_blank'>MDHHS: Michigan Hepatitis A Outbreak</a>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>