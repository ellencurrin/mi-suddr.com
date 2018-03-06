<?php 
    /*
    Plugin Name: Viz Library
    Plugin URI: #
    Description: Plugin for managing data visualizations
    Author: Nicholas Tyler Miller
    Version: 1.0
    Author URI: #
    */
    
    function test(){

	$db = new SQLite3(__DIR__.'/vizzes.db');

	$base = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?page=vizLibrary";

	$vpage = 'library';
	if( isset( $_GET['vp'] ) ){
		$vpage = $_GET['vp'];
		} 
	
	$anv=""; $vav=""; $gts=""; $dts=""; $tag=""; $include="vizzes.php";
	
	if($vpage == 'library'){
		$include = "library.php";
		$lib = "active";
		}
	elseif($vpage == 'docs'){
		$include = "docs.php";
		$doc = "active";
		}
	elseif($vpage == 'tables'){
		$include = "tables.php";
		$dts = "active";
		}
	elseif($vpage == 'batch'){
		$include = "batch.php";
		$bat = "active";
		}
	elseif($vpage == 'geos'){
		$include = "save_geo.php";
		$gts = "active";		
		}
	elseif($vpage == 'viz'){
		$include = "viz.php";
		$anv = "active";		
		}
	elseif($vpage == 'tags'){
		$include = "tags.php";
		$tag = "active";		
		}
	
	echo "<div id='vizLibrary' class='wrapper' style='margin-right:20px'>
	  <h2 style='font-size:23px; margin-left:3px'>Viz Library</h2>
	  <div id='vizNav' style='border-bottom:2px solid #CcCcCc;'>
		<a class='{$lib}' href='{$base}&vp=library'>View Library</a>
		<a class='{$anv}' href='{$base}&vp=viz&action=add'>Add New Viz</a>
		<a class='{$doc}' href='{$base}&vp=docs&action=add'>Add Document</a>
		<a class='{$dts}' href='{$base}&vp=tables'>Data Tables</a>
		<a class='{$gts}' href='{$base}&vp=geos'>Geographies</a>
		<a class='{$tag}' href='{$base}&vp=tags'>Tags</a>
 	  </div>";
	
	include($include);

	echo "</div>";
    }

	function vizURL(){
		return  plugins_url("/viz-library/");
		}

	function vizlibrary_init() {
		wp_register_style( 'VizLibStylesheet', plugins_url('style.css', __FILE__) );
		}
    
    function vizLibrary_actions() {
		add_menu_page( 'Viz Library', 'Viz Library', 'publish_posts','vizLibrary', 'test' );
	 	}
 
	function getVizzes($a="lid > 0"){
		$db = new SQLite3(__DIR__.'/vizzes.db');
		$results = $db->query("SELECT * FROM library WHERE $a AND draft !=1");		
		return $results;
		}

	function vizLibraryScripts() {
	    wp_enqueue_style( 'VizLibStylesheet' );
	    wp_enqueue_style( 'wp-color-picker' );
	    wp_enqueue_script( 'wp-color-picker');
#		wp_enqueue_script( 'jquery-ui-core' );
#		wp_enqueue_script( 'jquery-ui-autocomplete' );
	}	

	add_action( 'admin_enqueue_scripts', 'vizLibraryScripts' ); 
    add_action( 'admin_menu', 'vizLibrary_actions' );
	add_action( 'admin_init', 'vizlibrary_init' );
    
?>