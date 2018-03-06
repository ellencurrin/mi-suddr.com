<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Catch Themes
 * @subpackage Catch_Box
 * @since Catch Box 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_uri(); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>

<?php 
/** 
 * catchbox_before hook
 */
do_action( 'catchbox_before' ); ?>

<div id="page" class="hfeed">

	<?php 
    /** 
     * catchbox_before_header hook
     */
    do_action( 'catchbox_before_header' ); 
    ?> 
    
	<header id="branding" role="banner">

    	<?php 
		/** 
		 * catchbox_before_headercontent hook
		 */
		do_action( 'catchbox_before_headercontent' ); ?>
            
    	<div id="header-content" class="clearfix">
		<div class="logo-wrap clearfix">
	   	<div id="hgroup" class="site-details">
	   		<h1 id="site-title">
	   			<img src="http://www.mi-suddr.com/wp-content/themes/catch-box-child/images/mdch.png"  style="float:left; height:58px; margin-right:10px;"/>
	   			<a href="http://mi-suddr.com/" title="Michigan Substance Use Data Repository" rel="home">
	   			Michigan Substance <br>
	   			Use Data Repository
	   			</a>
	   		</h1>
	       		<h2 id="site-description"></h2>
   		</div><!-- #hgroup -->   
		</div>
		
		<form method="get" id="searchform" action="http://mi-suddr.com/">
		        <label for="s" class="assistive-text">Search</label>
		        <input type="text" class="field" name="s" id="s" placeholder="Search">
		        <input type="submit" class="submit" name="submit" id="searchsubmit" value="Search">
		</form>
	</div><!-- #header-content -->
        
    	<?php 
		/** 
		 * catchbox_after_headercontent hook
		 *
         * @hooked catchbox_header_menu - 10
		 */
		do_action( 'catchbox_after_headercontent' ); ?>           
                
	</header><!-- #branding -->
    
	<?php 
    /** 
     * catchbox_after_header hook
     */
    do_action( 'catchbox_after_header' ); 
    ?>    

	<?php 
    /** 
     * catchbox_before_main hook
     */
    do_action( 'catchbox_before_main' ); 
    ?>
        
	<div id="main" class="clearfix">

		<?php 
        /** 
		 * catchbox_before_primary hook
		 *
		 */
        do_action( 'catchbox_before_primary' ); ?>
        
		<div id="primary">
        
			<?php 
            /** 
             * catchbox_before_content hook
             *
             */
            do_action( 'catchbox_before_content' ); ?>
        
			<div id="content" role="main">
				<?php 
                /** 
                 * catchbox_content hook
                 *
                 * @hooked catchbox_slider_display - 10
                 */
                do_action( 'catchbox_content' ); ?>