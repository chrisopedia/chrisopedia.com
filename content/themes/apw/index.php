<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage APW
 * @since APW 1.0
 */

	get_header();

	if ( have_posts() ) {

		while ( have_posts() ) { 
			the_post();
	?>
			<article id="post-<?php the_ID(); ?>" class="<?php echo strip_post_class( get_post_class() ); ?>">

				<?php if ( ! is_sticky() ) { ?>
					<h1 class="title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( __( '(Edit)', 'twentytwelve' ), '<small class="edit">', '</small>' ); ?></h1>
					<?php the_subtitle( $post->ID ); ?>
					<?php the_post_thumbnail(); ?>
					<time class="Icon before timestamp" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" data-icon="&#x1F4C5;"><?php echo esc_html( get_the_date( 'M. jS, Y' ) ); ?></time>
					<?php the_excerpt(); ?>
					<footer class="meta">
						<?php entry_meta(); ?>
					</footer>

				<?php } ?>

			</article>

			<?php 
				if ( ! is_sticky() ) {
					wp_link_pages( array( 
						'before' => '<p class="Pagination">' . __( 'Pages:', 'twentytwelve' ), 
						'after' => '</p>' 
					) ); 
				}
		} 

		next_prev_post_nav();

	}

	get_sidebar();
	get_footer();
?>
