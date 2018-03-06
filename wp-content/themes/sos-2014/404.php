<?php get_header(); ?>
<div id="content">
<div id="post-0" class="post not-found">
<div class="header">
<h1 class="entry-title"><?php _e( 'Not Found', 'blankslate' ); ?></h1>
</div>
<div class="entry-content">
<p><?php _e( 'Nothing found for the requested page. Try a search instead?', 'blankslate' ); ?></p>
<?php get_search_form(); ?>
</div>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>