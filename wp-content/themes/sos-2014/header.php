<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( ' | ', true, 'right' ); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">

<?php $base = get_template_directory_uri()."/images/"; ?>

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