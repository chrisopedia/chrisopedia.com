<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<?php the_breadcrumbs(); ?>

<section id="primary" class="Category Posts" role="main">

	<?php if ( have_posts() ) { ?>
		<?php if ( tag_description() ) { ?>
			<header class="header">
				<h2 class="title"><?php printf( single_tag_title( '', false ) ); ?></h2>
				<h3 class="description"><?php echo strip_tags( tag_description() ); ?></h3>
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
				<?php
					/* Include the post format-specific template for the content. If you want to
					 * this in a child theme then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				} ?>
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
