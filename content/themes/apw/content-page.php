<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" class="<?php echo strip_post_class( get_post_class() ); ?>">
	<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
		<div class="featured"><?php _e( 'Featured post', 'twentytwelve' ); ?></div>
	<?php } ?>
	<?php if ( is_single() ) { ?>
		<h1 class="title"><?php the_title(); ?></h1>
	<?php } else { ?>
		<h1 class="title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( __( '(Edit)', 'twentytwelve' ), '<small class="edit">', '</small>' ); ?></h1>
	<?php } ?>
	<?php the_subtitle( $post->ID ); ?>
	<?php the_post_thumbnail( 'medium', array( 'class' => 'image' ) ); ?>
	<time class="Icon before timestamp" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" data-icon="&#x1F4C5;"><?php echo esc_html( get_the_date( 'M. jS, Y' ) ); ?></time>

	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
	<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>

	<footer class="meta">
		<?php entry_meta(); ?>
	</footer>
</article>
