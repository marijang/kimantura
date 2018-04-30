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
//	add_theme_support( 'wc-product-gallery-zoom' );
//	add_theme_support( 'wc-product-gallery-lightbox' );
//	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'kimnaturav1_woocommerce_setup' );

// Filters first

add_filter('b4b_product_variations','b4b_product_variations',10,3);
function b4b_product_variations($product, $before='', $after='', $append=array()){
	$string = 'b4b_product_variations';
	//var_dump($product);
	if ($product->is_type( 'variable' )) 
	{
		$available_variations = $product->get_available_variations();	
		$attributes =  $product->get_variation_attributes() ;
		if ( $attributes [ 'Pakovanje' ] ) {
			$string .='<div class="product__variations">';
			foreach ($attributes [ 'Pakovanje' ] as $variation){
				$string .='<span>'.$variation.'<span>';
			   }
			   $string .='<div>';
		}
	}
	return $string;
}
add_filter('b4b_product_attributes1','b4b_product_variations1',10,3);
function b4b_product_variations1($product, $before='', $after='', $append=array()){
	$string = 'b4b_product_variations';
	//var_dump($product);
	if ($product->is_type( 'variable' )) 
	{
		$available_variations = $product->get_available_variations();	
		$attributes =  $product->get_variation_attributes() ;
		if ( $attributes [ 'Pakovanje' ] ) {
			$string .='<div class="product__variations">';
			foreach ($attributes [ 'Pakovanje' ] as $variation){
				$string .='<span>'.$variation.'<span>';
			   }
			   $string .='<div>';
		}
	}
	return $string;
}

add_filter('woocommerce_add_error', 'b4b_wc_add_to_cart_message', 10, 2);
add_filter('woocommerce_add_notice', 'b4b_wc_add_to_cart_message', 10, 1);
add_filter('woocommerce_add_success', 'b4b_wc_add_to_cart_message', 10, 2);
function b4b_wc_add_to_cart_message( $message ) {
    return  $message.':test:';
}


/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function kimnaturav1_woocommerce_scripts() {
	//wp_enqueue_style( 'kimnaturav1-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

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

if ( ! function_exists( 'b4b_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function b4b_woocommerce_product_columns_wrapper() {
		$columns = kimnaturav1_woocommerce_loop_columns();
		echo '<div class="shop"><div class="shop__sidebar">';
		dynamic_sidebar('woocommerce-shop');
		echo '</div>';
		echo '<div class="shop__products columns-' . absint( $columns ) . '">';
		
	}
}
add_action( 'woocommerce_before_shop_loop', 'b4b_woocommerce_product_columns_wrapper', 5 );


if ( ! function_exists( 'b4b_woocommerce_products_list_header_wrap_start' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function b4b_woocommerce_products_list_header_wrap_start() {
		echo '<div class="shop__products-header">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'b4b_woocommerce_products_list_header_wrap_start', 6 );

if ( ! function_exists( 'b4b_woocommerce_products_list_header_wrap_end' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function b4b_woocommerce_products_list_header_wrap_end() {
		echo '</div>';
	}
}
add_action( 'woocommerce_before_shop_loop', 'b4b_woocommerce_products_list_header_wrap_end', 31 );

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
		<div id="primary" class="woocommerce__main">
			
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

if ( ! function_exists( 'b4b_woocommerce_after_main_content' ) ) {
	/**
	 * Afer Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_woocommerce_after_main_content() {		
		$args = array( 'numberposts' => '1' );
		echo '<div class="section">';
        echo '<h3 class="section__title">'.__('Posljedne novosti').'</h3>';
		global $wpdb,$post;
		$result = $wpdb->get_results("
			SELECT $wpdb->posts.* 
			FROM   $wpdb->posts 
			WHERE  post_type = 'post' 
			AND    post_status = 'publish'
			limit 1
		");
		$result = get_posts( $args ) ;
		foreach($result as $post):
		  setup_postdata($post);
		  get_template_part( 'template-parts/content-blog', get_post_type() ); 
		endforeach;

		wp_reset_postdata();	
        echo '</div>';

	}
}
add_action( 'woocommerce_after_main_content', 'b4b_woocommerce_after_main_content', 40 );



add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		//$html = '<a href="' . esc_url( $product->add_to_cart_url() ) . '" class="btn btn--primary" >';
		$html = '<a href="' . esc_url( get_permalink($product->get_ID())) . '" class="btn btn--primary" >';
		
		//$html .= woocommerce_quantity_input( array(), $product, false );
		$html .= '' . esc_html( $product->add_to_cart_text() ) . '';

		$html .= '</a>';
	}else{
		$html = '<a href="' . esc_url( get_permalink($product->get_ID())) . '" class="btn btn--primary" >';
		
		//$html .= woocommerce_quantity_input( array(), $product, false );
		$html .= '' . __( 'View product' ) . '';

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
            
			<?php
	}
}
add_action( 'woocommerce_after_checkout_form', 'b4b_woocommerce_after_checkout_form', 40 );

if ( ! function_exists( 'b4b_is_billing' ) ) {

    /**
     * Is_checkout_pay - Returns true when viewing the checkout's pay page.
     *
     * @return bool
     */
    function b4b_is_billing() {
        global $wp;

        return is_checkout() && ! empty( $wp->query_vars['order-pay'] );
    }
}

/**
 * Summary.
 *
 * Description.
 *
 * @since x.x.x
 *
 * @param type  $var Description.
 * @param array $args {
 *     Short description about this hash.
 *
 *     @type type $var Description.
 *     @type type $var Description.
 * }
 * @param type  $var Description.
 */


if ( ! function_exists( 'b4b_add_step_navigation_script' ) ) {
	/**
	 * Support Step Wizard.
	 *
	 * Wraps all homepage content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_add_step_navigation_script() {		;
		// add javascript
		wp_enqueue_script( 'b4b-multistep-woocommerce', get_template_directory_uri() . '/js/wc-multistep.js', array(),'' );
		//wc_get_template_part( 'b4b/checkout', 'navigation' );
		//echo get_template_part( 'woocommerce/b4b/checkout', 'navigation' );
	}
}

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
add_action( 'b4b_woocommerce_checkout_payment', 'woocommerce_checkout_payment', 20 );
add_action( 'woocommerce_after_checkout_form', 'b4b_add_step_navigation_script', 40 );



//  reOrder Fields from checkout field in Woocommerce
add_filter("woocommerce_checkout_fields", "order_fields");
function order_fields($fields) {
	unset($fields['order']['order_comments']);
	unset($fields['billing']['billing_company']); // remove the option to enter in a company
	unset($fields['billing']['billing_state']); // remove the billing state
	//unset($fields['billing']['billing_country']); // remove the billing country
	unset($fields['billing']['billing_address_2']); // remove the second line of the address
	//var_dump($fields);
	$fields["billing"]['billing_first_name']['priority']= 10;
	$fields["billing"]['billing_last_name']['priority'] = 20;
	$fields["billing"]['billing_email']['priority']		= 30;
	$fields["billing"]['billing_address_1']['priority'] = 40;
	$fields["billing"]['billing_phone']['priority']		= 50;
	$fields["billing"]['billing_postcode']['priority']	= 60;
	$fields["billing"]['billing_city']['priority']		= 70;
	$fields["billing"]['billing_country']['priority']	= 190;
	$fields["billing"]['billing_city']['class']         = array('form-row-first'); 
	$fields["billing"]['billing_postcode']['class']     = array('form-row-last');
	//$fields["billing"]['billing_country']['class']    	= array('form-row-wide');
	//var_dump($fields);
    return $fields;
}
function authorize_gateway_icon( $icon, $id ) {
    if ( $id === 'authorize_net_dpm' ) {
        return '<img src="' . get_bloginfo('stylesheet_directory') . '/images/woocommerce-icons/cards.png" alt="Authorize.net" />'; 
    } else {
        return $icon;
    }
}
add_filter( 'woocommerce_gateway_icon', 'authorize_gateway_icon', 10, 2 );

/**
 * Custom PayPal button text
 *
 */

add_filter( 'gettext', 'ld_custom_paypal_button_text', 20, 3 );
function ld_custom_paypal_button_text( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Proceed to PayPal' :
			$translated_text = __( 'Platite Paypalom', 'woocommerce' );
			break;
	}
	return $translated_text;
}

// Change order tekst
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 
function woo_custom_order_button_text() {
    return __( 'Platite', 'woocommerce' ); 
}

// Change payment icons
add_filter ('woocommerce_gateway_icon', 'custom_woocommerce_icons');
 
function custom_woocommerce_icons() {
    $icon  = '<img src="' . trailingslashit( get_template_directory_uri() ) . 'img/build/svg/visa.svg' . '" alt="Visa" />';
    $icon .= '<img src="' . trailingslashit( get_template_directory_uri() ) . 'img/build/svg/mastercard.svg' . '" alt="Mastercard" />';
    $icon .= '<img src="' . trailingslashit( get_template_directory_uri() ) . 'img/build/svg/amex.svg' . '" alt="American Express" />';
    $icon .= '<img src="' . trailingslashit( get_template_directory_uri() ) . 'img/build/svg/discover.svg' . '" alt="Visa" />';
    $icon .= '<img src="' . trailingslashit( get_template_directory_uri() ) . 'img/build/svg/jcb.svg' . '" alt="JCB" />';
    $icon .= '<img src="' . trailingslashit( get_template_directory_uri() ) . 'img/build/svg/diners.svg' . '" alt="Diners Club" />';
    return 'custom ikona';
    return $icon; 
}



add_filter('b4b_checkout_step','b4b_test');

function b4b_test($step=1) {
	$t = '';
	//$t.='C Step='.$step;
	if (is_cart()) {
		$step =  0;
	}
	if (Is_checkout()) {
		$step =  1;
	}
	if (is_wc_endpoint_url( 'order-pay' )) {
		$t .="order-pay";
	}
	if (is_wc_endpoint_url( 'order-received' )) {
		$t .="order-received";
	}


	if (is_account_page()) {
		$t .="acount_page";
	}
	if (is_cart()) {
		//$t .="Cart";
	}
   //var_dump($_POST);
	
	//is_order_received_page

	
	if (Is_view_order_page()) {
		$step =  2;
	}
	if (Is_order_received_page()) {
		$step =  3;
	}
	if (Is_view_order_page()) {
		$step =  4;
	}
   
	/*
	 * Page title
	 *  
	$t  .= '<header class="page__title">';
	$t  .= '<h1 class="page__title">'.get_the_title( ).'</h1>'; 
	$t  .= '<p class="page__description">'.get_the_subtitle().'</p>';
	$t  .= '</header>';
	*/
    //$t.='Step='.$step;
	$t  .= '<ul class="page__shop-checkout-navigation">';
	// First item
	$t  .= '<li id="wc-multistep-cart" data-step="cart" class="page__shop-checkout-navigation-item '. ( ($step == 0 ) ? 'is-active' : '').' '. ( ($step > 0 ) ? 'is-activated' : '').'" >';
	//$t  .= __('Košarica','b4b');
	if ($step>0){
		$t .= '<a href="'.get_permalink( wc_get_page_id( 'cart' )).'">'.__('Košarica','b4b').'</a>';
	}else{
		$t .= '<a href="'.get_permalink( wc_get_page_id( 'cart' )).'">'.__('Košarica','b4b').'</a>';
	}
	$t  .= '</li>';
	// Second item
	$t  .= '<li id="wc-multistep-details" data-step="customer-details" class="page__shop-checkout-navigation-item '. ( ($step == 1) ? 'is-active' : '').'" >';
	$t  .= __('Dostava','b4b');
	$t  .= '</li>';
	// Third item
	$t  .= '<li id="wc-multistep-payment" data-step="payment" class="page__shop-checkout-navigation-item '. ( ($step == 2) ? 'is-active' : '').'" >';
	$t  .= __('Način plačanja','b4b');
	$t  .= '</li>';
	// Fourth Item
	$t  .= '<li id="wc-multistep-finish" data-step="finish" class="page__shop-checkout-navigation-item is-last 
	'. ( ($step == 3) ? ' is-active' : '').'" >';
	$t  .= __('Potvrda','b4b');
	$t  .= '</li>';


	$t  .=  "</ul>";
	//$t  .= '<div class="page__content">';  
	//$t  .= 'Show:'.($step == 0) ? 'is-active' : 'prazno';
	return $t;
}


function get_title_shipping_method_from_method_id( $method_rate_id = '' ){
    if( ! empty( $method_rate_id ) ){
        $method_key_id = str_replace( ':', '_', $method_rate_id ); // Formating
        $option_name = 'woocommerce_'.$method_key_id.'_settings'; // Get the complete option slug
        return get_option( $option_name, true )['title']; // Get the title and return it
    } else {
        return false;
    }
}

/**
 * Show a message at the cart/checkout displaying
 * how much to go for free shipping.
 */
function b4b_shipping_methods_notice() {
	if ( ! is_cart() && ! is_checkout() ) { // Remove partial if you don't want to show it on cart/checkout
		return;
	}
	$packages = WC()->cart->get_shipping_packages();
	$package = reset( $packages );
	$zone = wc_get_shipping_zone( $package );
	$cart_total = WC()->cart->get_displayed_subtotal();
	if ( WC()->cart->display_prices_including_tax() ) {
		$cart_total = round( $cart_total - ( WC()->cart->get_discount_total() + WC()->cart->get_discount_tax() ), wc_get_price_decimals() );
	} else {
		$cart_total = round( $cart_total - WC()->cart->get_discount_total(), wc_get_price_decimals() );
	}
    // Calculate price if zone is selected
	foreach ( $zone->get_shipping_methods( true ) as $k => $method ) {
		$min_amount = $method->get_option( 'min_amount' );
		if ( $method->id == 'free_shipping' && ! empty( $min_amount ) && $cart_total < $min_amount ) {
			$remaining = $min_amount - $cart_total;
			wc_add_notice( sprintf( 'Add %s more to get free shipping!', wc_price( $remaining ) ) );
		}
	}
	// Show info if price is not calculated just for info
	if (!isset($remaining)){
		$delivery_zones = WC_Shipping_Zones::get_zones();
		foreach ((array) $delivery_zones as $key => $the_zone ) {
		    //echo $the_zone['zone_name'];
			foreach ($the_zone['shipping_methods'] as $method) {
				if ($method->is_enabled()){
					$min_amount = $method->get_option( 'min_amount' );
					// Free shipping method rules
					if ( $method->id == 'free_shipping'){
						// Cart total less then min_amount
						if (! empty( $min_amount ) && $cart_total < $min_amount ) {
							$remaining = $min_amount - $cart_total;
							wc_add_notice( sprintf( 'If you add %s more to get free shipping!', wc_price( $remaining ) ) );
						}
					}
				}
				//echo $value->id;
				//echo $value->get_title();
				// var_dump($value);
			}
		}
	}


}



if ( ! function_exists( 'b4b_woocommerce_before_cart' ) ) {
	/**
	 * Before Check out.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_woocommerce_before_cart() {
		//echo apply_filters('b4b_checkout_step',0);

		b4b_shipping_methods_notice() ;

			
	}
}
add_action( 'woocommerce_before_cart', 'b4b_woocommerce_before_cart', 0 );
if ( ! function_exists( 'woocommerce_before_checkout_form' ) ) {
	/**
	 * Before Check out.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function woocommerce_before_checkout_form() {
		echo apply_filters('b4b_checkout_step',1);	
	
	}
}
//add_action( 'woocommerce_before_checkout_form', 'woocommerce_before_checkout_form', 0 );


if ( ! function_exists( 'b4b_checkout_before' ) ) {
	/**
	 * Before Check out.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_checkout_before() {
		b4b_user_navigation();
		echo apply_filters('b4b_checkout_step',0);
		?>
		<?php
	}
}
add_action( 'b4b_checkout_before', 'b4b_checkout_before', 0 );


add_action( 'b4b_woocommerce_account_navigation', 'b4b_checkout_before', 0 );


if ( ! function_exists( 'b4b_woocommerce_after_checkout' ) ) {
	/**
	 * Before Check out.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function b4b_woocommerce_after_checkout() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_cart', 'b4b_woocommerce_after_checkout', 0 );
add_action( 'woocommerce_after_checkout_form', 'b4b_woocommerce_after_checkout', 0 );



    function b4b_wc_category_description() {
		global $post;
        if ( is_product_category() ) {
            global $wp_query;
            $cat_id = $wp_query->get_queried_object_id();
            $cat_desc = term_description( $cat_id, 'product_cat' );
            $subtit = '<p class="page__description">'.$cat_desc.'</p>';
            echo $subtit;
        }else{
			echo '<p class="page__description">'.__('Odaberite kategoriju proizvoda'). '</p>';
			the_subtitle( '<p class="page__description">', '</p>' );
		}
		if( function_exists( 'the_subtitle' ) && function_exists( 'is_shop' ) && is_shop() ) {
			the_subtitle( '<h2 class="page__description">', '</h2>' );
		}
	}
// 
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description',10 );
add_action( 'woocommerce_archive_description', 'b4b_wc_category_description', 10, 2  );
// remove the action 
//remove_action( 'woocommerce_archive_description', 'action_woocommerce_archive_description', 10, 2 );




remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// Makni  breadcrumb
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);


/* WooCommerce, Cart Item Image */
function b4b_woocommerce_cart_item_thumbnail($product_get_image,  $cart_item="",  $cart_item_key="" ){
	return $product_get_image; 
}

add_action('woocommerce_cart_item_thumbnail','b4b_woocommerce_cart_item_thumbnail',10,3);



/**
 * WooCommerce, Cart Item text
 * 
 * Show Product title
 * 
 */
function b4b_woocommerce_cart_item_name($product_name, $cart_item="", $cart_item_key=""){
	$product_id = $cart_item['product_id'];
	// WC_Product
	$product =  wc_get_product($cart_item['data']->get_id());
	$sales_price = get_post_meta($product_id , '_sale_price', true);
	$regular_price = get_post_meta($product_id , '_regular_price', true);
	$excerpt = $product->get_short_description();
	//$terms = get_the_terms( $product_id, 'product_tag' );
	$termsa = array();
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
		foreach ( $terms as $term ) {
			$tersma[] = $term->slug;
		}
	}
	$attribute =  $product->get_attribute('pakovanje');
	return 
		 '<div class="cart__item-name">'
		. $product->get_title()
		. '</div>'
		. '<p class="cart__item-desc">'
		. $excerpt
		. '</p>'
		. '<div class="cart__item-attribute">'
		. $attribute
		. '</div>';
}
add_filter('woocommerce_cart_item_name','b4b_woocommerce_cart_item_name',10,3);






/**
 * @snippet       Disable Publicize for Products Jetpack
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=21877
 * @author        Rodolfo Melogli
 * @credits       Jeremy Herve
 * @testedwith    WooCommerce 2.6.14
 */
 
function bbloomer_disable_jetpack_publicize_woocommerce() {
    remove_post_type_support( 'product', 'publicize' );
}
 
add_action( 'init1', 'bbloomer_disable_jetpack_publicize_woocommerce' );




/**
 * @snippet       SHOP Master page
 * @how-to       
 * @sourcecode    
 * @author        
 * @credits       
 * @testedwith    WooCommerce 2.6.14
 */


function woocommerce_category_image() {
	/*
		$terms = get_terms( 'product_tag' );
		$term_array = array();
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
			foreach ( $terms as $term ) {
				$term_array[] = $term->name;
			}
		}
	*/
	//var_dump(wp_get_additional_image_sizes());

	$thumbnail_id='';
    if ( is_product_category()  ){
	    global $wp_query;
		$cat = $wp_query->get_queried_object();
		// Get thumbnail
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		$image = wp_get_attachment_url( $thumbnail_id );
		//echo '<div class="page__image">'.wp_get_attachment_image( $thumbnail_id , 'shopcategory' ) . '</div>';
		
	}
	if(!empty($thumbnail_id)){
		echo '<div class="page__image">'.wp_get_attachment_image( $thumbnail_id , 'shopcategory' ) . '</div>';
	}else{
		echo '<div class="page__image">'.get_the_post_thumbnail(get_option( 'woocommerce_shop_page_id'),'shopcategory' ). '</div>';
	}
}
add_action( 'woocommerce_archive_description', 'woocommerce_category_image');


add_action("init", function () {
    // removing the woocommerce hook
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 ); 
	remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);
	
});

// add a new fonction to the hook
add_action("woocommerce_shop_loop_item_title", function () {
	echo the_title('<h4 class="shop-product__title">','</h4>');
});
add_action("woocommerce_after_shop_loop_item_title", function () {
	echo "Dostupne kombinacije:";
	global $product;
    if ( $price_html = $product->get_price_html() ) : ?>
	<div class="shop-product__price"><?php echo $price_html; ?></div>
    <?php
	endif;
	$string ='Nema varijacija'; 
	if ($product->is_type( 'variable' )) 
	{
		$attributes =  $product->get_variation_attributes() ;
		
		if ( $attributes [ 'Pakovanje' ] ) {
			$string ='<div class="shop-product__variations">';
			foreach ($attributes [ 'Pakovanje' ] as $variation){
				$string .='<span>'.$variation.'<span>';
			}
			$string .='<div>';
			
		}
	}
	echo $string;
});





// Shop query
add_action( 'woocommerce_product_query', 'so_27971630_product_query' );

function so_27971630_product_query( $q ){
    $meta_query = $q->get( 'meta_query' );
    $meta_query[] = array(
        'key' => 'custom_acf_key',
        'value' => 'custom_acf_value',
        'compare' => '='
        );

/*
$posts_args = array(
    'post_type'         => 'product',
    'posts_per_page'    => -1,
    'tax_query'         => array(
      'relation' => 'AND',
      array (
          'taxonomy' => 'product_cat',
          'field' => 'slug',
          'terms' => $slug,
      )
    ),
  );
  'tax_query' => array(
     			array(
      				'taxonomy' => 'product_cat', // The taxonomy we want to query
      				'field' => 'slug', // We use the slug to find our terms
      				'terms' => $arr_id // Our comma seperated list of product categories
     			)
  			)

  $posts_query = new WP_Query( $posts_args );

*/
	$taxonomies = array();
	
	if (!empty($_GET['category'])) {
		$categories = explode(',',$_GET['category']);
		$taxonomies[] = array (
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => $categories
		);
	}

	

	
    // https://wordpress.stackexchange.com/questions/25076/how-to-filter-wordpress-search-excluding-post-in-some-custom-taxonomies
	 $taxonomy_query = array('relation' => 'OR', $taxonomies);
	 if (!empty( $taxonomies)) {
	 	$q->set('tax_query', $taxonomy_query);
	 }
   
}