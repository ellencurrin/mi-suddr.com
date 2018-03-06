<?php
// [tableau vis="value" tabs="value" toolbar="value"]
function tableau_func( $atts ) {
	extract( shortcode_atts( array(
		'vis' => 'something',
		'tabs' => 'no',
		'toolbar' => 'yes',
		'animation' => 'yes',
		'static' => 'yes'
	), $atts ) );

	$e .= "<div class='tableau' style='width:100%; height:100%;'>";
	$e .= "<iframe src='http://public.tableausoftware.com/views/{$vis}?amp;:embed=y&:showVizHome=no";
	$e .= "&:tabs={$tabs}";
	$e .= "&:toolbar={$toolbar}";
	$e .= "&:animate_transition={$animation}";
	$e .= "&:display_static_image={$static}";
	$e .= "&:display_spinner=yes";
	$e .= "&:display_overlay=yes";
	$e .= "&:display_count=yes";
	$e .= "&:loadOrderID=0";
	$e .= "'></iframe>";
	$e .= "</div>";

	return $e;
}
add_shortcode( 'tableau', 'tableau_func' );
?>