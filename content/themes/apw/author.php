<?php
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
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
		<?php
			/* Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			 *
			 * We reset this later so we can run the loop
			 * properly with a call to rewind_posts().
			 */
			the_post();
		?>

			<header class="header">
				<h2 class="title"><?php printf( __( 'Author Archives: %s', 'twentytwelve' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h2>
			</header>

			<?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();

				// If a user has filled out their description, show a bio on their entries.
				if ( get_the_author_meta( 'description' ) ) { 
			?>
					<footer class="Author">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentytwelve_author_bio_avatar_size', 150 ) ); ?>
						<h2 class="name"><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p class="description"><?php the_author_meta( 'description' ); ?></p>
					</footer>
			<ul class="listing">
			<?php 
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
				query_posts( $query_string . '&showposts=10&paged=' . $paged );
				/* Start the Loop */
				}

				while ( have_posts() ) {
					the_post();
			?>
				<li class="item">
					<?php 
						get_template_part( 'content', get_post_format() );
				} ?>
				</li>
			</ul>

		<?php
				next_prev_post_nav(); 

			} else {
				get_template_part( 'content', 'none' );
			} 
		?>

</section>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
