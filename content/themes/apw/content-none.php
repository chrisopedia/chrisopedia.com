<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<article id="post-0" class="Post">
	<h1 class="title"><?php _e( 'Nothing Found', 'twentytwelve' ); ?></h1>

	<p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'twentytwelve' ); ?></p>
	<?php get_search_form(); ?>
</article>
