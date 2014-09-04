<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'twentytwelve-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		// wp_enqueue_style( 'twentytwelve-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'apw', get_stylesheet_uri() );

	/*
	 * Loads the Internet Explorer specific stylesheet.
	 */
	wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
	$wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'First Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'next_prev_post_nav' ) ) {
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since APW 1.0
	 */
	function next_prev_post_nav() {
		global $wp_query;
		$previous = get_adjacent_post(false, '', true);
		$next = get_adjacent_post(false, '', false);
?>

		<nav class="Navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
			<?php if ( !empty( $previous ) ) { ?>
				<a class="Icon before previous url" data-icon="&#x25C5;" href="<?php echo get_permalink( $previous->ID ); ?>" title="<?php echo 'Read the previous article: ' . $previous->post_title; ?>"><?php echo $previous->post_title; ?></a>

			<?php } ?>
			<?php if ( !empty( $next ) ) { ?>
				<a class="Icon after next url" data-icon="&#x25BB;" href="<?php echo get_permalink( $next->ID ); ?>" title="<?php echo 'Read the next article: ' . $next->post_title; ?>"><?php echo $next->post_title; ?></a>
			<?php } ?>
		</nav>
<?php 
	}
}

if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentytwelve_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function entry_meta() {
	global $post;
	$html = '';

	$categories_list = get_the_category();
	$categories = '<dl class="categories">';
	$categories .= '<dt class="term" hidden aria-hidden="true">' . __( 'Categories' ) . '</dt>';
	if( $categories_list ) {
		foreach( $categories_list as $category ) {
			$categories .= '<dd class="item"><a class="Icon before" data-icon="&#x1F4D3;" href="' . get_category_link( $category->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">' . $category->cat_name . '</dd></a>';
		}
	}
	$categories .= '</dl>';

	$tag_list = get_the_tags();
	$tags = '<dl class="tags">';
	$tags .= '<dt class="term" hidden aria-hidden="true">' . __( 'Tags' ) . '</dt>';
	if ( $tag_list ) {
		foreach( $tag_list as $tag ) {
			$tags .= '<dd class="item"><a class="Icon before" data-icon="&#xE100" href="' . get_tag_link( $tag->term_id ) . '" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">' . $tag->name . '</a></dd>';
		}
	}
	$tags .= '</dl>';

	$short_link = wp_get_shortlink( $post->ID );
	$link = '<a class="Icon before url" data-icon="&#x1F517;" href="' . esc_attr( $short_link ) . '" title="' . $post->post_title . '">' . shortlink_pretty_url( $short_link ) . '</a>';

	if ( $categories_list && ! is_category() ) {
		$html .= __( $categories, 'twentytwelve' );
	} 
	if ( $tag_list && ! is_tag() ) {
		$html .= __( $tags , 'twentytwelve' );
	}

	if ( ! empty( $short_link ) ) {
		$html .= __( $link, 'twentytwelve' );
	}

	echo $html;
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );

/**
 * removes the rss feed, comments rss feed, rsd_link, 
 * wlwmanifest_link, & wp_generator
 *
 * i added the rss feed, rsd_link, wlwmanifest_link
 * on the header.php
 */
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
// trying to figure out how to get these 2 back
// in to the header.php
//remove_filter( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
remove_action( 'wp_head', 'locale_stylesheet' );
remove_action( 'wp_head', 'noindex', 1 );
remove_action( 'wp_head', 'wp_print_styles', 8 );
remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rel_canonical' );
remove_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
// removes the link tag for the wp.me shortlink that gets generated
remove_action( 'wp_head', 'shortlink_wp_head', 10 );
// removing the default shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 ); 
remove_action( 'wp_print_footer_scripts', '_wp_footer_scripts' );

/**
 * puts custom image sizes as an option in the media
 * uploader
 */
add_image_size( 'full-width-ratio', 600, 9999 );
add_image_size( 'full-width-crop', 600, 300, true );
function custom_in_post_images( $args ) { 
	$custom_images = array(
		'full-width-ratio' => 'Full Width Ratio', 
		'full-width-crop' => 'Full Width Crop'
	); 
	return array_merge( $args, $custom_images ); 
}; 
add_filter( 'image_size_names_choose', 'custom_in_post_images' );

/**
 * strips the posts_class() in order to format it to my
 * styleguide requirements
 */
function apw_body_class() {
	$class = '';
	if ( is_home() || is_front_page() ) {
		$class = 'Home';
	}
	return $class;
}
/**
 * strips the posts_class() in order to format it to my
 * styleguide requirements
 */
function strip_post_class( $arr ) {
	$tmp = array();
	for ( $i = 0; $i < count( $arr ); $i++ ) {
		// post ID
		$arr[0] = null;
		// post type
		$arr[1] = ucwords( $arr[1] );
		// post type duplicated as 'post-[post_type]'
		$arr[2] = null;
		// post status
		$arr[3] = null;
		// post format
		$arr[4] = str_replace( 'format-', '', $arr[4] );
		if ( $arr[$i] === 'hentry' ) {
			$arr[$i] = null;
		}
		if ( substr( $arr[$i], 0, 8 ) === 'category' ) {
			$arr[$i] = str_replace( 'category-', '', $arr[$i] );
		}
		if ( substr( $arr[$i], 0, 3 ) === 'tag' ) {
			$arr[$i] = str_replace( 'tag-', '', $arr[$i] );
		}
		if ( $arr[$i] !== null ) {
			array_push( $tmp, $arr[$i] ); 
		}
	}
	return implode(' ', $tmp);
}

function custom_excerpt_more( $excerpt ) {
	return str_replace( ' [...]', '&hellip;', $excerpt );
}
add_filter( 'wp_trim_excerpt', 'custom_excerpt_more' );

add_action('publish_post', 'create_bitly');

// create bitly url when post is published
function create_bitly( $postID ) {
	global $wpdb;

	// here we get the permalink to your post
	$url = get_permalink( $postID ); 
	// This is the API call to fetch the shortened URL
	$bitly = 'https://api-ssl.bitly.com//v3/shorten?access_token=2d977844b2ed1aeb3e014d07fc7fae74dfd05e62&longUrl=' . urlencode( $url );

	// We are using cURL
	$curl = curl_init();
	curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 5 );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $curl, CURLOPT_URL, $bitly );
	$results = json_decode( curl_exec( $curl ) );
	curl_close( $curl );

	// adding the short URL to a custom field called bitlyURL
	update_post_meta( $postID, 'bitlyURL', $results->data->url ); 
}

// add the short url to the head
function bitly_shortlink() {
	global $post;
	$url = get_post_meta( $post->ID, 'bitlyURL', true );

	return ( ! empty( $url ) ) ? $url : get_bloginfo( 'url' ) . '?p=' . $post->ID;
}

// filtering the WP function
add_filter('pre_get_shortlink', 'get_bitly_shortlink'); 

function get_bitly_shortlink() {
	global $post;
	$url = get_post_meta( $post->ID, 'bitlyURL', true );

	if( ! empty( $url ) ) {
		return $url;
	} else {
		return null;
	}
}

function shortlink_pretty_url( $url ) {
	$arr = parse_url( $url );
	return $arr['host'] . $arr['path'];
}

function stylesheet_url( $path ) {
	return esc_url( home_url( 'ui/stylesheets/' . $path ) );
}

function image_path_url( $path ) {
	return esc_url( home_url( 'ui/images/' . $path ) );
}

function favicon_url( $path ) {
	return esc_url( home_url( 'ui/images/favicons/' . $path ) );
}

function apw_custom_nav() {
	$name = 'primary';

	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $name ] );
		$items = wp_get_nav_menu_items( $menu->term_id );

		return $items;
	}
}
// this is the relative path from WP_CONTENT_DIR to your uploads directory
// update_option( 'upload_path', '../media/uploads' );
// this is the actual path to the image uploads, needs to be absolute;
// update_option( 'upload_url_path', WP_HOME . '/media/uploads' );
if ( get_option( 'upload_path' ) == null || get_option( 'upload_path' ) == 'content/uploads' || get_option( 'upload_path' ) == 'wp-content/uploads' ) {
	update_option( 'upload_path', '../media/uploads' );
	update_option( 'upload_url_path', WP_HOME . '/media/uploads' );
}

function breadcrumbs( $id ) {
	$html = '<ol class="Breacrumbs">';
	$html .= '<li class="Icon solo item"><a href="' . esc_url( home_url() ) . '" title="' . __( 'Return back to the home page', 'twentytwelve' ) . '">&#x2302;</a></li>';
}

function the_breadcrumbs() {

	/* === OPTIONS === */
	$text['home']     = 'Home'; // text for the 'Home' link
	$text['category'] = '%s'; // text for a category page
	$text['search']   = 'Search Results for "%s"'; // text for a search results page
	$text['tag']      = '%s'; // text for a tag page
	$text['author']   = 'Articles by %s'; // text for an author page
	$text['404']      = '404'; // text for the 404 page

	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$before         = '<li class="item" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><b itemprop="title">'; // tag before the current crumb
	$after          = '</b></li>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$home_link    = home_url('/');
	$link_before  = '<li class="item" itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breacrumb">';
	$link_after   = '</li>';
	$link_attr    = ' rel="directory" itemprop="url"';
	$link         = $link_before . '<a href="%1$s" ' . $link_attr . '><span itemprop="title">%2$s</span></a>' . $link_after;
	$parent_id    = $parent_id_2 = $post->post_parent;
	$frontpage_id = get_option('page_on_front');

	if ( ! ( is_home() || is_front_page() ) ) {

		echo '<ol class="Breadcrumbs" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
		echo '<li class="Icon solo item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . esc_url( home_url() ) . '" rel="home" itemprop="url" title="' . __( 'Return back to the home page', 'twentytwelve' ) . '">&#x2302;</a></li>';

		if ( is_category() ) {
			$this_cat = get_category(get_query_var('cat'), false);
			if ($this_cat->parent != 0) {
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('">', '"><span itemprop="title">', $cats);
				$cats = str_replace('</a>', '</span></a>' . $link_after, $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr . '<span itemprop="title">', $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			if ($show_current == 1) echo $before . sprintf( ucwords( $text['category'] ), single_cat_title('', false)) . $after;

		} elseif ( is_search() ) {
			echo $before . sprintf( ucwords( $text['search'] ), get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, '');
				$cats = str_replace('">', '"><span itemprop="title">', $cats);
				$cats = str_replace('</a>', '</span></a>' . $link_after, $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
				if ($show_current == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('">', '"><span itemprop="title">', $cats);
			$cats = str_replace('</a>', '</span></a>' . $link_after, $cats);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $parent_id ) {
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
			}
			if ($show_current == 1) {
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
				echo $before . get_the_title() . $after;
			}

		} elseif ( is_tag() ) {
			echo $before . sprintf( ucwords( $text['tag'] ), single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf( ucwords( $text['author'] ), $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . ucwords( $text['404'] ) . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</ol>';

	}
}
//  add subtitle to posts and pages
function the_subtitle( $id ) {
	$subtitle = get_post_meta ( $id, 'subtitle', true );
	if ( ! empty( $subtitle ) ) {
		echo '<h2 class="subtitle">' . $subtitle . '</h2>';
	}
}
