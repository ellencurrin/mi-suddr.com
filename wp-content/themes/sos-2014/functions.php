<?php
wp_embed_register_handler( 'gviewer', '#gviewer=(.+)#i', 'wp_embed_handler_gviewer' );

function wp_embed_handler_gviewer( $matches, $attr, $url, $rawattr ) {

	$embed = sprintf(
		'<div class="gviewer"><iframe src="https://docs.google.com/viewer?url=%1$s&embedded=true"></iframe><a href="%2$s" download>Download</a></div>',
		rawurlencode($matches[1]),$matches[1]
		);

	return apply_filters( 'embed_gviewer', $embed, $matches, $attr, $url, $rawattr );
}

add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup()
{
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 640;
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'blankslate' ) )
);
}
add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts()
{
wp_enqueue_script( 'jquery' );
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script()
{
if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return '&rarr;';
} else {
return $title;
}
}
add_filter( 'wp_title', 'blankslate_filter_wp_title' );
function blankslate_filter_wp_title( $title )
{
return $title . esc_attr( get_bloginfo( 'name' ) );
}

add_action( 'wp_register_sidebar_widget', 'blankslate_widgets_init' );
function blankslate_widgets_init(){
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}

add_action( 'wp_register_sidebar_widget', 'blankslate_footer_widgets_one' );
function blankslate_footer_widgets_one(){
register_sidebar( array (
'name' => __( 'Footer Widget Area One', 'blankslate' ),
'id' => 'footer-widget-area-one',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}

add_action( 'wp_register_sidebar_widget', 'blankslate_footer_widgets_two' );
function blankslate_footer_widgets_two(){
register_sidebar( array (
'name' => __( 'Footer Widget Area Two', 'blankslate' ),
'id' => 'footer-widget-area-two',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}

add_action( 'wp_register_sidebar_widget', 'blankslate_footer_widgets_three' );
function blankslate_footer_widgets_three(){
register_sidebar( array (
'name' => __( 'Footer Widget Area Three', 'blankslate' ),
'id' => 'footer-widget-area-three',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}

function blankslate_custom_pings( $comment )
{
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php 
}
add_filter( 'get_comments_number', 'blankslate_comments_number' );
function blankslate_comments_number( $count )
{
if ( !is_admin() ) {
global $id;
$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}