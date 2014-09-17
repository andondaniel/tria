<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Tria
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<?php wen_logo(); ?>
		<?php
			$args = array(
		    'container_class' => 'social-wrapper-class',
		    'container_id' => 'social-wrapper-id',
		    'list_class' => 'list-class',
		    'list_id' => 'id-list',
		    );
			wen_social_links( $args ) ;
		 ?>
		 <?php echo wen_get_option( 'phone_number', '(952) 831 8742' ); ?>

		 <?php get_search_form(); ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _e( 'Primary Menu', 'tria' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->

		<?php
		if ( function_exists( 'breadcrumb_trail' ) ) {
			$args = array(
				'labels' => array(
					'browse' => '',
					),
				);
			breadcrumb_trail($args);
		}
	?>

	</header><!-- #masthead -->


	<div id="content" class="site-content">
