//Display Shipping Options Custom Field in Frontend
add_action( 'woocommerce_after_add_to_cart_button', 'woo_after_single_variation_display_delivery_time_frame' );

function woo_after_single_variation_display_delivery_time_frame(){
    $time_frame = get_post_meta( get_the_ID(), 'delivery_time_frame', true );
      if( $time_frame ){
        echo '</br><p>' .__( 'Estimated delivery time : ', 'wc-dtf' ) . $time_frame . __( ' days', 'wc-dtf' ); '<p/>';
     }
}



//Save Custom Field added to Shipping Options
add_action( 'woocommerce_process_product_meta', 'woo_save_custom_shipping_fields' );

function woo_save_custom_shipping_fields( $post_id ){

	$woocommerce_text_field = $_POST['delivery_time_frame'];
	if( !empty( $woocommerce_text_field ) )
		update_post_meta( $post_id, 'delivery_time_frame', esc_attr( $woocommerce_text_field ) );

        if( empty($woocommerce_text_field)):
            delete_post_meta($post_id,'delivery_time_frame'); 
         endif;

}

//Add Custom Field to Shipping Options
add_action( 'woocommerce_product_options_shipping', 'woo_add_custom_shipping_fields' );

function woo_add_custom_shipping_fields() {

  global $woocommerce, $post;
  
  echo '<div class="options_group">';
  
   woocommerce_wp_text_input( 
	   array( 
 	 	   'id'          => 'delivery_time_frame', 
		   'label'       => __( 'Delivery time frame', 'wc-dtf' ), 
		   'placeholder' => __('Enter value', 'wc-dtf' ),
		   'desc_tip'    => 'true',
		   'description' => __( 'Enter specific number or range of days', 'wc-dtf' ) 
	    )
    );
  
  echo '</div>';
	
}

function cart_notice() {
  if ( arunas_only_virtual_products() ) {
    return true;
  }
  $free_shipping_settings = get_option( 'woocommerce_free_shipping_settings' );
  $maximum = $free_shipping_settings['min_amount'];
  $current = WC()->cart->subtotal;
  $formatteddifference = wc_price( $maximum - $current );
  if (  $current < $maximum ) {
    echo '<div class="woocommerce-message">' . __('Get free shipping if you order for ', 'oxygen') . $formatteddifference . __(' more!', 'oxygen').'</div>';
  }
}
 
add_action( 'woocommerce_cart_contents', 'cart_notice' );
add_action( 'woocommerce_review_order_before_payment', 'cart_notice' );
function arunas_only_virtual_products() {
  $all_virtual_products = false;
  $virtual_products = 0;
  $products = WC()->cart->get_cart();
  // Loop through cart products
  $all_products = sizeof( $products );
  foreach( $products as $product ) {
    $product = wc_get_product( $product['product_id'] );
    if( $product->is_virtual() ) {
      $virtual_products += 1;
    }
  }
  if( $all_products == $virtual_products ) {
    $all_virtual_products = true;
  }
  return $all_virtual_products;
}