<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package kimnaturaV1
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.4/TweenMax.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
</head>

<body <?php //body_class('grid'); ?>>
<progress class="blog-progress js-progress" value="0" max="1"></progress>
<?php do_action('b4b_before_header');?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kimnaturav1' ); ?></a>

	<header class="page__header" id="site-header">
	

		<nav id="site-navigation" class="navigation">

		<div class="navigation__brand">
			<?php
			do_action('b4b_header_logo');
			
				?>
			
		</div><!-- .site-branding -->

			<button style="display:none;" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'kimnaturav1' ); ?></button>
			
			<?php
	

			wp_nav_menu(array(
				'theme_location' => 'menu-1',
				'container' => false,
				'menu_id' => 'primary-menu',
				'menu_class'		=> 'navigation__primary navigation__list navigation__list--main',
				'depth' => 1,
				// This one is the important part:
				'walker' => new Custom_Walker_Nav_Menu
			  ));

			   bit4bytes_header_cart(); 	
			?>
		</nav><!-- #site-navigation -->
		
	</header><!-- #masthead -->


