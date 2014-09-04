<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php get_header(); ?>

<?php the_breadcrumbs(); ?>

<section id="primary" class="Primary" role="main">

	<?php 
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', get_post_format() );
			next_prev_post_nav(); 
			if ( get_comments_number() > 0 ) {
				comments_template( '', true ); 
			}
		}
	?>

</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
