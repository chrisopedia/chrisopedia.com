<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php the_breadcrumbs(); ?>

<section id="primary" class="Site Posts" role="main">

	<?php if ( have_posts() ) { ?>
		<?php if ( category_description() ) { ?>
			<header class="header">
				<h2 class="title"><?php printf( __( 'Search Results for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				<h3 class="description"><?php echo strip_tags( category_description() ); ?></h3>
			</header>
		<?php } ?>

		<ul class="listing">
			<?php
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
				query_posts( $query_string . '&showposts=10&paged=' . $paged );
				/* Start the Loop */
				while ( have_posts() ) {
					the_post();
			?>
			<li class="item">
				<?php get_template_part( 'content', get_post_format() ); } ?>
			</li>
		</ul>
	<?php

		next_prev_post_nav();

	} else {
		get_template_part( 'content', 'none' ); 
	} ?>

</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
