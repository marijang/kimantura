<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package kimnaturaV1
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function kimnaturav1_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'kimnaturav1_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function kimnaturav1_woocommerce_scripts() {
	wp_enqueue_style( 'kimnaturav1-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'kimnaturav1-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'kimnaturav1_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function kimnaturav1_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'kimnaturav1_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function kimnaturav1_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'kimnaturav1_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function kimnaturav1_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'kimnaturav1_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function kimnaturav1_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'kimnaturav1_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function kimnaturav1_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'kimnaturav1_woocommerce_related_products_args' );

if ( ! function_exists( 'kimnaturav1_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function kimnaturav1_woocommerce_product_columns_wrapper() {
		$columns = kimnaturav1_woocommerce_loop_columns();
		echo '<div class="shop"><div class="shop__sidebar">';
		dynamic_sidebar('woocommerce-shop');
		echo '</div>';
		echo '<div class="shop__products columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'kimnaturav1_woocommerce_product_columns_wrapper', 10 );

if ( ! function_exists( 'kimnaturav1_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function kimnaturav1_woocommerce_product_columns_wrapper_close() {
		echo '</div></div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'kimnaturav1_woocommerce_product_columns_wrapper_close', 10 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'kimnaturav1_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function kimnaturav1_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'kimnaturav1_woocommerce_wrapper_before' );

if ( ! function_exists( 'kimnaturav1_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function kimnaturav1_woocommerce_wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'kimnaturav1_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'kimnaturav1_woocommerce_header_cart' ) ) {
			kimnaturav1_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'kimnaturav1_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function kimnaturav1_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		kimnaturav1_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'kimnaturav1_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'kimnaturav1_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function kimnaturav1_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'kimnaturav1' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'kimnaturav1' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'kimnaturav1_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function kimnaturav1_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php kimnaturav1_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}


if ( ! function_exists( 'b4b_woocommerce_before_shop_loop_item' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_woocommerce_before_shop_loop_item() {
		?>

			<?php
	}
}
add_action( 'woocommerce_before_shop_loop_item', 'b4b_woocommerce_before_shop_loop_item', 40 );


add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		$html = '<a href="' . esc_url( $product->add_to_cart_url() ) . '" class="btn btn--primary" >';
		//$html .= woocommerce_quantity_input( array(), $product, false );
		$html .= '' . esc_html( $product->add_to_cart_text() ) . '';
		$html .= '</a>';
	}
	return $html;
}


if ( ! function_exists( 'b4b_woocommerce_before_checkout_form' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_woocommerce_before_checkout_form() {
		?>
            <div class="woocommerce__checkout">
			<?php
	}
}
add_action( 'woocommerce_before_checkout_form', 'b4b_woocommerce_before_checkout_form', 40 );

if ( ! function_exists( 'b4b_woocommerce_after_checkout_form' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_woocommerce_after_checkout_form() {
		?>
            </div>
			<?php
	}
}
add_action( 'woocommerce_after_checkout_form', 'b4b_woocommerce_after_checkout_form', 40 );



    function b4b_wc_category_description() {
        if ( is_product_category() ) {
            global $wp_query;
            $cat_id = $wp_query->get_queried_object_id();
            $cat_desc = term_description( $cat_id, 'product_cat' );
            $subtit = '<span class="page__description">'.$cat_desc.'</span>';
            echo $subtit;
        }else{
			echo '<p class="page__description">'.__('Odaberite kategoriju proizvoda'). '</p>';
			echo the_subtitle( '<p class="page__description">', '</p>' );
		}
	}
	
add_action( 'woocommerce_archive_description', 'b4b_wc_category_description' );


// Makni  breadcrumb
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);




