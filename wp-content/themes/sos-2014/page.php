<?php get_header(); ?>
<div id="container">
	<div id="image_sidebar" style="position:absolute; left:30px; top:25px; width:150px">
	<?php
	$base = get_template_directory_uri()."/images/sidebar/";
	chdir(get_template_directory()."/images/sidebar");
	$pics = glob("*.jpg");
	foreach(array_rand($pics,6) as $p){
		$s = $base.$pics[$p];
		echo  "<img src='$s' style='width:100%; height:auto;' />";
		}
	?>
	</div>
	<div id="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="header">
				<h1 class="entry-title"><?php the_title(); ?></h1> <?php edit_post_link(); ?>
			</div>
			<div class="entry-content">
				<?php 
				if ( has_post_thumbnail() ) { the_post_thumbnail(); }
				the_content(); 
				?>
				<div class="entry-links"><?php wp_link_pages(); ?></div>
			</div>
		</div>
		<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
		<?php endwhile; endif; ?>
	</div>
</div> <!--end container-->
<?php get_footer(); ?>