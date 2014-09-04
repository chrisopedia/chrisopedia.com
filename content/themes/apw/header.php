<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <main id="body">
 *
 * @package WordPress
 * @subpackage APW
 * @since APW 1.0
 */
?>
<!DOCTYPE html>
<html id="apermanentwreck" <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="description" content="<?php bloginfo( 'description' ); ?>" />

		<!-- IE meta tag, force it to Edge compatibility -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<!-- BlackBerry meta tags (http://docs.blackberry.com/en/developers/deliverables/6176/HTML_ref_meta_564143_11.jsp) -->
		<meta name="HandheldFriendly" content="True" />

		<!-- Windows Phone 7 meta tag (http://bowdenweb.com/wp/2011/05/meta-name-mobileoptimized-element.html) -->
		<meta name="MobileOptimized" content="320" />

		<!-- iPhone meta tag (width=device-width letterboxes on iPhone 5) -->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- <meta name="viewport" content="width=device-width" /> -->
		<!-- iPhone meta tag (Smart Banner) -->
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="white" />
		<meta name="apple-mobile-web-app-title" content="<?php wp_title( '|', true, 'right' ); ?>" />

		<!-- not sure what this is, found it in HTML5 Boilerplate -->
		<meta http-equiv="cleartype" content="on" />

		<!-- Windows Phone 8 meta (Pinned Sites title to be shortenend) -->
		<meta name="title" content="<?php wp_title( '|', true, 'right' ); ?>" />
		<!-- Windows Phone 8 meta (needs to be 144x144, should have transparent png) -->
		<meta name="msapplication-TileImage" content="<?php echo favicon_url( '144x144.png' ); ?>" />
		<!-- Windows Phone 8 meta (should be most prominent color, [rgb, keywords, hex]) -->
		<meta name="msapplication-TileColor" content="rgb(246,246,246)" />

		<!-- Facebook og tags -->
		<meta property="fb:app_id" content="266115080103149" />
		<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo esc_url( home_url( '/' ) ); ?>" />
		<meta property="og:title" content="<?php bloginfo( 'name' ); ?>" />
		<meta property="og:description" content="<?php bloginfo( 'description' ); ?>" />
		<meta property="og:image" content="<?php echo esc_url( home_url( '/media/images/people/me.png' ) ); ?>" />

		<!-- Twitter card -->
		<meta name="twitter:site" content="@apermanentwreck" />
		<meta name="twitter:card" content="summary" />
		<meta name="twitter:url" content="<?php echo esc_url( home_url( '/' ) ); ?>" />
		<meta name="twitter:title" content="<?php bloginfo( 'name' ); ?>" />
		<meta name="twitter:description" content="<?php bloginfo( 'description' ); ?>" />
		<meta name="twitter:image" content="<?php echo esc_url( home_url( '/media/images/people/me.png' ) ); ?>" />

		<!-- Google Direct Connect -->
		<link rel="publisher" href="https://plus.google.com/103387176241530356440" />

		<!-- Open ID Provider tags -->
		<link rel="openid2.provider" href="https://openid.stackexchange.com/openid/provider" />
		<link rel="openid2.local_id" href="https://openid.stackexchange.com/user/074a393c-faf4-4e93-8ada-de6bf980c780" />

		<!-- Profile information -->
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="EditURI" href="<?php echo get_bloginfo('wpurl'); ?>/xmlrpc.php?rsd" title="RSD" type="application/rsd+xml" />
		<link rel="wlwmanifest" href="<?php echo get_bloginfo('wpurl');?>/wp-includes/wlwmanifest.xml" type="application/wlwmanifest+xml" />
		<link rel="author" href="<?php echo esc_url( home_url( '/humans.txt' ) ); ?>" type="text/plain" />

		<!-- WP/Bit.ly Shortener Link -->
		<link rel="shortlink" href="<?php echo bitly_shortlink(); ?>" />

		<!-- Canonical -->
        <link rel="canonical" href="<?php echo esc_url( home_url() ); ?>" />

		<!-- RSS Feed / Alternate Links -->
		<link rel="alternate" href="<?php echo get_feed_link(); ?>" title="RSS Feed for A Permanent Wreck" type="application/rss+xml" />

		<!-- Meta Links -->
        <link rel="top" href="#" title="top" />
        <link rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="Home Page" />         
        <link rel="contents" href="<?php echo esc_url( home_url( '/site-map.xml' ) ); ?>" title="Site Map" /> 
        <link rel="copyright" href="<?php echo esc_url( home_url( '/license.md' ) ); ?>" title="Copyright" /> 
        <link rel="search" href="<?php echo esc_url( home_url( '/search' ) ); ?>" title="Search This Site" />

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<!-- Favicon for iPad 3rd/4th Generation -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo favicon_url( '144x144.png' ); ?>.png" />
		<!-- Favicon for iPhone 4/4S/5 & iPod Touch 2012 -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo favicon_url( '114x114.png' ); ?>" />
		<!-- Favicon for iPad, iPad 2 & iPad Mini -->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo favicon_url( '72x72.png' ); ?>" />
		<!-- Favicon for iPhone 3GS, iPod Touch 2011, & older Android devices -->
		<link rel="apple-touch-icon-precomposed" href="<?php echo favicon_url( '144x144.png' ); ?>" />
		<!-- Favicon for Browsers 32x32 -->
		<link rel="icon shortcut" href="<?php echo favicon_url( '32x32.png' ); ?>" />
		<!-- Favicon for Legacy Browsers 16x16 -->
        <link rel="icon shortcut" href="<?php echo esc_url( home_url( 'favicon.ico' ) ); ?>" />

        <!-- Apple Startup Images -->
		<!-- iPhone 3GS, 2011 iPod Touch -->
		<link rel="apple-touch-startup-image" sizes="320x460" href="<?php echo image_path_url( 'startup/320x460.png' ); ?>" media="screen and (max-device-width : 320px)">
		<!-- iPhone 4, 4S and 2011 iPod Touch -->
		<link rel="apple-touch-startup-image" sizes="640x920" href="<?php echo image_path_url( 'startup/640x920.png' ); ?>" media="(max-device-width : 480px) and (-webkit-min-device-pixel-ratio : 2)">
		<!-- iPhone 5 and 2012 iPod Touch -->
		<link rel="apple-touch-startup-image" sizes="640x1096" href="<?php echo image_path_url( 'startup/640x1096.png' ); ?>" media="(max-device-width : 548px) and (-webkit-min-device-pixel-ratio : 2)">
		<!-- iPad landscape -->
		<link rel="apple-touch-startup-image" sizes="1024x748" href="<?php echo image_path_url( 'startup/1024x748.png' ); ?>" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : landscape)">
		<!-- iPad Portrait -->
		<link rel="apple-touch-startup-image" sizes="768x1024" href="<?php echo image_path_url( 'startup/768x1024.png' ); ?>" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : portrait)">

		<!-- Stylesheets -->
		<?php 
			/* ----- dev ----- */
			if ( strpos( $_SERVER['HTTP_HOST'], 'dv' ) !== false ) {
				$files = file_get_contents( './config/stylesheets.json' );
				$data = json_decode( $files, true );
				for( $i = 0; $i < count( $data['files'] ); $i++ ) {
		?>
					<link rel="stylesheet" href="/<?php echo $data['files'][$i]; ?>" />
		<?php 
				};
			/* ----- prod ----- */
			} else { 
				$pkg = json_decode( file_get_contents( './package.json' ), true );
		?>
				<link rel="stylesheet" href="/ui/compressed/<?php echo $pkg['name'] . '.v' . $pkg['version'] . '.min.css'; ?>" />
		<?php } ?>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-42582877-1', 'wrck.me');
			ga('send', 'pageview');
		</script>

		<!-- Title -->
		<title><?php wp_title( '|', true, 'right' ); ?></title>

		<?php wp_head(); ?>
	</head>

	<body class="<?php echo apw_body_class(); ?>">

		<?php /* ----- Header ----- */ ?>
		<header id="header" class="Header" role="banner">
			<a id="top" class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

			<?php /* probably end up deleting */ ?>
			<p class="tagline"><?php bloginfo( 'description' ); ?></p>

			<?php /* ----- Navigation ----- */ ?>
			<nav id="navigation" class="Navigation" role="navigation">
				<ul class="listing">
					<?php foreach ( ( array ) apw_custom_nav() as $key => $item ) { ?>
						<li class="item"><a class="url" href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></li>
					<?php } ?>
				</ul>
			</nav>
			<?php /* ----- end: Navigation ----- */ ?>

		</header>
		<?php /* ----- end: Header ----- */ ?>

		<?php /* ----- Main ----- */ ?>
		<main id="body" class="Body">
