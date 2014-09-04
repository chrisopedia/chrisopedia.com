<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php the_breadcrumbs(); ?>

<section id="primary" class="Category Posts" role="main">

	<?php 
		while ( have_posts() ) { 
			the_post();
			get_template_part( 'content', 'page' );
		} 
	?>

</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
