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
	<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

</head>

<body <?php body_class('grid'); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'kimnaturav1' ); ?></a>

	<header class="page__header">
	

		<nav id="site-navigation" class="navigation">

		<div class="navigation__brand">
			<?php
			echo FOOBAR_get_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$kimnaturav1_description = get_bloginfo( 'description', 'display' );
			if ( $kimnaturav1_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $kimnaturav1_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
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


