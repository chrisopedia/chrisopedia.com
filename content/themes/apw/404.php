<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php the_breadcrumbs(); ?>

<section id="primary" class="Category Posts" role="main">
	<?php get_template_part( 'content', 'none' ); ?>
</section>

<?php get_footer(); ?>
