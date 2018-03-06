<?php get_header(); ?>
<div id="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'entry' ); ?>
<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
<?php endwhile; endif; ?>
<div class="footer">
<?php get_template_part( 'nav', 'below-single' ); ?>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>