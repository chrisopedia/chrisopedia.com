<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main div elements.
 *
 * @package WordPress
 * @subpackage APW
 * @since APW 1.0
 */
?>
		</main>
		<?php /* ----- end: Main ----- */ ?>


		<?php /* ----- Footer ----- */ ?>
		<footer id="footer" class="Footer" role="contentinfo">
			<?php get_search_form(); ?> 
			<ul class="listing">
				<li class="item"><a class="Icon social solo url" data-icon="&#xF611;" href="http://twitter.com/apermanentwreck" title="Follow me on Twitter">&#xF611;</a></li>
				<li class="item"><a href="mailto:u@wrck.me" class="Icon solo url" data-icon="&#x2709;" title="Hire me!">&#x2709;</a></li>
				<li class="item"><a class="Icon solo url" data-icon="&#xE310;" href="<?php echo get_feed_link(); ?>" title="RSS Feed for A Permanent Wreck">&#xE310;</a></li>
			</ul>
			<?php do_action( 'twentytwelve_credits' ); ?>
		</footer>
		<?php /* ----- end: Footer ----- */ ?>

		<?php 
			/* ----- dev ----- */
			if ( strpos( $_SERVER['HTTP_HOST'], 'dv' ) !== false ) {
				$files = file_get_contents( './config/scripts.json' );
				$data = json_decode( $files, true );
				for( $i = 0; $i < count( $data['files'] ); $i++ ) {
		?>
					<script src="/<?php echo $data['files'][$i]; ?>"></script>
		<?php 
				};
			/* ----- prod ----- */
			} else { 
				$pkg = json_decode( file_get_contents( './package.json' ), true );
		?>
				<script src="/ui/compressed/<?php echo $pkg['name'] . '.v' . $pkg['version'] . '.min.js'; ?>"></script>
		<?php } ?>
		<?php wp_footer(); ?>
	</body>
</html>
